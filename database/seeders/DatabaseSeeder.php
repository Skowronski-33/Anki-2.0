<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\Achievement::insert([
            ['name' => 'Primeiro Passo', 'description' => 'Criou seu primeiro deck.', 'icon' => 'fa-solid fa-seedling', 'xp_reward' => 50, 'condition_type' => 'decks_created', 'condition_value' => 1],
            ['name' => 'Estudioso', 'description' => 'Revisou 100 cards no total.', 'icon' => 'fa-solid fa-book-open', 'xp_reward' => 150, 'condition_type' => 'cards_reviewed', 'condition_value' => 100],
            ['name' => 'Mestre da Constância', 'description' => 'Manteve uma ofensiva de 7 dias.', 'icon' => 'fa-solid fa-fire-flame-curved', 'xp_reward' => 300, 'condition_type' => 'streak', 'condition_value' => 7],
            ['name' => 'Nível 10', 'description' => 'Alcançou o nível 10.', 'icon' => 'fa-solid fa-star', 'xp_reward' => 500, 'condition_type' => 'level', 'condition_value' => 10],
        ]);
    }
}
