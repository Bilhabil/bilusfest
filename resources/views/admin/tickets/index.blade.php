@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Manajemen Tiket</h3>
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">Tambah Tiket</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead><tr><th>Event</th><th>Kategori</th><th>Harga</th><th>Kuota</th><th>Terjual</th><th>Sisa</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->event->name }}</td>
                            <td>{{ $ticket->name }}</td>
                            <td>Rp {{ number_format($ticket->price,0,',','.') }}</td>
                            <td>{{ $ticket->quota }}</td>
                            <td>{{ $ticket->sold }}</td>
                            <td>{{ $ticket->quota - $ticket->sold }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>
                                <a href="{{ route('admin.tickets.show',$ticket) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('admin.tickets.edit',$ticket) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.tickets.destroy',$ticket) }}" method="POST" class="d-inline delete-form">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Belum ada tiket.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection
