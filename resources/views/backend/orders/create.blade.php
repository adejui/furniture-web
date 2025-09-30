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
                                    <input type="text" class="form-control" id="total_price" value="0" readonly>
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
                                    <input type="text" name="shipping_name" id="shipping_name"
                                        class="form-control @error('shipping_name') is-invalid @enderror"
                                        placeholder="Masukkan Nama Penerima" value="{{ old('shipping_name') }}">
                                    @error('shipping_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Shipping Phone --}}
                                <div class="mb-3">
                                    <label for="shipping_phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" name="shipping_phone" id="shipping_phone"
                                        class="form-control @error('shipping_phone') is-invalid @enderror"
                                        placeholder="Masukkan Nomor Telepon" value="{{ old('shipping_phone') }}">
                                    @error('shipping_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Shipping Address --}}
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Alamat</label>
                                    <textarea name="shipping_address" id="shipping_address"
                                        class="form-control @error('shipping_address') is-invalid @enderror" placeholder="Masukkan Alamat penerima"
                                        rows="5">{{ old('shipping_address') }}</textarea>
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
                                <div class="col-md-3">
                                    <label class="form-label">Produk</label>
                                    <select name="items[0][product_id]" class="form-control" onchange="updatePrice(this)">
                                        <option value="">-- pilih produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                data-discount-type="{{ $product->discount?->discount_type ?? '' }}"
                                                data-discount-value="{{ $product->discount?->value ?? 0 }}"
                                                data-discount-active="{{ $product->discount?->is_active ?? 0 }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Harga Asli --}}
                                <div class="col-md-3">
                                    <label class="form-label">Harga Asli</label>
                                    <input type="text" name="items[0][original_price]" class="form-control"
                                        value="0" readonly>
                                </div>

                                {{-- Jumlah --}}
                                <div class="col-md-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="items[0][quantity]" class="form-control" value="1"
                                        min="1" oninput="updateSubtotal(this)">
                                </div>

                                {{-- Harga Akhir --}}
                                <div class="col-md-3">
                                    <label class="form-label">Harga Akhir</label>
                                    <input type="text" name="items[0][price]" class="form-control" value="0"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-success btn-sm" onclick="addItem()">+ Tambah
                                Item</button>
                        </div>

                        <script>
                            let itemIndex = 1;

                            function addItem() {
                                let container = document.getElementById('order-items');
                                let newRow = document.querySelector('.order-item').cloneNode(true);

                                newRow.querySelectorAll('select, input').forEach(function(el) {
                                    if (el.name.includes('[product_id]')) el.name = `items[${itemIndex}][product_id]`;
                                    if (el.name.includes('[quantity]')) el.name = `items[${itemIndex}][quantity]`;
                                    if (el.name.includes('[price]')) el.name = `items[${itemIndex}][price]`;
                                    if (el.name.includes('[original_price]')) el.name = `items[${itemIndex}][original_price]`;
                                    el.value = el.type === 'number' ? 1 : '';
                                });

                                container.appendChild(newRow);
                                itemIndex++;
                            }

                            function calculateFinalPrice(price, type, value, isActive) {
                                if (!isActive) return price;
                                if (type === 'percentage') return price - (price * value / 100);
                                if (type === 'fixed') return Math.max(price - value, 0);
                                return price;
                            }

                            function updatePrice(select) {
                                let row = select.closest('.order-item');
                                let priceInput = row.querySelector('input[name$="[price]"]');
                                let originalPriceInput = row.querySelector('input[name$="[original_price]"]');
                                let selectedOption = select.options[select.selectedIndex];

                                let originalPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                                let discountType = selectedOption.getAttribute('data-discount-type');
                                let discountValue = parseFloat(selectedOption.getAttribute('data-discount-value')) || 0;
                                let discountActive = parseInt(selectedOption.getAttribute('data-discount-active')) || 0;
                                let quantity = parseInt(row.querySelector('input[name$="[quantity]"]').value) || 1;

                                let finalPrice = calculateFinalPrice(originalPrice, discountType, discountValue, discountActive);

                                originalPriceInput.value = originalPrice;
                                priceInput.value = finalPrice * quantity;

                                updateTotal();
                            }

                            function updateSubtotal(input) {
                                let row = input.closest('.order-item');
                                let select = row.querySelector('select[name$="[product_id]"]');
                                let selectedOption = select.options[select.selectedIndex];

                                let originalPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                                let discountType = selectedOption.getAttribute('data-discount-type');
                                let discountValue = parseFloat(selectedOption.getAttribute('data-discount-value')) || 0;
                                let discountActive = parseInt(selectedOption.getAttribute('data-discount-active')) || 0;
                                let quantity = parseInt(input.value) || 1;

                                let finalPrice = calculateFinalPrice(originalPrice, discountType, discountValue, discountActive);
                                row.querySelector('input[name$="[price]"]').value = finalPrice * quantity;

                                updateTotal();
                            }

                            function updateTotal() {
                                let total = 0;
                                document.querySelectorAll('input[name$="[price]"]').forEach(input => {
                                    total += parseFloat(input.value) || 0;
                                });
                                document.getElementById('total_price').value = total;
                            }

                            // Hitung harga awal saat load halaman
                            document.querySelectorAll('select[name$="[product_id]"]').forEach(select => {
                                if (select.value) updatePrice(select);
                            });
                            updateTotal();
                        </script>

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
