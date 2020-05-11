<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveApplicantProfile extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'country' => 'required',
            'nationality' => 'required',
            'mobile_phone_no' => array(
                'required',
                'unique:applicant_infos,mobile_phone_no',
                'size: 11',
                'regex:/^09(?!(?:[0][0-4]|[8][34678]|[9][01])[0-9]{7}$)\d+/'
            ),
            'profile_picture' => 'image|nullable|max:1999',
            'resume' => 'mimes:pdf|nullable|max:1999',
            'job_title' => 'required',
            'company_name' => 'required',
            'start_date' => 'required',
            'currency' => 'required',
            'salary' => 'required',
            'tasks' => 'required',
            'university' => 'required',
            'degree' => 'required',
            'course' => 'required',
            'univ_start_date' => 'required',
            'univ_end_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' =>  'The First Name field is required.',
            'last_name.required' =>  'The Last Name field is required.',
            'age.required' =>  'The Age field is required.',
            'gender.required' =>  'The Gender field is required.',
            'address.required' =>  'The Address field is required.',
            'country.required' =>  'The Country field is required.',
            'nationality.required' =>  'The Nationality field is required.',
            'mobile_phone_no.required' =>  'The Phone Number field is required.',
            'mobile_phone_no.unique' =>  'The phone number you entered has already been used.',
            'mobile_phone_no.size' =>  'The phone number must be 11 digits.',
            'mobile_phone_no.regex' =>  'The phone number must be a valid phone number in the Philippines.',
            'profile_picture.image' =>  'The profile picture must be an image.',
            'profile_picture.uploaded' =>  'Maximum file size for a profile picture is 2MB.',
            'resume.mimes' => 'The filename uploaded must be a file type of .pdf',
            'resume.uploaded' =>  'Maximum file size for a resume is 2MB.',
            'job_title.required' =>  'The Job Title field is required.',
            'company_name.required' =>  'The Company Name field is required.',
            'start_date.required' =>  'The Start Date field is required.',
            'mobile_phone_no.required' =>  'The Phone Number field is required.',
            'currency.required' =>  'The Currency field is required.',
            'salary.required' =>  'The Salary field is required.',
            'tasks.required' =>  'The Tasks field is required.',
            'university.required' =>  'The University field is required.',
            'degree.required' =>  'The Degree field is required.',
            'course.required' =>  'The Course field is required.',
            'univ_start_date.required' =>  'The Start Date (University/College) field is required.',
            'univ_end_date.required' =>  'The Date of Graduation field is required.',
        ];
    }
}
