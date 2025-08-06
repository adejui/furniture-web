@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-3">
                    <h6>Daftar Kategori</h6>
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
                                        Nama
                                    </th>
                                    <th class="text-uppercase text-black text-xs font-weight-bolder ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-center text-uppercase text-black text-xs font-weight-bolder">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td class="px-4 align-middle max-w-5">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $category->name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $category->created_at }}</span>
                                        </td>
                                        <td class="align-middle justify-center gap-2 text-center text-sm flex">
                                            <a href="{{ route('category.edit', $category->slug) }}"
                                                class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-xs font-medium">
                                                Edit
                                            </a>

                                            <form action="{{ route('category.destroy', $category->slug) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-block bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
