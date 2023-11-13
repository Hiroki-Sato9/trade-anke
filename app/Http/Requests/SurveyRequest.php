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
        return [
            'survey.title' => 'required',
            'survey.description' => 'required',
            'survey.answer_limit' => 'required',
            'question' => 'required|array',
            'question.*.body' => 'required',
        ];
    }
}
