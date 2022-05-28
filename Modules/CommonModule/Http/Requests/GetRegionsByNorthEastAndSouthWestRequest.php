<?php

namespace Modules\CommonModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetRegionsByNorthEastAndSouthWestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mapBounds'                 => 'required|array|size:2',
            'mapBounds.northEast'       => 'required|array|size:2',
            'mapBounds.southWest'       => 'required|array|size:2',
            'mapBounds.northEast.lat'   => 'required|numeric',
            'mapBounds.northEast.lng'   => 'required|numeric',
            'mapBounds.southWest.lat'   => 'required|numeric',
            'mapBounds.southWest.lng'   => 'required|numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
