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
        dd($this);
        return [
            'survey.title' => 'required',
            'survey.description' => 'required',
            'survey.answer_limit' => 'required',
            'survey.gender_id' => 'required',
            'survey.min_age' => 'required|integer',
            'survey.max_age' => "required|integer|min:{$this['survey']['min_age']}",
            'survey.form_url' => 'exclude_unless:question_type,forms_type|required|url',
            'question' => 'exclude_unless:question_type,default_type|required|array',
            'question.*.body' => 'exclude_unless:question_type,default_type|required|min:3',
        ];
    }
    
    // public function withValidator($validator)
    // {
    //     $form_url = $this->input('survey.form_url');
    //     $question = $this->input('question');
    //     $validator->after(function ($validator) {
            
    //     });
    // }
}
