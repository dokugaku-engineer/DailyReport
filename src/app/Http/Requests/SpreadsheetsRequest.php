<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SpreadsheetsRequest extends ApiRequest
{
    /**
     *  Spreadsheetリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'spreadsheet_id' => 'required|string',
            'sheet_id' => 'required|string',
            'slack_user_id' => 'required|string'
        ];
    }
}
