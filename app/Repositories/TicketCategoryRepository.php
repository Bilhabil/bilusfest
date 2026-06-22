<?php

namespace App\Repositories;

use App\Models\TicketCategory;

class TicketCategoryRepository
{
    public function getAll()
    {
        return TicketCategory::with('event')->latest()->paginate(10);
    }

    public function store(array $data)
    {
        $data['sold'] = 0;

        return TicketCategory::create($data);
    }

    public function update(TicketCategory $ticketCategory, array $data)
    {
        return $ticketCategory->update($data);
    }

    public function delete(TicketCategory $ticketCategory)
    {
        return $ticketCategory->delete();
    }
}
