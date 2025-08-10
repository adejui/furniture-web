<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = [
            'products' => Product::paginate(10),
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
        $product->load('productImages');

        $data = [
            'categories' => Category::all(),
            'menu'       => 'Produk',
            'submenu'    => 'Edit Produk',
            'product'    => $product,
        ];

        return view('backend.products.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['name']);

            // Update data produk
            $product->update($validated);

            // Cek kalau ada gambar baru
            if ($request->hasFile('image_url')) {
                // 1. Hapus semua gambar lama dari storage
                foreach ($product->productImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage->image_url)) {
                        Storage::disk('public')->delete($oldImage->image_url);
                    }
                }

                // 2. Hapus data gambar lama dari database
                $product->productImages()->delete();

                // 3. Simpan gambar baru
                foreach ($request->file('image_url') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url'  => $path,
                        'is_main'    => $index === 0 ? 1 : 0 // gambar pertama jadi utama
                    ]);
                }
            }
        });

        return redirect()
            ->route('product.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            // Hapus semua foto produk dari storage
            foreach ($product->productImages as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }

            // Hapus data gambar dari database
            $product->productImages()->delete();

            // Hapus data produk
            $product->delete();
        });

        return redirect()->route('product.index')
            ->with('destroy', 'Produk berhasil dihapus.');
    }
}
