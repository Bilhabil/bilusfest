@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Tambah Event</h3>
    @if($errors->any()) <div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
    <div class="card shadow-sm border-0"><div class="card-body">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.events.form')
        </form>
    </div></div>
</div>
@endsection
