<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployerProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required',
            'company_overview' => 'required',
            'industry' => 'required',
            'address' => 'required',
            'profile_picture' => 'image|nullable|max:1999',
            'website_link' => 'nullable|url',
            'company_size' => 'required',
            'benefits' => 'required',
            'dress_code' => 'required',
            'spoken_language' => 'required',
            'work_hours' => 'required',
            'avg_processing_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' =>  'The Company Name field is required.',
            'company_overview.required' =>  'The Company Overview field is required.',
            'industry.required' =>  'The Industry field is required.',
            'address.required' =>  'The Address field is required.',
            'profile_picture.image' =>  'The profile picture must be an image.',
            'profile_picture.uploaded' =>  'Maximum file size for a profile picture is 2MB.',
            'website_link.url' =>  'The link you entered must be a valid URL.',
            'company_size.required' =>  'The Company Size field is required.',
            'benefits.required' =>  'The Benefits field is required.',
            'dress_code.required' =>  'The Dress Code field is required.',
            'spoken_language.required' =>  'The Spoken Language field is required.',
            'work_hours.required' =>  'The Work Hours field is required.',
            'avg_processing_time.required' =>  'The Average Processing Time field is required.',
        ];
    }
}
