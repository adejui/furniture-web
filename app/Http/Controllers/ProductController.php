<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = [
            'products' => Product::all(),
            'menu' => 'Produk',
            'submenu' => 'Daftar Produk',
        ];

        return view('backend.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'categories' => Category::all(),
            'menu' => 'Produk',
            'submenu' => 'Tambah Produk',
        ];

        return view('backend.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());

        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $validated['slug'] = Str::slug($validated['name']);

            $product = Product::create($validated);

            // Simpan gambar
            if ($request->hasFile('image_url')) {
                foreach ($request->file('image_url') as $index => $file) {
                    if ($file) {
                        $path = $file->store('products', 'public');

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_url' => $path,
                            'is_main'    => $index === 0 ? 1 : 0, // gambar pertama is_main = 1
                        ]);
                    }
                }
            }
        });

        return redirect()->route('product.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
