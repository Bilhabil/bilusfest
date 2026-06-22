<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventRepository
{
    public function getAll()
    {
        return Event::latest()->paginate(10);
    }

    public function store(array $data): Event
    {
        if (isset($data['banner'])) {
            $data['banner'] = $data['banner']->store('events', 'public');
        }

        return Event::create($data);
    }

    public function update(Event $event, array $data): bool
    {
        if (isset($data['banner'])) {
            if ($event->banner) {
                Storage::disk('public')->delete($event->banner);
            }

            $data['banner'] = $data['banner']->store('events', 'public');
        }

        return $event->update($data);
    }

    public function delete(Event $event): bool
    {
        if ($event->banner) {
            Storage::disk('public')->delete($event->banner);
        }

        return $event->delete();
    }
}
