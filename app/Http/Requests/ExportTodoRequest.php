<?php

namespace App\Http\Requests;

use App\TodoPriority;
use App\TodoStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ExportTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->has('assignee') && is_string($this->assignee)) {
            $this->merge([
                'assignee' => array_map('trim', explode(',', $this->assignee)),
            ]);
        }

        if ($this->has('status') && is_string($this->status)) {
            $this->merge([
                'status' => array_map('trim', explode(',', $this->status)),
            ]);
        }

        if ($this->has('priority') && is_string($this->priority)) {
            $this->merge([
                'priority' => array_map('trim', explode(',', $this->priority)),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'assignee' => 'nullable|array',
            'assignee.*' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end'   => 'nullable|date|after_or_equal:start',
            'min'   => 'nullable|integer|min:0',
            'max'   => 'nullable|integer|gte:min',
            'status' => 'nullable|array',
            'status.*' => ['required', new Enum(TodoStatus::class)],
            'priority' => 'nullable|array',
            'priority.*' => ['required', new Enum(TodoPriority::class)],
        ];
    }
}
