@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Tambah Diskon</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ route('discount.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan nama produk"
                                        value="{{ old('name') }}">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="discount_type" class="form-label">Tipe</label>
                                    <select name="discount_type" id="discount_type"
                                        class="form-control @error('discount_type') is-invalid @enderror">
                                        <option value="">-- pilih tipe diskon --</option>
                                        <option value="percentage">Diskon Persentasi</option>
                                        <option value="fixed">Diskon Tetap(Rp)</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="value" class="form-label">Diskon</label>
                                    <input type="text" class="form-control @error('value') is-invalid @enderror"
                                        id="value" name="value" placeholder="Masukkan harga produk"
                                        value="{{ old('value') }}">
                                    <div><small>Pakai . (titik) jika pecahan</small></div>

                                    @error('value')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select name="is_active" id="is_active"
                                        class="form-control @error('is_active') is-invalid @enderror">
                                        <option value="">-- pilih status --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        placeholder="Masukkan deskripsi produk" rows="5">{{ old('description') }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                                        class="form-control @error('start_date') is-invalid @enderror">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                                        class="form-control @error('end_date') is-invalid @enderror">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm py-2">
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
