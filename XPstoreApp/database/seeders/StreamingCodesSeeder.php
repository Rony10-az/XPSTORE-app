<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StreamingCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $items = [
            [
                'service' => 'Netflix',
                'duration' => '1 mes',
                'code' => 'NETFLIX-ABC123',
                'price' => 8.99,
                'stock' => 10,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2504/2504929.png',
            ],
            [
                'service' => 'Disney+',
                'duration' => '3 meses',
                'code' => 'DISNEY-9FJ83K',
                'price' => 17.49,
                'stock' => 6,
                'image' => 'https://store-images.s-microsoft.com/image/apps.14187.14495311847124170.7646206e-bd82-4cf0-8b8c-d06a67bc302c.2e474878-acb7-4afb-a503-c2a1a32feaa8',
            ],
            [
                'service' => 'Crunchyroll',
                'duration' => '1 mes Premium',
                'code' => 'CRUNCH-88KD9D',
                'price' => 6.99,
                'stock' => 12,
                'image' => 'https://images.squarespace-cdn.com/content/v1/546c18a6e4b05a70ad8190fe/1570072348254-DWYPP1G06FC18FAJK2H3/Screen%2BShot%2B2018-02-26%2Bat%2B10.53.26%2BPM.png',
            ],
            [
                'service' => 'HBO Max',
                'duration' => '30 días',
                'code' => 'HBO-22KKCSS',
                'price' => 7.99,
                'stock' => 8,
                'image' => 'https://logos-world.net/wp-content/uploads/2020/04/HBO-Max-Logo-700x394.png',
            ],
            [
                'service' => 'Spotify Premium',
                'duration' => '1 mes',
                'code' => 'SPOTI-A83KS9',
                'price' => 5.99,
                'stock' => 20,
                'image' => 'https://cdn.pixabay.com/photo/2016/10/22/00/15/spotify-1759471_1280.jpg',
            ],
        ];

        foreach ($items as $item) {
            \App\Models\StreamingCode::updateOrCreate(
                ['code' => $item['code']],
                $item
            );
        }
    }
}
