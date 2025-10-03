<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Orders
            'status'            => 'nullable|in:pending,completed,shipped,canceled',
            'shipping_name'     => 'required|string|max:255',
            'shipping_phone'    => 'required|string|max:20',
            'shipping_address'  => 'required|string|max:255',
            'user_id'           => 'required|exists:users,id',

            // Order items (opsional di update)
            'items'                 => 'nullable|array|min:1',
            'items.*.product_id'    => 'sometimes|required|exists:products,id',
            'items.*.quantity'      => 'sometimes|required|integer|min:1',
            // 'items.*.price'         => 'sometimes|required|numeric|min:0',
            // 'items.*.discount_amount' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            // Orders
            'status.in'                 => 'Status hanya boleh: pending, completed, shipped, atau canceled.',
            'shipping_name.required'    => 'Nama penerima wajib diisi.',
            'shipping_phone.required'   => 'Nomor telepon wajib diisi.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'user_id.required'          => 'User wajib dipilih.',
            'user_id.exists'            => 'User tidak ditemukan.',

            // Items
            'items.array'                   => 'Items harus berupa array.',
            'items.min'                     => 'Order minimal harus punya 1 produk.',
            'items.*.product_id.required'   => 'Produk wajib dipilih.',
            'items.*.product_id.exists'     => 'Produk tidak ditemukan.',
            'items.*.quantity.required'     => 'Jumlah wajib diisi.',
            'items.*.quantity.integer'      => 'Jumlah harus berupa angka bulat.',
            'items.*.quantity.min'          => 'Jumlah minimal 1.',
            'items.*.price.required'        => 'Harga wajib diisi.',
            'items.*.price.numeric'         => 'Harga harus berupa angka.',
            'items.*.price.min'             => 'Harga tidak boleh negatif.',
            'items.*.discount_amount.numeric' => 'Diskon harus berupa angka.',
            'items.*.discount_amount.min'     => 'Diskon tidak boleh negatif.',
        ];
    }
}
