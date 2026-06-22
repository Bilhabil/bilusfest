<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'active')->latest()->paginate(9);

        return view('user.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['ticketCategories' => function ($query) {
            $query->where('status', 'active');
        }]);

        return view('user.events.show', compact('event'));
    }
}
