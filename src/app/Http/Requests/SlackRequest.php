<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlackRequest extends ApiErrorRequest
{
    /**
     * Slackリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'team_id' => 'required|string',
            'channel_id' => 'required|string',
            'user_id' => 'required|string'
        ];
    }
}
