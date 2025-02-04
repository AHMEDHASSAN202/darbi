<?php

namespace Modules\AuthModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use function config;

class CreateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $permissions = @config('authmodule.permissions.'.$this->request->get('guard')) ?? [];

        return [
            'name'          => 'required|max:100',
            'permissions'   => 'required|array',
            'permissions.*' => 'required|in:'.implode(',', $permissions),
            'guard'         => 'required|in:admin_api,vendor_api'
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
