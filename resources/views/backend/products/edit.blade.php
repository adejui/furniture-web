@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Edit Produk</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-lg-6">
                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan nama produk"
                                        value="{{ old('name', $product->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Harga --}}
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" placeholder="Masukkan harga produk"
                                        value="{{ old('price', number_format($product->price, 0, ',', '')) }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" placeholder="Masukkan stok produk"
                                        value="{{ old('stock', $product->stock) }}">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                {{-- Deskripsi --}}
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        placeholder="Masukkan deskripsi produk" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kategori --}}
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select name="category_id" id="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror">
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @empty
                                            <option value="">-- tidak ada category --</option>
                                        @endforelse
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Foto Produk --}}
                        <div class="mb-3">
                            <label class="form-label">Foto Produk (4 Foto)</label>
                            <div><small class="ms-1">Foto kiri atas menjadi thumbnail.</small></div>

                            @php
                                $maxPhotos = 4;
                                $oldImages = $product->productImages ?? collect();
                            @endphp

                            <div class="row">
                                @for ($i = 0; $i < $maxPhotos; $i++)
                                    <div class="col-md-6 mb-3">
                                        @if ($oldImages->get($i))
                                            {{-- Preview foto lama --}}
                                            <div style="margin-bottom: 5px;">
                                                <img src="{{ asset('storage/' . $oldImages[$i]->image_url) }}"
                                                    alt="Foto Produk" class="img-thumbnail"
                                                    style="width:100px; height:100px; object-fit:cover;">
                                            </div>
                                        @endif

                                        {{-- Input file --}}
                                        <input type="file" name="image_url[]" accept="image/*" class="form-control">
                                    </div>
                                @endfor
                            </div>

                            @error('image_url.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
