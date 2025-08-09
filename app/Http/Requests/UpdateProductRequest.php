<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        // Ambil ID produk yang sedang diupdate dari route binding
        $productId = $this->route('product')->id ?? null;

        return [
            'name'        => 'required|string|max:255|unique:products,name,' . $productId,
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',

            // Foto produk (opsional saat update)
            'image_url'   => 'nullable|array|max:4', // Boleh kosong, maksimal 4 foto
            'image_url.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validasi tiap file jika diisi
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string'   => 'Nama produk harus berupa teks.',
            'name.max'      => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'name.unique'   => 'Nama ini sudah digunakan, silakan gunakan yang lain.',

            'image_url.array'    => 'Format input foto tidak valid.',
            'image_url.max'      => 'Maksimal 4 foto yang diperbolehkan.',
            'image_url.*.image'  => 'File harus berupa gambar.',
            'image_url.*.mimes'  => 'Format gambar hanya diperbolehkan: jpg, jpeg, png, gif, webp.',
            'image_url.*.max'    => 'Ukuran gambar maksimal 2MB.',

            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',

            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric'  => 'Harga produk harus berupa angka.',
            'price.min'      => 'Harga produk tidak boleh kurang dari 0.',

            'stock.required' => 'Stok produk wajib diisi.',
            'stock.integer'  => 'Stok produk harus berupa angka bulat.',
            'stock.min'      => 'Stok produk tidak boleh kurang dari 0.',

            'description.string' => 'Deskripsi produk harus berupa teks.',
        ];
    }
}
