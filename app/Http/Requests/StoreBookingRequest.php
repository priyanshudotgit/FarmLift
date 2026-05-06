<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isFarmer();
    }

    public function rules(): array
    {
        return [
            'trip_id' => 'required|string|exists:trips,_id',
            'weight' => 'required|numeric|min:0.1',
            'produce_type' => 'required|string|max:100',
            'pickup_address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}
