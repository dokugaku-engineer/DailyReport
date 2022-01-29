<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlackToSpreadsheetRequest extends FormRequest
{
    /**
     * 認可チェック
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * slack_to_spreadsheetリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slack_channel_id' => 'required|string',
            'spreadsheet_id' => 'required|string',
            'key_word' => 'required|string'
        ];
    }

    /**
     * バリデーションチェック失敗時のエラーを投げる
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 422,
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
