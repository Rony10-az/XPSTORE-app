<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\VideoGame;
use App\Models\GameCode;

class GameCodesSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los videojuegos
        $videojuegos = VideoGame::all();

        foreach ($videojuegos as $juego) {
            // Crear, por ejemplo, 10 códigos por juego
            for ($i = 0; $i < 10; $i++) {
                GameCode::create([
                    'video_game_id' => $juego->id,
                    'code' => strtoupper(Str::random(12)), // código aleatorio de 12 caracteres
                    'used' => false,
                ]);
            }
        }
    }
}
