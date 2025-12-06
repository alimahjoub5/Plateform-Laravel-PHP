<?php

namespace Database\Factories;

use App\Models\ChatMessage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    public function definition(): array
    {
        return [
            'ProjectID' => Project::factory(),
            'SenderID' => User::factory(),
            'ReceiverID' => User::factory(),
            'Message' => $this->faker->sentence(),
            'IsRead' => $this->faker->boolean(),
            'AttachmentURL' => $this->faker->optional()->imageUrl(),
        ];
    }
}
