<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'menu' => 'Daftar Pelanggan',
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
