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
     * Muestra la vista de pago (Checkout) con el resumen del carrito.
     */
    public function checkoutView()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    /**
     * Muestra el historial de compras del usuario actual.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Cargamos los pedidos con sus productos relacionados (Eager Loading)
        $orders = $user->orders()->with('items.book')->orderBy('created_at', 'desc')->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Muestra el detalle de una compra específica.
     */
    public function show(Order $order)
    {
        // Verificamos que el pedido pertenezca al usuario autenticado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }

        $order->load('items.book');
        
        return view('orders.show', compact('order'));
    }

    /**
     * Procesa la compra final de los productos en el carrito.
     */
    public function checkout(Request $request) // <-- AÑADIDO: Request para capturar el formulario
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Tu carrito está vacío.');
        }

        // Iniciamos una transacción para asegurar la integridad de los datos
        DB::beginTransaction();

        try {
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 1. Creamos el registro del Pedido (AHORA GUARDAMOS LA DIRECCIÓN Y EL REGALO)
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'completado',
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_country' => $request->shipping_country,
                'is_gift' => $request->has('is_gift'),
                'gift_email' => $request->gift_email,
            ]);

            // 2. Registramos cada libro comprado y actualizamos el stock
            foreach($cart as $id => $details) {
                $order->items()->create([
                    'book_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);

                $book = Book::find($id);
                
                if ($book) {
                    // Si el libro es físico (no digital), descontamos del inventario
                    if (!$book->is_digital) {
                        if ($book->stock < $details['quantity']) {
                            throw new \Exception("Stock insuficiente para el libro: " . $book->title);
                        }
                        $book->decrement('stock', $details['quantity']);
                    }
                }
            }

            // Confirmamos todos los cambios en la base de datos
            DB::commit();

            // 3. Vaciamos el carrito de la sesión
            session()->forget('cart');

            // Redirigimos a la vista de la factura
            return redirect()->route('orders.show', $order)->with('success', '¡Pedido procesado con éxito!');

        } catch (\Exception $e) {
            // Si algo falla (ej. falta de stock), deshacemos todo
            DB::rollback();
            return redirect()->route('cart.index')->with('error', 'Error en la compra: ' . $e->getMessage());
        }
    }
}