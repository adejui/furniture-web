@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Tambah Pesanan</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-2">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                {{-- Status --}}
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="">-- pilih status --</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped
                                        </option>
                                        <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>
                                            Canceled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Total Harga --}}
                                <div class="mb-3">
                                    <label for="total_price" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" id="total_price"
                                        value="{{ old('total_price', 0) }}" readonly>
                                </div>

                                {{-- Pilih User --}}
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Pelanggan</label>
                                    <select name="user_id" id="user_id"
                                        class="form-control @error('user_id') is-invalid @enderror">
                                        <option value="">-- pilih pelanggan --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                {{-- Shipping Name --}}
                                <div class="mb-3">
                                    <label for="shipping_name" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control @error('shipping_name') is-invalid @enderror"
                                        id="shipping_name" name="shipping_name" placeholder="Masukkan Nama Penerima"
                                        value="{{ old('shipping_name') }}">
                                    @error('shipping_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Shipping Phone --}}
                                <div class="mb-3">
                                    <label for="shipping_phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('shipping_phone') is-invalid @enderror"
                                        id="shipping_phone" name="shipping_phone" placeholder="Masukkan Nomor Telepon"
                                        value="{{ old('shipping_phone') }}">
                                    @error('shipping_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Shipping Address --}}
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address"
                                        name="shipping_address" placeholder="Masukkan Alamat penerima" rows="5">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Produk yang dibeli --}}
                        <hr>
                        <div id="order-items">
                            <div class="row mb-3 order-item">
                                {{-- Produk --}}
                                <div class="col-md-4">
                                    <label class="form-label">Produk</label>
                                    <select name="items[0][product_id]" class="form-control" onchange="updatePrice(this)">
                                        <option value="">-- pilih produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} (Rp {{ number_format($product->price) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Jumlah --}}
                                <div class="col-md-2">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="items[0][quantity]" class="form-control" value="1"
                                        min="1" oninput="updateSubtotal(this)">
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-6">
                                    <label class="form-label">Harga</label>
                                    <input type="text" name="items[0][price]" class="form-control" value="0"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Tambah Item --}}
                        <div class="mb-3">
                            <button type="button" class="btn btn-success btn-sm" onclick="addItem()">+ Tambah Item</button>
                        </div>

                        <script>
                            let itemIndex = 1;

                            function addItem() {
                                let container = document.getElementById('order-items');
                                let newRow = document.querySelector('.order-item').cloneNode(true);

                                // update name attribute sesuai index baru
                                newRow.querySelectorAll('select, input').forEach(function(el) {
                                    if (el.name.includes('[product_id]')) {
                                        el.name = `items[${itemIndex}][product_id]`;
                                        el.value = "";
                                    }
                                    if (el.name.includes('[quantity]')) {
                                        el.name = `items[${itemIndex}][quantity]`;
                                        el.value = 1;
                                    }
                                    if (el.name.includes('[price]')) {
                                        el.name = `items[${itemIndex}][price]`;
                                        el.value = 0;
                                    }
                                });

                                container.appendChild(newRow);
                                itemIndex++;
                            }

                            function updatePrice(select) {
                                let row = select.closest('.order-item');
                                let priceInput = row.querySelector('input[name$="[price]"]');
                                let selectedOption = select.options[select.selectedIndex];
                                let price = selectedOption.getAttribute('data-price') || 0;
                                let qtyInput = row.querySelector('input[name$="[quantity]"]');
                                priceInput.value = price * (qtyInput.value || 1);
                                updateTotal();
                            }

                            function updateSubtotal(input) {
                                let row = input.closest('.order-item');
                                let priceInput = row.querySelector('input[name$="[price]"]');
                                let select = row.querySelector('select[name$="[product_id]"]');
                                let selectedOption = select.options[select.selectedIndex];
                                let price = selectedOption.getAttribute('data-price') || 0;
                                let quantity = input.value || 1;
                                priceInput.value = price * quantity;
                                updateTotal();
                            }

                            function updateTotal() {
                                let total = 0;
                                document.querySelectorAll('input[name$="[price]"]').forEach(function(input) {
                                    total += parseFloat(input.value) || 0;
                                });
                                document.getElementById('total_price').value = total;
                            }
                        </script>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('order.index') }}" class="btn btn-secondary btn-sm py-2">Kembali</a>
                            <button type="submit" class="btn btn-primary py-2">Simpan</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
