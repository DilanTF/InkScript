<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Procesa el carrito y crea un pedido real.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        // 1. VALIDACIÓN PREVIA: Comprobar stock de todos los productos antes de tocar la BD
        foreach($cart as $id => $details) {
            $book = Book::find($id);
            
            // Si no es digital y pedimos más de lo que hay...
            if (!$book->is_digital && $book->stock < $details['quantity']) {
                return back()->with('error', "Lo sentimos, no hay suficiente stock para: {$book->title}. (Disponibles: {$book->stock})");
            }
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }

            // 2. Crear el Pedido
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'completed'
            ]);

            // 3. Crear los ítems y restar stock
            foreach($cart as $id => $details) {
                $book = Book::find($id);

                $order->items()->create([
                    'book_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);

                // Restamos stock (ya sabemos que hay suficiente por la validación previa)
                if (!$book->is_digital) {
                    $book->decrement('stock', $details['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('dashboard')->with('success', '¡Gracias por tu compra! Pedido #' . $order->id . ' procesado.');

        } catch (\Exception $e) {
            DB::rollback();
            // Log::error($e->getMessage()); // Opcional: para que tú veas el error en storage/logs
            return back()->with('error', 'Hubo un error técnico. No se ha realizado ningún cargo.');
        }
    }

    public function index()
    {
        // Obtenemos los pedidos del usuario autenticado con sus ítems y libros relacionados
        $orders = Order::where('user_id', Auth::id())
            ->with('items.book') 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }
}