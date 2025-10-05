@extends('backend.layouts.app') {{-- atau layout kamu sendiri --}}

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white">Informasi Pengguna</h5>
            </div>
            <div class="card-body">
                <div class="align-items-center">
                    {{-- FOTO PROFIL --}}
                    <div class="col-md-3 text-center mb-3">
                        @php
                            $avatar = $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : asset('storage/users/default-avatar.png');
                        @endphp

                        <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle shadow" width="200"
                            height="200">
                    </div>

                    {{-- INFORMASI USER --}}
                    <div class="col-md-9">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="30%">Nama</th>
                                <td>: {{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>: {{ $user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: {{ $user->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Bergabung</th>
                                <td>: {{ $user->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diperbarui</th>
                                <td>: {{ $user->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                {{-- TOMBOL AKSI --}}
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
