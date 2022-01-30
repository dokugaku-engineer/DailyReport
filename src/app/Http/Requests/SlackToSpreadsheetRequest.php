<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlackToSpreadsheetRequest extends ApiErrorRequest
{
    /**
     * slack_to_spreadsheetリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'slack_channel_id' => 'required|string',
            'spreadsheet_id' => 'required|string',
            'key_word' => 'required|string'
        ];
    }
}
