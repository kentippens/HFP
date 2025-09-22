<?php

namespace Database\Factories;

use App\Models\ContactSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'subject' => $this->faker->sentence(3),
            'message' => $this->faker->paragraph(),
            'service_requested' => $this->faker->randomElement([
                'house-cleaning',
                'office-cleaning',
                'carpet-cleaning',
                'commercial-cleaning',
                'request-callback',
            ]),
            'source' => $this->faker->randomElement([
                'homepage_form',
                'contact_page',
                'service_form',
                'about_page',
                'service_house-cleaning',
                'service_office-cleaning',
            ]),
            'source_uri' => $this->faker->randomElement([
                '/',
                '/contact',
                '/about',
                '/services',
                '/services/house-cleaning',
                '/services/office-cleaning',
            ]),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'is_read' => $this->faker->boolean(30), // 30% chance of being read
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the submission is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
        ]);
    }

    /**
     * Indicate that the submission is read.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => true,
        ]);
    }

    /**
     * Set a specific source for the submission.
     */
    public function fromSource(string $source): static
    {
        return $this->state(fn (array $attributes) => [
            'source' => $source,
        ]);
    }

    /**
     * Set a specific service for the submission.
     */
    public function forService(string $service): static
    {
        return $this->state(fn (array $attributes) => [
            'service_requested' => $service,
        ]);
    }

    /**
     * Create submission from today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}