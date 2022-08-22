<?php

namespace Modules\CommonModule\Http\Requests;

use App\Rules\AlphaNumSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'time_interval_vendor_accept_min'       => 'sometimes|nullable|integer|min:1',
            'time_interval_user_accept_min'         => 'sometimes|nullable|integer|min:1',
            'time_reminder_before_picked_up'        => 'sometimes|nullable|integer|min:1',
            'time_reminder_before_dropped'          => 'sometimes|nullable|integer|min:1',
            'walk_through_images'                   => 'sometimes|nullable|array',
            'walk_through_images.*.title'           => 'required|array',
            'walk_through_images.*.title.ar'        => ['required', new AlphaNumSpacesRule()],
            'walk_through_images.*.title.en'        => ['required', new AlphaNumSpacesRule()],
            'walk_through_images.*.desc'            => 'required|array',
            'walk_through_images.*.desc.ar'         => ['required', new AlphaNumSpacesRule()],
            'walk_through_images.*.desc.en'         => ['required', new AlphaNumSpacesRule()],
            'home_main_theme'                       => 'sometimes|nullable|image',
            'android_app_version'                   => 'sometimes|nullable|numeric',
            'android_force_updated'                 => 'sometimes|nullable|boolean',
            'android_force_updated_link'            => 'sometimes|nullable|url',
            'ios_app_version'                       => 'sometimes|nullable|numeric',
            'ios_force_updated'                     => 'sometimes|nullable|boolean',
            'ios_force_updated_link'                => 'sometimes|nullable|url',
            'default_country'                       => 'sometimes|nullable|exists:countries,code',
            'default_city'                          => 'sometimes|nullable|exists:cities,code',
            'darbi_percentage'                      => 'sometimes|nullable|numeric',
            'private_jets_images'                   => 'sometimes|nullable|array',
            'private_jets_images.*'                 => 'sometimes|nullable|image',
            'private_jets_title'                    => 'sometimes|nullable|array',
            'private_jets_title.ar'                 => ['sometimes|nullable', new AlphaNumSpacesRule()],
            'private_jets_title.en'                 => ['sometimes|nullable', new AlphaNumSpacesRule()],
            'private_jets_desc'                     => 'sometimes|nullable|array',
            'private_jets_desc.ar'                  => ['sometimes|nullable', new AlphaNumSpacesRule()],
            'private_jets_desc.en'                  => ['sometimes|nullable', new AlphaNumSpacesRule()],
            'private_jets_phone'                    => 'sometimes|nullable|numeric',
            'private_jets_whatsapp'                 => 'sometimes|nullable|numeric',
            'private_jets_email'                    => 'sometimes|nullable|email',
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
