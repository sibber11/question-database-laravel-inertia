<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Question */
class QuestionResource extends JsonResource
{
    public static $wrap = false;
    public function toArray(Request $request): array
    {
        //extract <think> tag from the answer
        $think = preg_match('/<think>([\s\S]*)<\/think>/', $this->answer, $matches) ? $matches[1] : null;
        $think = trim($think);
        //convert line breaks to <br> tag
        $think = nl2br($think);
        //remove <think> tag from the answer
        $answer = preg_replace('/<think>[\s\S]*<\/think>/', '', $this->answer);
        $answer = trim($answer);
        return [
            ...parent::toArray($request),
            'answer' => $answer,
            'think' => $think,
        ];
    }
}
