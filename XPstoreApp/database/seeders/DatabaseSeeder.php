<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VideoGame;
use App\Models\Review;
use App\Models\LibraryItem;
use App\Models\Notification;
use App\Models\StreamingCode;
use App\Models\MarketItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios
        $admin = User::firstOrCreate(
            ['email' => 'admin@xpstore.com'],
            [
                'name' => 'Admin XP',
                'password' => bcrypt('admin123'),
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
                'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'juan.perez@example.com'],
            [
                'name' => 'Juan Pérez',
                'password' => bcrypt('usuario123'),
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=150&h=150&fit=crop',
                'role' => 'user',
            ]
        );

        // ==========================
        //  VIDEOJUEGOS REALES
        // ==========================

        // 1. God of War Ragnarok
        VideoGame::create([
            'title' => 'God of War Ragnarok',
            'description' => 'Acompaña a Kratos y Atreus en el inicio del fin de los tiempos mientras enfrentan a dioses nórdicos.',
            'price' => 59.99,
            'discount' => 10,
            'images' => [
                'https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp'
            ],
            'genre' => ['Acción', 'Aventura'],
            'platform' => ['PlayStation 5', 'PC'],
            'release_date' => '2022-11-09',
            'developer' => 'Santa Monica Studio',
            'publisher' => 'Sony Interactive Entertainment',
            'rating' => 4.9,
            'stock' => 120,
            'featured' => true,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'Ryzen 5', 'memory' => '8 GB', 'graphics' => 'GTX 1060', 'storage' => '80 GB'],
                'recommended' => ['os' => 'Windows 11', 'processor' => 'Ryzen 7', 'memory' => '16 GB', 'graphics' => 'RTX 2060', 'storage' => '80 GB SSD']
            ]
        ]);

        // 2. Elden Ring
        VideoGame::create([
            'title' => 'Elden Ring',
            'description' => 'Una aventura épica desarrollada por FromSoftware en un vasto mundo abierto lleno de desafíos.',
            'price' => 49.99,
            'discount' => 0,
            'images' => [
                'https://images2.alphacoders.com/124/thumb-440-1246524.webp'
            ],
            'genre' => ['RPG', 'Acción', 'Mundo Abierto'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X'],
            'release_date' => '2022-02-25',
            'developer' => 'FromSoftware',
            'publisher' => 'Bandai Namco',
            'rating' => 4.8,
            'stock' => 200,
            'featured' => true,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i5-8400', 'memory' => '12 GB', 'graphics' => 'GTX 1060', 'storage' => '60 GB'],
                'recommended' => ['os' => 'Windows 11', 'processor' => 'Ryzen 7', 'memory' => '16 GB', 'graphics' => 'RTX 3060', 'storage' => '60 GB SSD']
            ]
        ]);

        // 3. Marvel’s Spider-Man 2
        VideoGame::create([
            'title' => 'Marvel’s Spider-Man 2',
            'description' => 'Vive una historia épica junto a Peter Parker y Miles Morales en Nueva York.',
            'price' => 69.99,
            'discount' => 15,
            'images' => [
                'https://wallpapers.com/images/high/spider-man-ps4-4k-i5ssgd6fq17lrz7i.webp'
            ],
            'genre' => ['Acción', 'Aventura'],
            'platform' => ['PlayStation 5'],
            'release_date' => '2023-10-20',
            'developer' => 'Insomniac Games',
            'publisher' => 'Sony Interactive Entertainment',
            'rating' => 4.8,
            'stock' => 150,
            'featured' => true,
            'requirements' => [
                'minimum' => ['os' => 'N/A', 'processor' => 'N/A', 'memory' => 'N/A', 'graphics' => 'N/A', 'storage' => 'N/A'],
                'recommended' => ['os' => 'N/A', 'processor' => 'N/A', 'memory' => 'N/A', 'graphics' => 'N/A', 'storage' => 'N/A']
            ]
        ]);

        // 4. Horizon Zero Dawn
        VideoGame::create([
            'title' => 'Horizon Zero Dawn',
            'description' => 'Acompaña a Aloy en una aventura por un mundo dominado por criaturas mecánicas.',
            'price' => 39.99,
            'discount' => 0,
            'images' => [
                'https://images4.alphacoders.com/936/936631.jpg'
            ],
            'genre' => ['Aventura', 'Acción', 'RPG'],
            'platform' => ['PC', 'PlayStation 4'],
            'release_date' => '2017-02-28',
            'developer' => 'Guerrilla Games',
            'publisher' => 'Sony Interactive Entertainment',
            'rating' => 4.7,
            'stock' => 300,
            'featured' => false,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i5-2500K', 'memory' => '8 GB', 'graphics' => 'GTX 780', 'storage' => '100 GB'],
                'recommended' => ['os' => 'Windows 11', 'processor' => 'Ryzen 5', 'memory' => '16 GB', 'graphics' => 'GTX 1080', 'storage' => '100 GB SSD']
            ]
        ]);

        // 5. Grand Theft Auto V
        VideoGame::create([
            'title' => 'Grand Theft Auto V',
            'description' => 'Vive la historia de tres criminales en una ciudad llena de caos y oportunidades.',
            'price' => 19.99,
            'discount' => 0,
            'images' => [
                'https://wallpapers.com/images/high/4k-gta-5-franklin-looking-at-city-at-night-bq6nlp808hn0xoi5.webp'
            ],
            'genre' => ['Acción', 'Mundo Abierto'],
            'platform' => ['PC', 'PlayStation', 'Xbox'],
            'release_date' => '2013-09-17',
            'developer' => 'Rockstar Games',
            'publisher' => 'Rockstar Games',
            'rating' => 4.9,
            'stock' => 500,
            'featured' => true,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i5-3470', 'memory' => '8 GB', 'graphics' => 'GTX 660', 'storage' => '75 GB'],
                'recommended' => ['os' => 'Windows 10', 'processor' => 'i7-3770', 'memory' => '16 GB', 'graphics' => 'GTX 1050 Ti', 'storage' => '75 GB SSD']
            ]
        ]);

        // 6. Fortnite
        VideoGame::create([
            'title' => 'Fortnite',
            'description' => 'Battle Royale gratuito y en constante evolución con millones de jugadores.',
            'price' => 0,
            'discount' => 0,
            'images' => [
                'https://images6.alphacoders.com/901/thumb-440-901682.webp'
            ],
            'genre' => ['Battle Royale', 'Multijugador'],
            'platform' => ['PC', 'PlayStation', 'Xbox', 'Switch', 'Mobile'],
            'release_date' => '2017-07-21',
            'developer' => 'Epic Games',
            'publisher' => 'Epic Games',
            'rating' => 4.4,
            'stock' => 999,
            'featured' => true,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i3', 'memory' => '8 GB', 'graphics' => 'Intel HD 4000', 'storage' => '30 GB'],
                'recommended' => ['os' => 'Windows 10', 'processor' => 'i5', 'memory' => '16 GB', 'graphics' => 'GTX 960', 'storage' => '30 GB SSD']
            ]
        ]);

        // 7. Call of Duty: Modern Warfare II
        VideoGame::create([
            'title' => 'Call of Duty: Modern Warfare II',
            'description' => 'La secuela del exitoso reboot de Modern Warfare con acción intensa y multijugador competitivo.',
            'price' => 69.99,
            'discount' => 20,
            'images' => [
                'https://images.alphacoders.com/129/thumbbig-1294266.webp'
            ],
            'genre' => ['Shooter', 'Multijugador'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X'],
            'release_date' => '2022-10-28',
            'developer' => 'Infinity Ward',
            'publisher' => 'Activision',
            'rating' => 4.5,
            'stock' => 250,
            'featured' => false,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i5-6600', 'memory' => '8 GB', 'graphics' => 'GTX 960', 'storage' => '72 GB'],
                'recommended' => ['os' => 'Windows 11', 'processor' => 'i7-8700K', 'memory' => '16 GB', 'graphics' => 'RTX 2060', 'storage' => '72 GB SSD']
            ]
        ]);

        // 8. Red Dead Redemption 2
        VideoGame::create([
            'title' => 'Red Dead Redemption 2',
            'description' => 'Una obra maestra narrativa que te lleva al corazón del Viejo Oeste.',
            'price' => 39.99,
            'discount' => 0,
            'images' => [
                'https://images7.alphacoders.com/749/thumb-440-749807.webp'
            ],
            'genre' => ['Acción', 'Aventura', 'Mundo Abierto'],
            'platform' => ['PC', 'PlayStation', 'Xbox'],
            'release_date' => '2018-10-26',
            'developer' => 'Rockstar Games',
            'publisher' => 'Rockstar Games',
            'rating' => 4.9,
            'stock' => 300,
            'featured' => false,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i5-2500K', 'memory' => '8 GB', 'graphics' => 'GTX 770', 'storage' => '150 GB'],
                'recommended' => ['os' => 'Windows 11', 'processor' => 'Ryzen 5', 'memory' => '16 GB', 'graphics' => 'GTX 1070', 'storage' => '150 GB SSD']
            ]
        ]);

        // 9. Minecraft
        VideoGame::create([
            'title' => 'Minecraft',
            'description' => 'Construye, explora y sobrevive en un mundo generado proceduralmente.',
            'price' => 29.99,
            'discount' => 0,
            'images' => [
                'https://images2.alphacoders.com/135/thumbbig-1353836.webp'
            ],
            'genre' => ['Sandbox', 'Supervivencia', 'Creativo'],
            'platform' => ['PC', 'PlayStation', 'Xbox', 'Switch', 'Mobile'],
            'release_date' => '2011-11-18',
            'developer' => 'Mojang Studios',
            'publisher' => 'Mojang Studios',
            'rating' => 4.8,
            'stock' => 500,
            'featured' => false,
            'requirements' => [
                'minimum' => ['os' => 'Windows 10', 'processor' => 'i3', 'memory' => '4 GB', 'graphics' => 'Intel HD', 'storage' => '4 GB'],
                'recommended' => ['os' => 'Windows 10', 'processor' => 'i5', 'memory' => '8 GB', 'graphics' => 'GTX 660', 'storage' => '4 GB SSD']
            ]
        ]);

        // 10. Among Us
        VideoGame::create([
            'title' => 'Among Us',
            'description' => 'Juego social de deducción donde debes descubrir al impostor entre la tripulación.',
            'price' => 4.99,
            'discount' => 0,
            'images' => [
                'https://images4.alphacoders.com/110/thumb-440-1104860.webp'
            ],
            'genre' => ['Multijugador', 'Casual'],
            'platform' => ['PC', 'Mobile', 'Switch', 'PlayStation'],
            'release_date' => '2018-06-15',
            'developer' => 'Innersloth',
            'publisher' => 'Innersloth',
            'rating' => 4.3,
            'stock' => 999,
            'featured' => false,
            'requirements' => [
                'minimum' => ['os' => 'Windows 7', 'processor' => 'i3', 'memory' => '1 GB', 'graphics' => 'Intel HD', 'storage' => '250 MB'],
                'recommended' => ['os' => 'Windows 10', 'processor' => 'i5', 'memory' => '4 GB', 'graphics' => 'GTX 650', 'storage' => '250 MB']
            ]
        ]);


        $this->call([
            MarketItemSeeder::class,
        ]);
        $this->call(StreamingCodesSeeder::class);


        $this->call(
            MarketItemSeeder::class
        );






        $this->command->info('✅ Base de datos poblada exitosamente!');
        $this->command->info('🔐 Admin: admin@xpstore.com | Password: admin123');
    }
}
