@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fs-4 fw-bolder">Daftar Pesanan</h6>
                    <a href="{{ route('order.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Pesanan
                    </a>
                </div>

                <div class="px-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show fw-bold" role="alert"
                            style="background-image: none;">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="px-4">
                    @if (session('destroy'))
                        <div class="alert alert-danger alert-dismissible fade show fw-bold" role="alert"
                            style="background-image: none;">
                            {{ session('destroy') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder max-w-5">
                                        No
                                    </th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder">
                                        Pelanggan
                                    </th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder ps-2">
                                        No. HP
                                    </th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder ps-2">
                                        Total Harga
                                    </th>
                                    <th class="text-center text-uppercase text-black text-xs font-weight-bolder ps-2">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-black text-xs font-weight-bolder">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="px-4 align-middle max-w-5">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $order->user->name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $order->shipping_phone }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-secondary text-xs font-weight-bold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle justify-center text-center text-sm flex">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-warning fw-bold text-xs text-dark',
                                                    'completed' => 'bg-success fw-bold text-xs text-white',
                                                    'shipped' => 'bg-primary fw-bold text-xs text-white',
                                                    'canceled' => 'bg-danger fw-bold text-xs text-white',
                                                ];
                                                $statusClass =
                                                    $statusColors[strtolower($order->status)] ??
                                                    'bg-secondary text-white';
                                            @endphp

                                            <span class="px-2 py-1 rounded {{ $statusClass }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <td class="align-middle pt-4 justify-center text-center text-sm flex">
                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-info btn-sm">
                                                Detail
                                            </a>

                                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('order.destroy', $order->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-dark text-center py-3 text-lg" colspan="7">Belum ada Pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="px-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
