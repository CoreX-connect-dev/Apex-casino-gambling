<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // ---- App ----
            ['key' => 'app_name',           'value' => 'CasinoPlatform'],
            ['key' => 'frontend',           'value' => 'Default'],
            ['key' => 'currency',           'value' => 'USD'],
            ['key' => 'currency_symbol',    'value' => '$'],
            ['key' => 'language',           'value' => 'en'],
            ['key' => 'timezone',           'value' => 'UTC'],
            ['key' => 'logo',               'value' => ''],
            ['key' => 'favicon',            'value' => ''],
            ['key' => 'footer_text',        'value' => '© 2026 CasinoPlatform. 18+ only. Play responsibly.'],
            ['key' => 'meta_description',   'value' => 'Best online casino with 1185 games.'],
            ['key' => 'meta_keywords',      'value' => 'casino, slots, online gambling'],

            // ---- Registration ----
            ['key' => 'reg_enabled',        'value' => '1'],
            ['key' => 'reg_phone',          'value' => '0'],
            ['key' => 'reg_email_confirm',  'value' => '0'],
            ['key' => 'reg_welcome_bonus',  'value' => '1'],
            ['key' => 'reg_bonus_amount',   'value' => '20'],

            // ---- Payments ----
            ['key' => 'payment_interkassa', 'value' => '0'],
            ['key' => 'payment_coinbase',   'value' => '0'],
            ['key' => 'payment_btcpayserver','value' => '0'],
            ['key' => 'payment_pin',        'value' => '1'],
            ['key' => 'min_deposit',        'value' => '10'],
            ['key' => 'min_withdraw',       'value' => '20'],
            ['key' => 'max_withdraw',       'value' => '10000'],

            // ---- Game Settings ----
            ['key' => 'game_demo',          'value' => '1'],
            ['key' => 'game_freespin',      'value' => '1'],
            ['key' => 'rtp_default',        'value' => '96'],
            ['key' => 'max_bet',            'value' => '100'],
            ['key' => 'min_bet',            'value' => '0.10'],

            // ---- Bonuses ----
            ['key' => 'bonus_enabled',      'value' => '1'],
            ['key' => 'daily_entry_bonus',  'value' => '1'],
            ['key' => 'daily_entry_amount', 'value' => '0.50'],
            ['key' => 'cashback_percent',   'value' => '5'],
            ['key' => 'tournament_enabled', 'value' => '1'],
            ['key' => 'happyhour_enabled',  'value' => '1'],
            ['key' => 'jackpot_enabled',    'value' => '1'],
            ['key' => 'wheel_enabled',      'value' => '1'],
            ['key' => 'invite_bonus',       'value' => '10'],

            // ---- Contact ----
            ['key' => 'support_email',      'value' => 'support@casino.com'],
            ['key' => 'support_phone',      'value' => ''],
            ['key' => 'live_chat_enabled',  'value' => '0'],

            // ---- Security ----
            ['key' => '2fa_enabled',        'value' => '0'],
            ['key' => 'kyc_required',       'value' => '1'],
            ['key' => 'ip_block_enabled',   'value' => '0'],

            // ---- Maintenance ----
            ['key' => 'maintenance_mode',   'value' => '0'],
            ['key' => 'maintenance_message','value' => 'Platform is under maintenance. Be right back!'],

            // ---- Social ----
            ['key' => 'facebook_url',       'value' => ''],
            ['key' => 'instagram_url',      'value' => ''],
            ['key' => 'telegram_url',       'value' => ''],
        ];

        foreach ($settings as $s) {
            DB::table('settings')->updateOrInsert(['key' => $s['key']], ['value' => $s['value']]);
        }

        echo "Settings seeded: " . count($settings) . " entries\n";
    }
}
