<?php

namespace Modules\AdminModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $permissions = config('adminmodule.permissions');

        return [
            'name'          => 'required|max:100',
            'permissions'   => 'required|array',
            'permissions.*' => 'required|in:'.implode(',', $permissions)
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
