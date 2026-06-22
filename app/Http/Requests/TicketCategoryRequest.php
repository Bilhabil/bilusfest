<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,sold_out',
        ];
    }
}
