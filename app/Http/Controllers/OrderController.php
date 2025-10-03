<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = [
            'orders' => Order::paginate(10),
            'menu' => 'Pesanan',
            'submenu' => 'Daftar Pesanan',
        ];

        return view('backend.orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'users' => User::whereNot('role', 'admin')->get(),
            'products' => Product::all(),
            'menu' => 'Pesanan',
            'submenu' => 'Tambah Pesanan',
        ];

        return view('backend.orders.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // dd($request->all());

        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // Buat order dulu
            $order = Order::create([
                'status'            => $validated['status'] ?? 'pending',
                'shipping_name'     => $validated['shipping_name'],
                'shipping_phone'    => $validated['shipping_phone'],
                'shipping_address'  => $validated['shipping_address'],
                'user_id'           => $validated['user_id'],
                'total_price'       => 0, // sementara 0
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                // Ambil harga asli dari DB agar aman (opsional)
                $product = Product::findOrFail($item['product_id']);
                $price   = $product->price;

                $subtotal = $price * $item['quantity'];
                $total   += $subtotal;

                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item['product_id'],
                    'quantity'        => $item['quantity'],
                    'price'           => $price,
                ]);
            }

            // Update total price order
            $order->update(['total_price' => $total]);

            return redirect()->route('order.index')->with('success', 'Pesanan baru berhasil dibuat.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.product', 'user']);

        $data = [
            'order' => $order,
            'menu' => 'Pesanan',
            'submenu' => 'Detail Pesanan',
        ];

        return view('backend.orders.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('orderItems');

        $data = [
            'users' => User::whereNot('role', 'admin')->get(),
            'order' => $order,
            'products' => Product::all(),
            'menu' => 'Pesanan',
            'submenu' => 'Edit Pesanan',
        ];

        return view('backend.orders.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        DB::transaction(function () use ($request, $order) {
            $validated = $request->validated();

            // Update data orders (kecuali items)
            $order->update([
                'status'           => $validated['status'] ?? $order->status,
                'shipping_name'    => $validated['shipping_name'],
                'shipping_phone'   => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'user_id'          => $validated['user_id'],
            ]);

            $total = 0;

            if (!empty($validated['items'])) {
                // Hapus item lama
                $order->orderItems()->delete();

                // Insert item baru
                foreach ($validated['items'] as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $price   = $product->price;

                    $subtotal = $price * $item['quantity'];
                    $total   += $subtotal;

                    $order->orderItems()->create([
                        'product_id' => $item['product_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $price,
                    ]);
                }
            } else {
                // kalau tidak ada items dikirim, total = tetap
                $total = $order->orderItems()->sum(DB::raw('price * quantity'));
            }

            // Update total price order
            $order->update(['total_price' => $total]);
        });

        return redirect()->route('order.index')->with('success', 'Pesanan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {

            // Hapus order_items dulu
            $order->orderItems()->delete();

            // Baru hapus order
            $order->delete();
        });

        return redirect()->route('order.index')
            ->with('destroy', 'Pesanan berhasil dihapus.');
    }
}
