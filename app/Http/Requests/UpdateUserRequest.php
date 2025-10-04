<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email'     => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user), // biar gak bentrok sama email user yg sedang diedit
            ],
            'old_password' => ['nullable', 'string'],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'address'   => ['required', 'string'],
            'avatar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'provider'  => ['nullable', 'in:local,google'],
            'provider_id' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isChangingPassword = $this->filled('old_password') || $this->filled('password') || $this->filled('password_confirmation');

            if ($isChangingPassword) {
                if (!$this->filled('old_password') || !$this->filled('password') || !$this->filled('password_confirmation')) {
                    $validator->errors()->add('password', 'Semua field password wajib diisi jika ingin mengganti password.');
                } else {
                    // Cek password lama sesuai database
                    $user = $this->route('user');
                    if (!Hash::check($this->old_password, $user->password)) {
                        $validator->errors()->add('old_password', 'Password lama tidak sesuai.');
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama wajib diisi.',
            'name.max'           => 'Nama maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan oleh pengguna lain.',

            'old_password.required_with' => 'Masukkan password lama untuk mengganti password.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

            'phone.max'          => 'Nomor telepon maksimal 20 karakter.',
            'address.required'   => 'Alamat wajib diisi.',
            'avatar.image'       => 'Avatar harus berupa gambar.',
            'avatar.mimes'       => 'Avatar hanya boleh jpg, jpeg, atau png.',
            'avatar.max'         => 'Avatar maksimal 2MB.',
        ];
    }
}
