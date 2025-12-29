<?php

namespace Database\Factories;

use App\Enums\EnumsAction;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = now();
        $actions = EnumsAction::cases();
        return [
             'document_content' => $this->faker->sentence(3), // e.g., "Contract XYZ"
            'user_id' => null,    // user who performed the action
            'event_type' => $actions[array_rand($actions)]->value,
            
        ];
    }
}
