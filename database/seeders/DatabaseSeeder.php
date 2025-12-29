<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Document as ModelsDocument;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Document;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()->count(8)->create();
        $document = Document::factory()->count(20)->make()->each(function ($doc) use ($user) {
            $doc->user_id = $user->random()->id;
            $doc->save();
        });
        $document->each(function ($doc) use ($user){
            $actioncount = rand(1, 4);
            Action::factory()->count($actioncount)->make()->each(function ($action) use ($doc, $user) {
                $action->user_id = $user->random()->id;
                $action->save();
            });
        });
    }
}
