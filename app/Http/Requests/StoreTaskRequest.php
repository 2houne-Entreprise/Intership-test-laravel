<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'deadline' => ['nullable', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,txt,doc,docx', 'max:5120'],
        ];
    }
}
