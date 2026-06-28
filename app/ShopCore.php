<?php

/**
 * ShopCore.php (Production Safe Version)
 * Prevents DB access during build/boot phase
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if (!function_exists('safe_db')) {
    function safe_db(callable $callback, $default = null) {
        try {
            if (app()->runningInConsole() || !app()->bound('db')) {
                return $default;
            }
            return $callback();
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (!function_exists('get_shop_setting')) {
    function get_shop_setting($key, $shop_id = null, $default = null) {
        return safe_db(function () use ($key, $shop_id, $default) {
            return \VanguardLTE\Lib\Setting::get_value_raw($key, $shop_id)
                ?? settings($key, $default);
        }, $default);
    }
}

if (!function_exists('get_user_shop_id')) {
    function get_user_shop_id() {
        return safe_db(function () {
            return Auth::check() ? (Auth::user()->shop_id ?: 1) : 1;
        }, 1);
    }
}

if (!function_exists('get_shop')) {
    function get_shop($shop_id = null) {
        return safe_db(function () use ($shop_id) {
            $id = $shop_id ?: get_user_shop_id();
            return \VanguardLTE\Shop::find($id);
        }, null);
    }
}

if (!function_exists('get_shop_currency')) {
    function get_shop_currency($shop_id = null) {
        return safe_db(function () use ($shop_id) {
            $shop = get_shop($shop_id);
            return $shop ? $shop->currency : settings('currency', 'USD');
        }, 'USD');
    }
}

if (!function_exists('shop_has_game')) {
    function shop_has_game($game_id, $shop_id = null) {
        return safe_db(function () use ($game_id, $shop_id) {
            $id = $shop_id ?: get_user_shop_id();

            return \VanguardLTE\Game::where([
                    'id' => $game_id,
                    'shop_id' => $id,
                    'view' => 1
                ])->exists()
                || \VanguardLTE\Game::where([
                    'id' => $game_id,
                    'shop_id' => 0,
                    'view' => 1
                ])->exists();
        }, false);
    }
}

if (!function_exists('get_shop_games')) {
    function get_shop_games($shop_id = null, $category = null) {
        return safe_db(function () use ($shop_id, $category) {
            $id = $shop_id ?: get_user_shop_id();

            $query = \VanguardLTE\Game::where('view', 1)
                ->where(function ($q) use ($id) {
                    $q->where('shop_id', 0)
                      ->orWhere('shop_id', $id);
                });

            if ($category) {
                $cat = \VanguardLTE\Category::where('href', $category)->first();
                if ($cat) {
                    $query->where('category_id', $cat->id);
                }
            }

            return $query->get();
        }, collect([]));
    }
}

if (!function_exists('get_shop_balance')) {
    function get_shop_balance($shop_id = null) {
        return safe_db(function () use ($shop_id) {
            $id = $shop_id ?: get_user_shop_id();
            $bank = \VanguardLTE\GameBank::where('shop_id', $id)->first();
            return $bank ? $bank->slots : 0;
        }, 0);
    }
}

if (!function_exists('is_shop_payment_enabled')) {
    function is_shop_payment_enabled($system, $shop_id = null) {
        return safe_db(function () use ($system, $shop_id) {
            return \VanguardLTE\Lib\Setting::is_available(
                $system,
                $shop_id ?: get_user_shop_id()
            );
        }, false);
    }
}

if (!function_exists('get_shop_frontend')) {
    function get_shop_frontend($shop_id = null) {
        return safe_db(function () use ($shop_id) {
            $shop = get_shop($shop_id);
            return $shop && $shop->frontend
                ? $shop->frontend
                : settings('frontend', 'Default');
        }, 'Default');
    }
}

if (!function_exists('shop_log')) {
    function shop_log($type, $data = [], $shop_id = null) {
        try {
            Log::info("ShopCore[$type]", array_merge([
                'shop_id' => $shop_id ?: get_user_shop_id()
            ], $data));
        } catch (\Throwable $e) {
            // silent fail
        }
    }
}