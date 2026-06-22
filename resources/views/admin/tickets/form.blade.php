<div class="mb-3">
    <label>Event</label>
    <select name="event_id" class="form-control">
        <option value="">-- Pilih Event --</option>
        @foreach($events as $event)
            <option value="{{ $event->id }}" @selected(old('event_id',$ticket->event_id ?? '') == $event->id)>
                {{ $event->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Kategori Tiket</label>
    <select name="name" class="form-control">
        <option value="VIP" @selected(old('name',$ticket->name ?? '') == 'VIP')>VIP</option>
        <option value="Festival" @selected(old('name',$ticket->name ?? '') == 'Festival')>Festival</option>
        <option value="Early Bird" @selected(old('name',$ticket->name ?? '') == 'Early Bird')>Early Bird</option>
        <option value="Presale" @selected(old('name',$ticket->name ?? '') == 'Presale')>Presale</option>
    </select>
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number" name="price" class="form-control" value="{{ old('price',$ticket->price ?? '') }}">
</div>

<div class="mb-3">
    <label>Kuota</label>
    <input type="number" name="quota" class="form-control" value="{{ old('quota',$ticket->quota ?? '') }}">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="active" @selected(old('status',$ticket->status ?? '') == 'active')>Active</option>
        <option value="inactive" @selected(old('status',$ticket->status ?? '') == 'inactive')>Inactive</option>
        <option value="sold_out" @selected(old('status',$ticket->status ?? '') == 'sold_out')>Sold Out</option>
    </select>
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Kembali</a>
