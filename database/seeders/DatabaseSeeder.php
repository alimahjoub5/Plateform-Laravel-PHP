<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('Email', 'test@example.com')->exists()) {
            User::factory()->create([
                'Username' => 'Test User',
                'Email' => 'test@example.com',
                'FirstName' => 'Test',
                'LastName' => 'User',
                'Role' => 'Admin',
            ]);
        }

        $this->call([
            AnalyticsSeeder::class,
            BlogSeeder::class,
            ChatMessageSeeder::class,
            ContactInfoSeeder::class,
            InvoiceSeeder::class,
            MeetingSeeder::class,
            NegotiationSeeder::class,
            NotificationSeeder::class,
            PaymentSeeder::class,
            PortfolioSeeder::class,
            ProjectSeeder::class,
            ServiceSeeder::class,
            TaskSeeder::class,
            TestimonialSeeder::class,
            TimeTrackingSeeder::class,
            DevisSeeder::class,
        ]);
    }
}
