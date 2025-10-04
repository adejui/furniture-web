@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Edit Pelanggan</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan nama"
                                        value="{{ old('name', $user->name) }}">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan email"
                                        value="{{ old('email', $user->email) }}">

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">No HP</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="Masukkan no HP"
                                        value="{{ old('phone', $user->phone) }}">

                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Kata Sandi Lama</label>
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                        id="old_password" name="old_password" placeholder="Masukkan kata sandi lama"
                                        value="{{ old('old_password') }}">
                                    <p style="font-size: 12px; margin-bottom: 0px;">Kosongin jika
                                        tidak ingin mengubah
                                        kata sandi</p>
                                    @error('old_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi Baru</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan kata sandi baru"
                                        value="{{ old('password') }}">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Konfirmasi kata sandi baru"
                                        value="{{ old('password_confirmation') }}">

                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Foto</label>

                                    {{-- Preview Foto Default --}}
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="img-thumbnail"
                                            width="120" height="120" id="avatar-preview">
                                    </div>

                                    {{-- Input Upload --}}
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                        id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">

                                    @error('avatar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                        placeholder="Masukkan alamat" rows="5">{{ old('address', $user->address) }}</textarea>

                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>


                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm py-2">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary py-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Script Preview Realtime --}}
<script>
    function previewAvatar(event) {
        let reader = new FileReader();
        reader.onload = function() {
            document.getElementById('avatar-preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
