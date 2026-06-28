<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'All Games',       'href' => 'all',       'icon' => 'all',       'sort' => 1,  'status' => 1],
            ['name' => 'Slots',           'href' => 'slots',     'icon' => 'slots',     'sort' => 2,  'status' => 1],
            ['name' => 'New Games',       'href' => 'new',       'icon' => 'new',       'sort' => 3,  'status' => 1],
            ['name' => 'Hot Games',       'href' => 'hot',       'icon' => 'hot',       'sort' => 4,  'status' => 1],
            ['name' => 'Table Games',     'href' => 'table',     'icon' => 'table',     'sort' => 5,  'status' => 1],
            ['name' => 'Card Games',      'href' => 'card',      'icon' => 'card',      'sort' => 6,  'status' => 1],
            ['name' => 'Jackpots',        'href' => 'jackpot',   'icon' => 'jackpot',   'sort' => 7,  'status' => 1],
            ['name' => 'Book Games',      'href' => 'book',      'icon' => 'book',      'sort' => 8,  'status' => 1],
            ['name' => 'Fruit Games',     'href' => 'fruit',     'icon' => 'fruit',     'sort' => 9,  'status' => 1],
            ['name' => 'Bonus Buy',       'href' => 'bonus_buy', 'icon' => 'bonus',     'sort' => 10, 'status' => 1],
            ['name' => 'Video Poker',     'href' => 'poker',     'icon' => 'poker',     'sort' => 11, 'status' => 1],
            ['name' => 'My Games',        'href' => 'my_games',  'icon' => 'my_games',  'sort' => 12, 'status' => 1],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['href' => $cat['href']],
                array_merge($cat, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // Seed a sample of games into the games table
        $gameNames = [];
        $gamesPath = base_path('app/Games');
        if (is_dir($gamesPath)) {
            $gameNames = array_filter(scandir($gamesPath), function($d) use ($gamesPath) {
                return is_dir("$gamesPath/$d") && !in_array($d, ['.', '..']);
            });
        }

        $slotCatId = DB::table('categories')->where('href', 'slots')->value('id') ?: 1;

        foreach ($gameNames as $name) {
            if (!DB::table('games')->where(['name' => $name, 'shop_id' => 0])->exists()) {
                // Detect category
                $n = strtolower($name);
                $catId = $slotCatId;
                if (str_contains($n, 'book')) $catId = DB::table('categories')->where('href','book')->value('id') ?: $slotCatId;
                elseif (str_contains($n, 'fruit') || str_contains($n, 'cherry') || str_contains($n, 'lemon')) $catId = DB::table('categories')->where('href','fruit')->value('id') ?: $slotCatId;
                elseif (str_contains($n, 'poker')) $catId = DB::table('categories')->where('href','poker')->value('id') ?: $slotCatId;
                elseif (str_contains($n, 'jackpot') || str_contains($n, 'mega') || str_contains($n, 'million')) $catId = DB::table('categories')->where('href','jackpot')->value('id') ?: $slotCatId;

                DB::table('games')->insert([
                    'name'        => $name,
                    'title'       => trim(preg_replace('/([A-Z])/', ' $1', preg_replace('/(EGT|AM|GT|GTM|PT|PTM|KA|PM|PMM|NG|MN|CT|BS|WD|VS|ISB|GM|PG|PGD|DX)$/', '', $name))),
                    'shop_id'     => 0,
                    'category_id' => $catId,
                    'view'        => 1,
                    'status'      => 1,
                    'rtp'         => 96,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $count = DB::table('games')->count();
        echo "Categories and Games seeded: {$count} games\n";
    }
}
