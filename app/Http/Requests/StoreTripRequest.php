<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isDriver();
    }

    public function rules(): array
    {
        return [
            'origin_name' => 'required|string|max:255',
            'origin_lng' => 'required|numeric',
            'origin_lat' => 'required|numeric',
            'destination_name' => 'required|string|max:255',
            'destination_lng' => 'required|numeric',
            'destination_lat' => 'required|numeric',
            'departure_date' => 'required|date|after:now',
            'total_capacity' => 'required|numeric|min:0.1',
            'price_per_ton' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ];
    }
}
