<?php
/**
 * ShopGame.php
 * Game-related helper functions included by all controllers
 */

if (!function_exists('get_game_by_name')) {
    function get_game_by_name($name, $shop_id = null) {
        try {
            $id = $shop_id ?: get_user_shop_id();
            $game = \VanguardLTE\Game::where(['name' => $name, 'shop_id' => $id])->first();
            if (!$game) {
                $game = \VanguardLTE\Game::where(['name' => $name, 'shop_id' => 0])->first();
            }
            return $game;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('game_class_exists')) {
    function game_class_exists($game_name) {
        $class = "VanguardLTE\\Games\\{$game_name}\\Server";
        return class_exists($class);
    }
}

if (!function_exists('get_game_server')) {
    function get_game_server($game_name) {
        try {
            $class = "VanguardLTE\\Games\\{$game_name}\\Server";
            if (class_exists($class)) {
                return new $class();
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('get_game_settings')) {
    function get_game_settings($game, $user_id = null) {
        try {
            $uid = $user_id ?: (auth()->check() ? auth()->id() : 0);
            $class = "VanguardLTE\\Games\\{$game->name}\\SlotSettings";
            if (class_exists($class)) {
                return new $class($game, $uid);
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('is_game_available')) {
    function is_game_available($game, $shop_id = null) {
        try {
            if (!$game || !$game->view) return false;
            $id = $shop_id ?: get_user_shop_id();
            if ($game->shop_id != 0 && $game->shop_id != $id) return false;
            return game_class_exists($game->name);
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('get_game_rtp')) {
    function get_game_rtp($game, $shop_id = null) {
        try {
            $id = $shop_id ?: get_user_shop_id();
            $shopGame = \VanguardLTE\Game::where(['name' => $game->name, 'shop_id' => $id])->first();
            if ($shopGame && $shopGame->rtp) return $shopGame->rtp;
            return $game->rtp ?? 96;
        } catch (\Exception $e) {
            return 96;
        }
    }
}

if (!function_exists('get_game_categories')) {
    function get_game_categories($shop_id = null) {
        try {
            return \VanguardLTE\Category::where('status', 1)->orderBy('sort')->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }
}

if (!function_exists('get_game_thumbnail')) {
    function get_game_thumbnail($game_name) {
        $paths = [
            "/woocasino/images/games/{$game_name}.jpg",
            "/woocasino/images/games/{$game_name}.png",
            "/frontend/Default/img/games/{$game_name}.jpg",
        ];
        foreach ($paths as $path) {
            if (file_exists(public_path($path))) return $path;
        }
        return "/woocasino/images/game_placeholder.jpg";
    }
}

if (!function_exists('record_game_stat')) {
    function record_game_stat($user_id, $game_id, $bet, $win, $shop_id = null) {
        try {
            \VanguardLTE\StatGame::create([
                'user_id'  => $user_id,
                'game_id'  => $game_id,
                'bet'      => $bet,
                'win'      => $win,
                'shop_id'  => $shop_id ?: get_user_shop_id(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('record_game_stat: ' . $e->getMessage());
        }
    }
}

if (!function_exists('get_jackpot_for_game')) {
    function get_jackpot_for_game($game_id, $shop_id = null) {
        try {
            $id = $shop_id ?: get_user_shop_id();
            return \VanguardLTE\JPG::where('shop_id', $id)
                ->where(function($q) use ($game_id) {
                    $q->whereRaw("FIND_IN_SET(?, games)", [$game_id])
                      ->orWhere('games', '');
                })->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }
}

if (!function_exists('get_happy_hour')) {
    function get_happy_hour($game_id = null, $shop_id = null) {
        try {
            $id = $shop_id ?: get_user_shop_id();
            $now = now();
            return \VanguardLTE\HappyHour::where('shop_id', $id)
                ->where('status', 1)
                ->where('start_time', '<=', $now->format('H:i:s'))
                ->where('end_time', '>=', $now->format('H:i:s'))
                ->first();
        } catch (\Exception $e) {
            return null;
        }
    }
}
