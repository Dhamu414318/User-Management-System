<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CaptchaService
{
    /**
     * Generate a math-based captcha
     */
    public function generate(): array
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operation = rand(0, 1) ? '+' : '*';
        
        $answer = $operation === '+' ? $num1 + $num2 : $num1 * $num2;
        $question = "$num1 $operation $num2";
        
        // Store answer in cache for 5 minutes with a unique key
        $key = 'captcha_' . uniqid();
        Cache::put($key, $answer, now()->addMinutes(5));
        
        return [
            'key' => $key,
            'question' => $question,
        ];
    }

    /**
     * Verify captcha answer
     */
    public function verify(string $key, int $answer): bool
    {
        $storedAnswer = Cache::get($key);
        
        if ($storedAnswer === null) {
            return false;
        }
        
        // Remove the key after verification
        Cache::forget($key);
        
        return $storedAnswer === $answer;
    }
}

