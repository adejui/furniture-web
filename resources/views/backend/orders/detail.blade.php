@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Detail Pesanan #{{ $order->id }}</h6>
                </div>
                <div class="card-body">

                    {{-- Informasi Umum --}}
                    <h5 class="fw-bold mb-3">Informasi Pesanan</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">

                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">Pelanggan</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col text-muted">{{ $order->user->name ?? '-' }}</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">Nama Penerima</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col text-muted">{{ $order->shipping_name }}</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">No. Telepon</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col text-muted">{{ $order->shipping_phone }}</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">Alamat</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col text-muted">{{ $order->shipping_address }}</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">Status</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col text-muted"> <span
                                        class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : ($order->status == 'shipped' ? 'info' : 'danger')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span></div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">Total Harga</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col fw-bolder text-success">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-4 fw-bold" style="min-width: 160px;">Tanggal Dibuat</div>
                                <div class="col text-muted" style="max-width: 10px">:</div>
                                <div class="col text-muted">{{ $order->created_at->format('d-m-Y H:i') }}</div>
                            </div>

                        </div>
                    </div>

                    {{-- Item Pesanan --}}
                    <h5 class="fw-bold mb-3 mt-5">Produk yang Dibeli</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="">
                                <tr class="text-center">
                                    <th style="width: 50px;">No</th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder">Produk</th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder">Harga Satuan</th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder">Jumlah</th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
                                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="fw-bold text-end">
                                            Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end pe-3">Total</th>
                                    <th class="text-center">
                                        {{ $order->orderItems->sum('quantity') }}
                                    </th>
                                    <th class="fw-bolder text-success text-end">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('order.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
