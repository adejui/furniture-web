<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
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

                $discount = $item['discount_amount'] ?? 0;
                $subtotal = ($price - $discount) * $item['quantity'];
                $total   += $subtotal;

                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item['product_id'],
                    'quantity'        => $item['quantity'],
                    'price'           => $price,
                    'discount_amount' => $discount,
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
