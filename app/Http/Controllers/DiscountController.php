<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'discounts' => Discount::paginate(10),
            'menu' => 'Diskon',
            'submenu' => 'Daftar Diskon'
        ];

        return view('backend.discounts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'menu' => 'Diskon',
            'submenu' => 'Tambah Diskon'
        ];

        return view('backend.discounts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            Discount::create($validated);
        });

        return redirect()->route('discount.index')->with('success', 'Diskon baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        $data = [
            'discount' => $discount,
            'menu' => 'Diskon',
            'submenu' => 'Edit Diskon'
        ];

        return view('backend.discounts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        DB::transaction(function () use ($request, $discount) {
            $validated = $request->validated();

            $discount->update($validated);
        });

        return redirect()->route('discount.index')->with('success', 'Diskon berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
