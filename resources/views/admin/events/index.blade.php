@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Manajemen Event</h3>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Tambah Event</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead><tr><th>Banner</th><th>Nama</th><th>Tanggal</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>@if($event->banner)<img src="{{ asset('storage/'.$event->banner) }}" width="90">@else - @endif</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->event_date->format('d M Y H:i') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->status }}</td>
                            <td>
                                <a href="{{ route('admin.events.show',$event) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('admin.events.edit',$event) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.events.destroy',$event) }}" method="POST" class="d-inline delete-form">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada event.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
