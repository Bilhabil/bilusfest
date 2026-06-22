<div class="mb-3">
    <label>Nama Event</label>
    <input type="text" name="name" class="form-control" value="{{ old('name',$event->name ?? '') }}">
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" rows="5">{{ old('description',$event->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Tanggal Event</label>
    <input type="datetime-local" name="event_date" class="form-control"
           value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}">
</div>

<div class="mb-3">
    <label>Lokasi</label>
    <input type="text" name="location" class="form-control" value="{{ old('location',$event->location ?? '') }}">
</div>

<div class="mb-3">
    <label>Banner</label>
    <input type="file" name="banner" class="form-control">
    @if(isset($event) && $event->banner)
        <img src="{{ asset('storage/'.$event->banner) }}" width="150" class="mt-2 rounded">
    @endif
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="active" @selected(old('status',$event->status ?? '') == 'active')>Active</option>
        <option value="inactive" @selected(old('status',$event->status ?? '') == 'inactive')>Inactive</option>
        <option value="finished" @selected(old('status',$event->status ?? '') == 'finished')>Finished</option>
    </select>
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Kembali</a>
