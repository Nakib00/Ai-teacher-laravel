<?php

namespace Database\Seeders;

use App\Models\AiTeacher;
use Illuminate\Database\Seeder;

class AiTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AiTeacher::create([
            'name' => 'Namira',
            'persona_id' => 'namira',
            'description' => 'A friendly and cheerful AI-powered home tutor who makes learning a joyful and happy experience.',
            'avatar_url' => 'https://example.com/avatars/namira.png',
        ]);

        AiTeacher::create([
            'name' => 'Ahmed',
            'persona_id' => 'ahmed',
            'description' => 'An enthusiastic and knowledgeable teacher who loves to explore science and technology.',
            'avatar_url' => 'https://example.com/avatars/ahmed.png',
        ]);

         AiTeacher::create([
            'name' => 'Fatima',
            'persona_id' => 'fatima',
            'description' => 'A calm and patient tutor with a passion for arts and literature.',
            'avatar_url' => 'https://example.com/avatars/fatima.png',
        ]);
    }
}
