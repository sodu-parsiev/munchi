<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateCaptcha
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = validator($request->all(), [
            'captcha_answer' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) use ($request): void {
                    if ((string) $value !== (string) $request->session()->get('captcha_answer')) {
                        $fail('The captcha answer is incorrect.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        return $next($request);
    }
}
