<?php

namespace App\Support;

use Illuminate\Http\Request;

class CaptchaService
{
    public function seed(Request $request): void
    {
        $first = random_int(1, 9);
        $second = random_int(1, 9);

        $request->session()->put('captcha_question', "What is {$first} + {$second}?");
        $request->session()->put('captcha_answer', (string) ($first + $second));
    }
}
