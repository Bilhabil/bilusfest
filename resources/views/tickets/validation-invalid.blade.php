@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-danger">
        <div class="card-body text-center">
            <h3 class="text-danger">Tiket Tidak Valid</h3>
            <p>{{ $message }}</p>
        </div>
    </div>
</div>
@endsection
