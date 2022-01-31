<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlackToSpreadsheetRequest extends ApiRequest
{
    /**
     * slack_to_spreadsheetリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'slack_channel_id' => 'required|exists:slack_channels,slack_channel_id|string',
            'spreadsheet_id' => 'required|exists:spreadsheets,spreadsheet_id|string',
            'key_word' => 'required|string'
        ];
    }
}
