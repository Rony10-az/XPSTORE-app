<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarketItem;

class MarketItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'video_game_id' => 1,
                'title' => 'swords of chaos',
                'type' => 'weapon',
                'rarity' => 'legendary',
                'description' => 'Una espada mítica con poder elemental de fuego.',
                'image' => 'https://w0.peakpx.com/wallpaper/18/885/HD-wallpaper-artstation-blade-of-chaos-god-of-war-blades-of-chaos.jpg',
                'price' => 9.99,
                'stock' => 10,
                'attributes' => json_encode([
                    'damage' => 120,
                    'element' => 'fire'
                ]),
            ],
            [
                'video_game_id' => 1,
                'title' => 'Zeus Armor',
                'type' => 'skin',
                'rarity' => 'epic',
                'description' => 'Armadura de zeus forjada en acero celestial.',
                'image' => 'https://wallpapercave.com/wp/wp12233576.jpg',
                'price' => 9.99,
                'stock' => null,
                'attributes' => json_encode([
                    'defenseBoost' => 25
                ]),
            ],
            [
                'video_game_id' => 2,
                'title' => 'Guantera fantasma y guantera tumba',
                'type' => 'skin',
                'rarity' => 'rare',
                'description' => 'La guantera se utiliza para mejorar las cenizas espirituales',
                'image' => 'https://static0.gamerantimages.com/wordpress/wp-content/uploads/2024/05/elden-ring-best-spirit-ashes.jpg?q=49&fit=crop&w=825&dpr=2',
                'price' => 4.99,
                'stock' => null,
                'attributes' => json_encode([
                    'speedBoost' => 10
                ]),
            ],
            [
                'video_game_id' => 2,
                'title' => 'Libros de cocina',
                'type' => 'weapon',
                'rarity' => 'epic',
                'description' => 'Desbloquea nuevas recetas de manualidades con libros de cocina',
                'image' => 'https://static0.gamerantimages.com/wordpress/wp-content/uploads/2022/03/elden-ring-cookbook.jpg?q=70&fit=crop&w=825&dpr=1',
                'price' => 7.99,
                'stock' => 20,
                'attributes' => json_encode([
                    'damage' => 75,
                    'range' => 'long'
                ]),
            ],
            [
                'video_game_id' => 7,
                'title' => 'M4A1 –Gold Dust',
                'type' => 'weapon',
                'rarity' => 'legendary',
                'description' => 'Fusil M4A1 con camuflaje Gold Dust y estadísticas mejoradas.',
                'image' => 'https://i.pinimg.com/736x/27/f3/63/27f363c23740f42272ce811fb5e29ef7.jpg',
                'price' => 9.99,
                'stock' => 10,
                'attributes' => json_encode([
                    'damage' => 45,
                    'fire_rate' => 750,
                    'accuracy' => 85,
                ]),
            ],
            [
                'video_game_id' => 7,
                'title' => 'AK-47 – Urban Camo',
                'type' => 'weapon',
                'rarity' => 'epic',
                'description' => 'AK-47 con camuflaje urbano — perfecto para combate en ciudad.',
                'image' => 'https://gunwraps.com/cdn/shop/products/AK-47_Shattered-Blue-Urban-Night.jpg?v=1711726804&width=1000',
                'price' => 7.99,
                'stock' => 15,
                'attributes' => json_encode([
                    'damage' => 48,
                    'fire_rate' => 600,
                    'accuracy' => 80,
                ]),
            ],
            [
                'video_game_id' => 7,
                'title' => 'Ghost Suit Bundle',
                'type' => 'bundle',
                'rarity' => 'rare',
                'description' => 'Paquete inicial: traje táctico Ghost + 500 monedas + skin de pistola Ghost.',
                'image' => 'https://www.charlieintel.com/cdn-image/wp-content/uploads/2023/03/Modern-Warfare-2-Ghost-skins-bundles.jpg',
                'price' => 4.99,
                'stock' => null,
                'attributes' => json_encode([
                    'coins' => 500,
                    'items' => ['ghost_skin_pistol', 'ghost_suit'],
                ]),
            ],
            [
                'video_game_id' => 7,
                'title' => 'Knife – Combat Knife (Red Blade)',
                'type' => 'weapon',
                'rarity' => 'rare',
                'description' => 'Cuchillo cuerpo a cuerpo con hoja roja personalizada.',
                'image' => 'https://karambit.com/cdn/shop/products/A17-BV448_700__41773.1556614308.440.440.jpg?v=1687639351',
                'price' => 2.99,
                'stock' => 50,
                'attributes' => json_encode([
                    'damage' => 60,
                    'speed' => 1.2,
                ]),
            ],
            [
                'video_game_id' => 7,
                'title' => 'Plasma Rifle – Neon Storm',
                'type' => 'weapon',
                'rarity' => 'legendary',
                'description' => 'Rifle futurista con efectos neón y daño eléctrico.',
                'image' => 'https://images.stockcake.com/public/c/8/3/c8384eef-d939-477b-866f-41eb564b2668_large/neon-plasma-rifle-stockcake.jpg',
                'price' => 12.99,
                'stock' => 5,
                'attributes' => json_encode([
                    'damage' => 75,
                    'range' => 'long',
                    'effect' => 'electric shock',
                ]),
            ],
            [
                'video_game_id' => 7,
                'title' => 'Starter Pack – Ammo & Med Kit',
                'type' => 'bundle',
                'rarity' => 'common',
                'description' => 'Paquete de inicio con munición adicional y kit de primeros auxilios.',
                'image' => 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3159170/ss_1aa034c676deb3c0f995753a7274ae0184aded1b.1920x1080.jpg?t=1734567285',
                'price' => 3.99,
                'stock' => null,
                'attributes' => json_encode([
                    'ammo' => 120,
                    'medkits' => 3
                ]),
            ],

        ];

        foreach ($items as $item) {
            MarketItem::create($item);
        }
    }
}
