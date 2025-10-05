<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'menu' => 'Pelanggan',
            'submenu' => 'Daftar Pelanggan',
            'users' => User::where('role', '!=', 'admin')->paginate(10),
        ];

        return view('backend.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'menu' => 'Tambah Pelanggan',
            'submenu' => 'Tambah Pelanggan',
        ];

        return view('backend.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // dd($request->all());
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $validated['role'] = 'user';

            // cek apakah ada file avatar
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('users', 'public');
                $validated['avatar'] = $path;
            } else {
                // default avatar
                $validated['avatar'] = 'users/default-avatar.png';
            }

            User::create($validated);
        });

        return redirect()->route('user.index')->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $data = [
            'user' => $user,
            'menu' => 'Detail Pelanggan',
            'submenu' => 'Detail Pelanggan',
        ];

        return view('backend.users.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = [
            'user' => $user,
            'menu' => 'Edit Pelanggan',
            'submenu' => 'Edit Pelanggan',
        ];

        return view('backend.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            // Ambil data yang sudah tervalidasi dari Form Request
            $validated = $request->validated();

            // ======== LOGIKA PASSWORD ======== //
            $isChangingPassword = $request->filled('old_password') || $request->filled('password') || $request->filled('password_confirmation');

            if ($isChangingPassword) {
                // Semua field wajib diisi
                if (!$request->filled('old_password') || !$request->filled('password') || !$request->filled('password_confirmation')) {
                    return back()->withErrors(['password' => 'Semua field password wajib diisi jika ingin mengganti password.'])->withInput();
                }

                // Cek apakah password lama cocok
                if (!Hash::check($request->old_password, $user->password)) {
                    return back()->withErrors(['old_password' => 'Password lama tidak sesuai.'])->withInput();
                }

                // Hash password baru dan masukkan ke array validated
                $validated['password'] = bcrypt($request->password);
            } else {
                // Kalau tidak mau ganti password, hapus field-nya
                unset($validated['password']);
            }

            // ======== LOGIKA AVATAR ======== //
            if ($request->hasFile('avatar')) {
                // hapus foto lama (kecuali default)
                if ($user->avatar && $user->avatar !== 'users/default-avatar.png') {
                    Storage::disk('public')->delete($user->avatar);
                }

                // simpan foto baru
                $validated['avatar'] = $request->file('avatar')->store('users', 'public');
            }

            // ======== UPDATE USER ======== //
            $user->update($validated);

            DB::commit();
            return redirect()->route('user.index')->with('success', 'Data pelanggan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);

            // Hapus foto user dari storage jika bukan default
            if ($user->avatar && $user->avatar !== 'users/default-avatar.png') {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            // Hapus user dari database
            $user->delete();
        });

        return redirect()->route('user.index')
            ->with('destroy', 'Pelanggan berhasil dihapus.');
    }
}
