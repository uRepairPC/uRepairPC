<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class RequestCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function rules(Request $request): array
    {
        $rules = [
            'message' => 'string|max:600',
        ];

        if ($request->method === Request::METHOD_POST) {
            $rules['message'] = 'required|'.$rules['message'];
        }

        return $rules;
    }
}
