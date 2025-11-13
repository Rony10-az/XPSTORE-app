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
        $admin = User::create([
            'name' => 'Admin XP',
            'email' => 'admin@xpstore.com',
            'password' => bcrypt('admin123'),
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
            'role' => 'admin',
        ]);

        // Crear videojuegos
        $game1 = VideoGame::create([
            'title' => 'Cyberpunk Odyssey',
            'description' => 'Explora un futuro distópico en esta épica aventura de ciencia ficción. Toma decisiones que afectarán el destino de la humanidad.',
            'price' => 59.99,
            'discount' => 20,
            'images' => [
                'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=800&h=450&fit=crop'
            ],
            'genre' => ['RPG', 'Acción', 'Ciencia Ficción'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X'],
            'release_date' => '2024-03-15',
            'developer' => 'Future Games Studio',
            'publisher' => 'Mega Publisher Inc.',
            'rating' => 4.8,
            'stock' => 150,
            'featured' => true,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i5-8400 / AMD Ryzen 5 2600',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 1060 6GB / AMD RX 580',
                    'storage' => '70 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i7-10700K / AMD Ryzen 7 3700X',
                    'memory' => '16 GB RAM',
                    'graphics' => 'NVIDIA RTX 3070 / AMD RX 6800',
                    'storage' => '70 GB SSD'
                ]
            ]
        ]);

        $game2 = VideoGame::create([
            'title' => 'Fantasy Legends Online',
            'description' => 'MMORPG épico con combates estratégicos y un vasto mundo por explorar. Únete a millones de jugadores en batallas legendarias.',
            'price' => 49.99,
            'discount' => 0,
            'images' => [
                'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=800&h=450&fit=crop'
            ],
            'genre' => ['MMORPG', 'Fantasía', 'Multijugador'],
            'platform' => ['PC', 'PlayStation 5'],
            'release_date' => '2024-01-20',
            'developer' => 'Epic Fantasy Studios',
            'publisher' => 'Online Games Corp',
            'rating' => 4.5,
            'stock' => 200,
            'featured' => true,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i5-6600K / AMD Ryzen 3 1300X',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 970 / AMD RX 570',
                    'storage' => '50 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i7-9700K / AMD Ryzen 5 3600',
                    'memory' => '16 GB RAM',
                    'graphics' => 'NVIDIA RTX 2070 / AMD RX 5700 XT',
                    'storage' => '50 GB SSD'
                ]
            ]
        ]);

        $game3 = VideoGame::create([
            'title' => 'Racing Champions 2024',
            'description' => 'La experiencia de carreras más realista. Compite en circuitos mundiales con los mejores pilotos del planeta.',
            'price' => 39.99,
            'discount' => 15,
            'images' => [
                'https://images.unsplash.com/photo-1511882150382-421056c89033?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&h=450&fit=crop'
            ],
            'genre' => ['Carreras', 'Simulación', 'Deportes'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X', 'Nintendo Switch'],
            'release_date' => '2024-02-10',
            'developer' => 'Speed Masters',
            'publisher' => 'Racing Games Ltd',
            'rating' => 4.6,
            'stock' => 180,
            'featured' => false,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i5-7500 / AMD Ryzen 5 1600',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 1050 Ti / AMD RX 560',
                    'storage' => '40 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i7-8700K / AMD Ryzen 7 2700X',
                    'memory' => '16 GB RAM',
                    'graphics' => 'NVIDIA RTX 2060 / AMD RX 5600 XT',
                    'storage' => '40 GB SSD'
                ]
            ]
        ]);

        $game4 = VideoGame::create([
            'title' => 'Horror Mansion: The Awakening',
            'description' => 'Sobrevive en una mansión llena de secretos oscuros. Terror psicológico que te mantendrá al borde de tu asiento.',
            'price' => 29.99,
            'discount' => 0,
            'images' => [
                'https://images.unsplash.com/photo-1578922746376-9e554a2ccb90?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1614732414444-096e5f1122d5?w=800&h=450&fit=crop'
            ],
            'genre' => ['Terror', 'Supervivencia', 'Aventura'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X'],
            'release_date' => '2024-04-01',
            'developer' => 'Nightmare Studios',
            'publisher' => 'Horror Games Inc',
            'rating' => 4.7,
            'stock' => 120,
            'featured' => false,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i5-6600 / AMD Ryzen 3 1200',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 960 / AMD RX 470',
                    'storage' => '30 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i7-8700 / AMD Ryzen 5 2600X',
                    'memory' => '16 GB RAM',
                    'graphics' => 'NVIDIA RTX 2060 / AMD RX 5600 XT',
                    'storage' => '30 GB SSD'
                ]
            ]
        ]);

        $game5 = VideoGame::create([
            'title' => 'Battle Royale Legends',
            'description' => '100 jugadores, un solo superviviente. El Battle Royale definitivo con mapas dinámicos y armas personalizables.',
            'price' => 0,
            'discount' => 0,
            'images' => [
                'https://images.unsplash.com/photo-1542751110-97427bbecf20?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1556438758-8d49568ce18e?w=800&h=450&fit=crop'
            ],
            'genre' => ['Battle Royale', 'Acción', 'Multijugador'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X', 'Mobile'],
            'release_date' => '2023-11-15',
            'developer' => 'Battle Masters',
            'publisher' => 'Free Games Network',
            'rating' => 4.4,
            'stock' => 999,
            'featured' => true,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i3-6100 / AMD FX-8300',
                    'memory' => '6 GB RAM',
                    'graphics' => 'NVIDIA GTX 750 Ti / AMD Radeon HD 7850',
                    'storage' => '25 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i5-9400F / AMD Ryzen 5 2600',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 1660 / AMD RX 580',
                    'storage' => '25 GB SSD'
                ]
            ]
        ]);

        VideoGame::create([
            'title' => 'Strategy Empire Builder',
            'description' => 'Construye tu imperio desde cero. Gestiona recursos, diplomacia y ejércitos en este juego de estrategia en tiempo real.',
            'price' => 44.99,
            'discount' => 10,
            'images' => [
                'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1518365050014-70fe7232897f?w=800&h=450&fit=crop'
            ],
            'genre' => ['Estrategia', 'Simulación', 'Gestión'],
            'platform' => ['PC', 'Mac'],
            'release_date' => '2024-05-01',
            'developer' => 'Strategy Masters',
            'publisher' => 'Tactical Games',
            'rating' => 4.9,
            'stock' => 90,
            'featured' => false,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i5-4590 / AMD Ryzen 3 1200',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 960 / AMD RX 560',
                    'storage' => '35 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i7-7700 / AMD Ryzen 5 2600',
                    'memory' => '16 GB RAM',
                    'graphics' => 'NVIDIA GTX 1070 / AMD RX Vega 56',
                    'storage' => '35 GB SSD'
                ]
            ]
        ]);

        VideoGame::create([
            'title' => 'Space Explorer Chronicles',
            'description' => 'Explora galaxias desconocidas, descubre civilizaciones alienígenas y desvela los misterios del universo.',
            'price' => 54.99,
            'discount' => 0,
            'images' => [
                'https://images.unsplash.com/photo-1614732484003-ef9881555dc3?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?w=800&h=450&fit=crop'
            ],
            'genre' => ['Aventura', 'Ciencia Ficción', 'Exploración'],
            'platform' => ['PC', 'PlayStation 5', 'Xbox Series X'],
            'release_date' => '2024-06-15',
            'developer' => 'Cosmic Games',
            'publisher' => 'Space Ventures',
            'rating' => 4.8,
            'stock' => 110,
            'featured' => true,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i5-8400 / AMD Ryzen 5 2600',
                    'memory' => '12 GB RAM',
                    'graphics' => 'NVIDIA GTX 1060 / AMD RX 580',
                    'storage' => '60 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i7-10700K / AMD Ryzen 7 3700X',
                    'memory' => '16 GB RAM',
                    'graphics' => 'NVIDIA RTX 3060 Ti / AMD RX 6700 XT',
                    'storage' => '60 GB SSD'
                ]
            ]
        ]);

        videogame::create([
            'title' => 'Puzzle Master Collection',
            'description' => 'Desafía tu mente con cientos de puzzles únicos. Desde rompecabezas clásicos hasta acertijos imposibles.',
            'price' => 19.99,
            'discount' => 0,
            'images' => [
                'https://images.unsplash.com/photo-1611996575749-79a3a250f948?w=800&h=450&fit=crop',
                'https://images.unsplash.com/photo-1587731556938-38755b4803a6?w=800&h=450&fit=crop'
            ],
            'genre' => ['Puzzle', 'Casual', 'Lógica'],
            'platform' => ['PC', 'Nintendo Switch', 'Mobile'],
            'release_date' => '2024-01-05',
            'developer' => 'Brain Games',
            'publisher' => 'Indie Publishers',
            'rating' => 4.3,
            'stock' => 250,
            'featured' => false,
            'requirements' => [
                'minimum' => [
                    'os' => 'Windows 10 64-bit',
                    'processor' => 'Intel Core i3-4170 / AMD A8-7600',
                    'memory' => '4 GB RAM',
                    'graphics' => 'Intel HD Graphics 4400 / AMD Radeon R5',
                    'storage' => '10 GB'
                ],
                'recommended' => [
                    'os' => 'Windows 11 64-bit',
                    'processor' => 'Intel Core i5-6500 / AMD Ryzen 3 1200',
                    'memory' => '8 GB RAM',
                    'graphics' => 'NVIDIA GTX 750 / AMD RX 460',
                    'storage' => '10 GB SSD'
                ]
            ]
        ]);

        $this->command->info('✅ Base de datos poblada exitosamente!');
        $this->command->info('🔐 Admin: admin@xpstore.com | Password: admin123');
    }
}
