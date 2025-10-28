<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Code;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Code>
 */
class CodeFactory extends Factory
{
    protected static $currentCode = 1;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = static::$currentCode++;
        
        return [
            'code' => $code,
            'is_reserved' => true,
            'price' => $this->faker->randomFloat(2, 10000, 1000000),
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Reset the code counter
     */
    public static function resetCounter(): void
    {
        static::$currentCode = 1;
    }
}