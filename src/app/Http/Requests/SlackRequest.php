<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlackRequest extends FormRequest
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
     * Slackリソースのバリデーションルールを返す
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_id' => 'required|string',
            'channel_id' => 'required|string',
            'user_id' => 'required|string'
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
