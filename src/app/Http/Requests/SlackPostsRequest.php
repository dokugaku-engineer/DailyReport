<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\ValidationService;
use App\Models\SlackChannel;

class SlackPostsRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'challenge' => 'sometimes|required|string',
            'type' => 'sometimes|required|string',
            'team_id' => 'sometimes|required|string',
            'event.channel' => 'sometimes|required|string',
            'event.user' => 'sometimes|required|string',
            'event.text' => 'sometimes|required|string'
        ];
    }

    /**
     * 日報連携キーワードをバリデーション
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $request = $this->all();
            $slack_channel = SlackChannel::where('slack_channel_id', $request['event']['channel'])->first();
            $key_word = $slack_channel->slackToSpreadsheets()->value('key_word');

            if (preg_match('/'.$key_word.'/', $request['event']['text']) == 0) {
                $validator->errors()->add('validation', 'No key word');
            }
        });
    }
}
