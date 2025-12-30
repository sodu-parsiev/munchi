<?php

namespace App\Http\Controllers;

use App\Services\ContactMessageService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactMessageService $contactMessageService
    ) {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'captcha_answer' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                    if ((string) $value !== (string) $request->session()->get('captcha_answer')) {
                        $fail('The captcha answer is incorrect.');
                    }
                },
            ],
        ]);

        $this->contactMessageService->create($validated);

        return back()->with('status', 'Thanks for reaching out! We received your message.');
    }
}
