<?php

namespace App\Http\Requests;

use App\Enums\FieldType;
use App\Enums\SubscriberStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSubscriberRequest extends FormRequest
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
            'email' => "required|email:rfc,dns|unique:subscribers,email,$this->id",
            'name' => 'required',
            'status' => ['required', new Enum(SubscriberStatus::class)],
            'fields.*' => 'array',
            'fields.*.title' => ['exclude_unless:fields.*.id,null|required_without:fields.*.id|unique:fields,title'],
            'fields.*.type' => ['required_without:fields.*.id', new Enum(FieldType::class)],
            'fields.*.value' => 'nullable',
        ];
    }
}
