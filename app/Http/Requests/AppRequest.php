<?php

namespace App\Http\Requests;

use App\Rules\TextRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AppRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('excuse')) {
            $this->merge([
                'excuse' => Str::squish($this->excuse),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'excuse' => ['required', 'min:10', 'max:250', new TextRule],
            'tone' => ['required', Rule::in(['formal', 'friendly', 'casual'])],
            'language' => ['required', Rule::in(['english', 'taglish', 'tagalog'])],
        ];
    }
}
