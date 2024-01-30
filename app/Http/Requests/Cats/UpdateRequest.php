<?php

namespace App\Http\Requests\Cats;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'full_name'    => 'sometimes|required|string|max:255',
            'gender_id'   => 'sometimes|required|numeric',
            'dob'         => 'nullable|date|date_format:Y-m-d',
            'titles_before_name'     => 'nullable|string|max:255',
            'titles_after_name'     => 'nullable|string|max:255',
            'ems_color'     => 'nullable|string|max:255',
            'breed'     => 'nullable|string|max:255',
            'genetic_tests'     => 'nullable|string|max:255',
            'chip_number'     => 'nullable|string|max:255',
            'registration_numbers'     => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function validated()
    {
        $formData = parent::validated();

        $formData['yob'] = $this->getYob($formData);

        return $formData;
    }

    private function getYob($formData)
    {
        if (isset($formData['yob'])) {
            return $formData['yob'];
        }

        if (isset($formData['dob']) && $formData['dob']) {
            return substr($formData['dob'], 0, 4);
        }

        return;
    }
}
