<?php

namespace Database\Factories;

use App\Enums\EnumsStatus;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //         $indicolors = [
        //     "bg-blue-500", "bg-green-500", "bg-yellow-400", "bg-gray-400",
        //     "bg-blue-500", "bg-green-500", "bg-yellow-400", "bg-blue-500",
        //     "bg-green-500", "bg-red-500", "bg-orange-400", "bg-purple-500",
        //     "bg-green-600"
        // ];
        // 'indicolor' => $this->faker->randomElement($indicolors),

        $roles = [
            'Finance', 'Legal', 'HR', 'Finance',
            'Operations', 'Legal', 'Manager', 'Finance',
            'HR', 'System', 'Operations', 'Legal',
            'Manager',
        ];

        $contents = [
            'Invoice – ABC Ltd',
            'Contract – XYZ Corp',
            'Employee record metadata',
            'Old invoice',
            'Purchase order',
            'Policy document',
            'Contract pending review',
            'Invoice – DEF Ltd',
            'HR form',
            'Document',
            'Invoice',
            'Contract commented by legal team',
            'Document workflow',
        ];
        $source = '';
        $created = now();
        $statuses = EnumsStatus::cases();
        $target = public_path().'\files';

        return [

            'filename' => $this->faker->file(public_path().'\dbfiles', $target, false),
            'link' => '/documents/'.$this->faker->unique()->numberBetween(1, 100),
            'user_id' => null,
            'is_pending_checked' => true,
            'is_quick_checked' => true,
            'is_expired_checked' => true,
            'status' => $statuses[array_rand($statuses)]->value,
            'created_at' => $created,
            'expire_date' => Carbon::instance($created)->addDays(30), // 30 days after created_at
        ];
    }
}
