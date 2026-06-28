<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    public function run()
    {
        // Create the main casino shop (ID=1)
        if (!DB::table('shops')->where('id', 1)->exists()) {
            DB::table('shops')->insert([
                'id'         => 1,
                'name'       => 'Main Casino',
                'slug'       => 'main',
                'currency'   => 'USD',
                'frontend'   => 'Default',
                'status'     => 1,
                'parent_id'  => null,
                'balance'    => 100000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Assign admin user to shop 1
        DB::table('users')->where('email', 'admin@admin.com')->update(['shop_id' => 1]);

        // Create GameBank for shop 1
        if (!DB::table('game_banks')->where('shop_id', 1)->exists()) {
            DB::table('game_banks')->insert([
                'shop_id'    => 1,
                'slots'      => 50000,
                'bonus'      => 10000,
                'table_bank' => 10000,
                'little'     => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create FishBank for shop 1
        if (!DB::table('fish_banks')->where('shop_id', 1)->exists()) {
            DB::table('fish_banks')->insert([
                'shop_id'    => 1,
                'fish'       => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "Shop seeded: Main Casino (ID=1)\n";
    }
}
