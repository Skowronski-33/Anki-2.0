<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            // Decks Created
            ['name' => 'Primeiro Passo', 'description' => 'Criou seu primeiro deck.', 'icon' => 'fa-solid fa-seedling', 'xp_reward' => 50, 'condition_type' => 'decks_created', 'condition_value' => 1],
            ['name' => 'Organizador', 'description' => 'Criou 5 decks.', 'icon' => 'fa-solid fa-box-archive', 'xp_reward' => 150, 'condition_type' => 'decks_created', 'condition_value' => 5],
            ['name' => 'Bibliotecário', 'description' => 'Criou 10 decks.', 'icon' => 'fa-solid fa-book', 'xp_reward' => 300, 'condition_type' => 'decks_created', 'condition_value' => 10],

            // Cards Reviewed
            ['name' => 'Aprendiz', 'description' => 'Revisou 10 cards no total.', 'icon' => 'fa-solid fa-glasses', 'xp_reward' => 50, 'condition_type' => 'cards_reviewed', 'condition_value' => 10],
            ['name' => 'Estudioso', 'description' => 'Revisou 100 cards no total.', 'icon' => 'fa-solid fa-book-open', 'xp_reward' => 150, 'condition_type' => 'cards_reviewed', 'condition_value' => 100],
            ['name' => 'Rato de Biblioteca', 'description' => 'Revisou 500 cards no total.', 'icon' => 'fa-solid fa-book-journal-whills', 'xp_reward' => 500, 'condition_type' => 'cards_reviewed', 'condition_value' => 500],
            ['name' => 'Sábio', 'description' => 'Revisou 1000 cards no total.', 'icon' => 'fa-solid fa-brain', 'xp_reward' => 1000, 'condition_type' => 'cards_reviewed', 'condition_value' => 1000],
            ['name' => 'Oráculo', 'description' => 'Revisou 5000 cards no total.', 'icon' => 'fa-solid fa-eye', 'xp_reward' => 5000, 'condition_type' => 'cards_reviewed', 'condition_value' => 5000],

            // Streak
            ['name' => 'Aquecimento', 'description' => 'Manteve uma ofensiva de 3 dias.', 'icon' => 'fa-solid fa-fire', 'xp_reward' => 100, 'condition_type' => 'streak', 'condition_value' => 3],
            ['name' => 'Mestre da Constância', 'description' => 'Manteve uma ofensiva de 7 dias.', 'icon' => 'fa-solid fa-fire-flame-curved', 'xp_reward' => 300, 'condition_type' => 'streak', 'condition_value' => 7],
            ['name' => 'Chama Viva', 'description' => 'Manteve uma ofensiva de 14 dias.', 'icon' => 'fa-solid fa-fire-flame-simple', 'xp_reward' => 700, 'condition_type' => 'streak', 'condition_value' => 14],
            ['name' => 'Imparável', 'description' => 'Manteve uma ofensiva de 30 dias.', 'icon' => 'fa-solid fa-meteor', 'xp_reward' => 1500, 'condition_type' => 'streak', 'condition_value' => 30],

            // Level
            ['name' => 'Nível 5', 'description' => 'Alcançou o nível 5.', 'icon' => 'fa-solid fa-star-half-stroke', 'xp_reward' => 200, 'condition_type' => 'level', 'condition_value' => 5],
            ['name' => 'Nível 10', 'description' => 'Alcançou o nível 10.', 'icon' => 'fa-solid fa-star', 'xp_reward' => 500, 'condition_type' => 'level', 'condition_value' => 10],
            ['name' => 'Nível 25', 'description' => 'Alcançou o nível 25.', 'icon' => 'fa-solid fa-medal', 'xp_reward' => 1500, 'condition_type' => 'level', 'condition_value' => 25],
            ['name' => 'Nível 50', 'description' => 'Alcançou o nível 50.', 'icon' => 'fa-solid fa-crown', 'xp_reward' => 3000, 'condition_type' => 'level', 'condition_value' => 50],
        ];

        foreach ($achievements as $achieve) {
            Achievement::firstOrCreate(['name' => $achieve['name']], $achieve);
        }
    }
}
