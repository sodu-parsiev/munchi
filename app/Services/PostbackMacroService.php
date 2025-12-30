<?php

namespace App\Services;

use App\Models\Postback;
use App\Models\PostbackMacro;

class PostbackMacroService
{
    public function createForPostback(Postback $postback, array $payload): void
    {
        foreach ($payload as $key => $value) {
            $postbackMacro = new PostbackMacro();
            $postbackMacro->postback_id = $postback->id;
            $postbackMacro->macro_name = (string) $key;
            $postbackMacro->macro_value = $this->normalizeValue($value);
            $postbackMacro->save();
        }
    }

    private function normalizeValue(mixed $value): string|null
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        if ($value === null) {
            return null;
        }

        return (string) $value;
    }
}
