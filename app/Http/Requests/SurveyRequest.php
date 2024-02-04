<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd($this['survey']);
        return [
            'survey.title' => 'required',
            'survey.description' => 'required',
            'survey.answer_limit' => 'required',
            'survey.gender_id' => 'required',
            'survey.min_age' => 'required|integer',
            'survey.max_age' => "required|integer|min:{$this['survey']['min_age']}",
            'form_url' => 'exclude_with:question|required|string',
            'question' => 'exclude_with:form_url|required|array',
            'question.*.body' => 'exclude_with:form_url|required|min:3',
        ];
    }
}
