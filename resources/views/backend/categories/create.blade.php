@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Tambah Kategori</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Masukkan nama kategori" value="{{ old('name') }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('category.index') }}" class="btn btn-secondary btn-sm py-2">
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
