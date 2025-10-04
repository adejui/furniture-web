<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'], // perlu input password_confirmation
            'password_confirmation' => ['required'], // harus ada untuk validasi confirmed
            'phone'     => ['required', 'string', 'max:20'],
            'address'   => ['required', 'string'],
            'avatar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'provider'  => ['nullable', 'in:local,google'],
            'provider_id' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama wajib diisi.',
            'name.max'           => 'Nama maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'phone.required'     => 'Nomor telepon wajib diisi.',
            'phone.max'          => 'Nomor telepon maksimal 20 karakter.',
            'address.required'   => 'Alamat wajib diisi.',
            'avatar.image'       => 'Avatar harus berupa gambar.',
            'avatar.mimes'       => 'Avatar hanya boleh jpg, jpeg, atau png.',
            'avatar.max'         => 'Avatar maksimal 2MB.',
        ];
    }
}
