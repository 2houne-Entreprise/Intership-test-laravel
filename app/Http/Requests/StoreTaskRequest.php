<?php

namespace App\Http\Requests;

use App\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'deadline' => ['nullable', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,txt,doc,docx,xls,xlsx,zip', 'max:5120'],
        ];
    }

    /**
     * Get the French error messages for the validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'status.required' => 'Le statut est obligatoire.',
            'status.enum' => 'Le statut sélectionné est invalide.',
            'deadline.date' => "L'échéance doit être une date valide.",
            'attachment.file' => 'La pièce jointe doit être un fichier.',
            'attachment.mimes' => 'Formats acceptés : pdf, jpg, png, txt, doc, docx, xls, xlsx, zip.',
            'attachment.max' => 'La pièce jointe ne doit pas dépasser 5 Mo.',
            'attachment.uploaded' => "L'envoi de la pièce jointe a échoué.",
        ];
    }
}
