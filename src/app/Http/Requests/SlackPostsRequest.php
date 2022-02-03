<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    public static function checkChallengeRequest($validated)
    {
        $type = $validated['type'];

        if ($type == 'url_verification') {
            return true;
        } else {
            return false;
        }
    }
}
