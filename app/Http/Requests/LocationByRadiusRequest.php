<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property float $radius
 * @property float $latitude
 * @property float $longitude
 */
class LocationByRadiusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'radius' => 'required|numeric',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180'
        ];
    }

    public function messages()
    {
        return [
            'latitude.between' => 'The latitude must be in range between -90 and 90',
            'longitude.between' => 'The longitude mus be in range between -180 and 180'
        ];
    }
}
