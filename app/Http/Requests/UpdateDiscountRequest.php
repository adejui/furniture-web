<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'value'         => 'required|numeric|min:0',
            'start_date'    => 'required|date|before_or_equal:end_date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'is_active'     => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Nama diskon wajib diisi.',
            'name.string'            => 'Nama diskon harus berupa teks.',
            'name.max'               => 'Nama diskon tidak boleh lebih dari 255 karakter.',

            'description.string'     => 'Deskripsi harus berupa teks.',

            'discount_type.required' => 'Tipe diskon wajib dipilih.',
            'discount_type.in'       => 'Tipe diskon harus salah satu dari: percentage atau fixed.',

            'value.required'         => 'Nilai diskon wajib diisi.',
            'value.numeric'          => 'Nilai diskon harus berupa angka.',
            'value.min'              => 'Nilai diskon tidak boleh kurang dari 0.',

            'start_date.required'    => 'Tanggal mulai wajib diisi.',
            'start_date.date'        => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',

            'end_date.required'      => 'Tanggal selesai wajib diisi.',
            'end_date.date'          => 'Tanggal selesai harus berupa format tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',

            'is_active.required'     => 'Status aktif/tidak aktif wajib dipilih.',
            'is_active.boolean'      => 'Status harus bernilai 1 (aktif) atau 0 (tidak aktif).',
        ];
    }
}
