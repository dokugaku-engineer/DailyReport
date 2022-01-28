<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SpreadsheetsRequest extends FormRequest
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
     *  Spreadsheetリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules()
    {
        return [
            'spreadsheet_id' => 'required|string',
            'sheet_id' => 'required|string',
            'slack_user_id' => 'required|string'
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
