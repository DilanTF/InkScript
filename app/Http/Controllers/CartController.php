<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Muestra el contenido del carrito.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calculamos el total aquí para enviarlo a la vista
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Añade un libro al carrito almacenado en la sesión.
     */
    public function add(Request $request)
    {
        // Validamos, pero permitimos que quantity sea opcional (default 1)
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $book = Book::find($request->book_id);
        $quantity = $request->input('quantity', 1); // Si no viene cantidad, asumimos 1
        
        // VALIDACIÓN EXTRA: No dejar añadir más de lo que hay en stock si es físico
        if (!$book->is_digital && $book->stock < $quantity) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$book->id])) {
            $cart[$book->id]['quantity'] += $quantity;
        } else {
            $cart[$book->id] = [
                "id" => $book->id,
                "title" => $book->title,
                "quantity" => $quantity,
                "price" => $book->price,
                "image" => $book->image,
                "is_digital" => $book->is_digital
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', '¡' . $book->title . ' añadido al carrito!');
    }

    /**
     * Elimina un producto específico del carrito.
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            
            return back()->with('success', 'Producto eliminado del carrito.');
        }
    }

    /**
     * Vacía todo el contenido del carrito.
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'El carrito se ha vaciado correctamente.');
    }

    /**
     * Actualiza la cantidad de un producto desde la vista del carrito.
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Carrito actualizado.');
        }
    }
}