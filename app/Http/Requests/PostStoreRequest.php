<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'attachment' => ['array|max:4'],
            'attachments.*' => [
                'file',
                File::types(['jpeg', 'jpg', 'png', 'gif', 'webp', 'mp3', 'wav', 'mp4', 'doc', 'docx', 'pdf', 'csv', 'xls', 'xlsx', 'zip', 'rar'])->max(24 * 1024 * 1024)
            ],
            'user_id' => ['numeric']
        ];
    }

    protected function prepareForValidation(): void
    {
        // use model relations instead of this!
        $this->merge([
            'user_id' => auth()->user()->getAuthIdentifier(),
            'body' => $this->input('body') ?: ''
        ]);
    }
}
