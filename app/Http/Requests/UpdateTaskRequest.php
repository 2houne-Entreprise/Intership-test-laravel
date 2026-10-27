<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateTaskRequest extends StoreTaskRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * Same rules as creation, but each field is only validated when present,
     * so the quick status form can send the status alone.
     *
     * @return array<string, array<int, ValidationRule|string>>
     */
    public function rules(): array
    {
        return array_map(
            fn (array $rules): array => ['sometimes', ...$rules],
            parent::rules(),
        );
    }
}
