<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama diskon wajib diisi.',
            'name.max' => 'Nama diskon tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi diskon wajib diisi.',

            'discount_type.required' => 'Tipe diskon wajib dipilih.',
            'discount_type.in' => 'Tipe diskon hanya boleh percentage atau fixed.',

            'value.required' => 'Nilai diskon wajib diisi.',
            'value.numeric' => 'Nilai diskon harus berupa angka.',
            'value.min' => 'Nilai diskon tidak boleh kurang dari 0.',

            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal berakhir.',

            'end_date.required' => 'Tanggal berakhir wajib diisi.',
            'end_date.date' => 'Tanggal berakhir harus berupa format tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',

            'is_active.required' => 'Status aktif wajib diisi.',
            'is_active.boolean' => 'Status aktif harus berupa true atau false.',
        ];
    }
}
