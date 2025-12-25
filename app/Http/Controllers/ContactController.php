<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
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

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        return back()->with('status', 'Thanks for reaching out! We received your message.');
    }
}
