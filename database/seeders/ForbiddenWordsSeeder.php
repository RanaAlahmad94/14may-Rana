<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ForbiddenWord;

class ForbiddenWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forbiddenWords = [
            'bad',
            'evil',
            'hate',
            'kill',
            'murder',
        ];

        foreach ($forbiddenWords as $word) {
            ForbiddenWord::create([
                'word' => $word,
            ]);
        }
    }}
