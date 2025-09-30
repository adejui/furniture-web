@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Tambah Produk</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" placeholder="Masukkan harga produk"
                                        value="{{ old('price') }}">

                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" placeholder="Masukkan stok produk"
                                        value="{{ old('stock') }}">

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Foto -->
                                <div class="mb-3">
                                    <label class="form-label">Foto Produk (4 Foto)</label>
                                    <div><small class="ms-1">Foto paling atas menjadi thumbnail.</small></div>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <input type="file" name="image_url[]" multiple accept="image/*"
                                            class="form-control mb-2">
                                    @endfor
                                    @error('image_url.*')
                                        <small class="text-danger">{{ $message }}</small>
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
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select name="category_id" id="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">-- pilih kategori --</option>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @empty
                                            <option value="">-- tidak ada category --</option>
                                        @endforelse
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="discount_id" class="form-label">Diskon</label>
                                    <select name="discount_id" id="discount_id"
                                        class="form-control @error('discount_id') is-invalid @enderror">
                                        <option value="">-- pilih diskon --</option>
                                        <option value="0">Tanpa Diskon</option>
                                        @forelse ($discounts as $discount)
                                            <option value="{{ $discount->id }}">{{ $discount->name }} -
                                                {{ $discount->formatted_value }}</option>
                                        @empty
                                            <option value="">-- tidak ada diskon --</option>
                                        @endforelse
                                    </select>
                                    @error('discount_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
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
