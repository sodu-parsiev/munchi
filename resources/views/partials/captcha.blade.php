@php
    $captchaQuestion = session('captcha_question', 'What is 3 + 4?');
@endphp

<div class="field">
    <label for="captcha_answer">{{ $captchaQuestion }}</label>
    <input
        id="captcha_answer"
        name="captcha_answer"
        type="text"
        value="{{ old('captcha_answer') }}"
        required
    >
    @error('captcha_answer')
        <div class="auth-error">{{ $message }}</div>
    @enderror
</div>
