<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| FRONTEND — PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// ---- Static Pages ----
Route::get('/', ['uses' => 'Web\Frontend\GamesController@index', 'as' => 'frontend.game.list']);
Route::get('/games/{category1?}/{category2?}', ['uses' => 'Web\Frontend\GamesController@index', 'as' => 'frontend.games.category']);
Route::get('/search', ['uses' => 'Web\Frontend\GamesController@search', 'as' => 'frontend.games.search']);
Route::post('/search', ['uses' => 'Web\Frontend\GamesController@search_json', 'as' => 'frontend.games.search_json']);
Route::get('/pages/{slug}', ['uses' => 'Web\Frontend\PagesController@show', 'as' => 'frontend.pages.show']);
Route::get('/tournaments', ['uses' => 'Web\Frontend\TournamentsController@index', 'as' => 'frontend.tournaments.index']);
Route::get('/tournaments/{tournament}', ['uses' => 'Web\Frontend\TournamentsController@show', 'as' => 'frontend.tournaments.show']);
Route::get('/progress', ['uses' => 'Web\Frontend\GamesController@progress', 'as' => 'frontend.progress']);
Route::get('/bonuses', ['uses' => 'Web\Frontend\GamesController@bonuses', 'as' => 'frontend.bonuses']);
Route::get('/bonus-conditions', ['uses' => 'Web\Frontend\GamesController@bonus_conditions', 'as' => 'frontend.bonus_conditions']);
Route::get('/faq', ['uses' => 'Web\Frontend\GamesController@faq', 'as' => 'frontend.faq']);

// ---- Game Routes ----
Route::get('/game/{game}',         ['uses' => 'Web\Frontend\GamesController@go',       'as' => 'frontend.game.show']);
Route::post('/game/{game}/server', ['uses' => 'Web\Frontend\GamesController@server',   'as' => 'frontend.game.server']);
Route::post('/subsession',         ['uses' => 'Web\Frontend\GamesController@subsession','as' => 'frontend.game.subsession']);
Route::post('/balance-add',        ['uses' => 'Web\Frontend\GamesController@balanceAdd','as' => 'frontend.game.balance_add']);
Route::get('/setpage',             ['uses' => 'Web\Frontend\GamesController@setpage',  'as' => 'frontend.game.setpage']);
Route::post('/setpage',            ['uses' => 'Web\Frontend\GamesController@setpage',  'as' => 'frontend.game.setpage.post']);

// ---- Auth ----
Route::get('/login',                ['uses' => 'Web\Frontend\Auth\AuthController@getLogin',    'as' => 'frontend.auth.login']);
Route::post('/login',               ['uses' => 'Web\Frontend\Auth\AuthController@postLogin',   'as' => 'frontend.auth.login.post']);
Route::get('/logout',               ['uses' => 'Web\Frontend\Auth\AuthController@getLogout',   'as' => 'frontend.auth.logout']);
Route::get('/register',             ['uses' => 'Web\Frontend\Auth\AuthController@getRegister', 'as' => 'frontend.auth.register']);
Route::post('/register',            ['uses' => 'Web\Frontend\Auth\AuthController@postRegister','as' => 'frontend.auth.register.post']);
Route::get('/confirm-email/{token}',['uses' => 'Web\Frontend\Auth\AuthController@confirmEmail','as' => 'frontend.auth.confirm-email']);
Route::get('/specauth/{user}',      ['uses' => 'Web\Frontend\Auth\AuthController@specauth',    'as' => 'frontend.auth.specauth']);
Route::get('/apilogin/{game}/{token}',['uses' => 'Web\Frontend\Auth\AuthController@apiLogin',  'as' => 'frontend.auth.apilogin']);

// ---- Password Reset ----
Route::get('/password/remind',      ['uses' => 'Web\Frontend\Auth\PasswordController@getRemind',   'as' => 'frontend.auth.password.remind']);
Route::post('/password/remind',     ['uses' => 'Web\Frontend\Auth\PasswordController@postRemind',  'as' => 'frontend.auth.password.remind.post']);
Route::get('/password/reset/{token}',['uses' => 'Web\Frontend\Auth\PasswordController@getReset',  'as' => 'frontend.auth.password.reset']);
Route::post('/password/reset',      ['uses' => 'Web\Frontend\Auth\PasswordController@postReset',  'as' => 'frontend.auth.password.reset.post']);

// ---- SMS Verification ----
Route::post('/sms/callback',        ['uses' => 'Web\Frontend\SMSController@callback', 'as' => 'sms.callback']);

/*
|--------------------------------------------------------------------------
| FRONTEND — AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {

    // Profile
    Route::get('/profile',                    ['uses' => 'Web\Frontend\ProfileController@index',           'as' => 'frontend.profile.index']);
    Route::post('/profile/update',            ['uses' => 'Web\Frontend\ProfileController@updateDetails',   'as' => 'frontend.profile.update']);
    Route::post('/profile/password',          ['uses' => 'Web\Frontend\ProfileController@updatePassword',  'as' => 'frontend.profile.password']);
    Route::post('/profile/avatar',            ['uses' => 'Web\Frontend\ProfileController@updateAvatar',    'as' => 'frontend.profile.avatar']);
    Route::get('/profile/sessions',           ['uses' => 'Web\Frontend\ProfileController@sessions',        'as' => 'frontend.profile.sessions']);
    Route::delete('/profile/sessions/{id}',   ['uses' => 'Web\Frontend\ProfileController@invalidateSession','as' => 'frontend.profile.sessions.invalidate']);
    Route::post('/profile/withdraw',          ['uses' => 'Web\Frontend\ProfileController@withdraw',        'as' => 'frontend.profile.withdraw']);
    Route::post('/profile/ajax',              ['uses' => 'Web\Frontend\ProfileController@ajax',            'as' => 'frontend.profile.ajax']);
    Route::post('/profile/message',           ['uses' => 'Web\Frontend\ProfileController@message',         'as' => 'frontend.profile.message']);
    Route::post('/profile/daily-entry',       ['uses' => 'Web\Frontend\ProfileController@daily_entry',     'as' => 'frontend.profile.daily_entry']);
    Route::post('/profile/refunds',           ['uses' => 'Web\Frontend\ProfileController@refunds',         'as' => 'frontend.profile.refunds']);
    Route::post('/profile/reward',            ['uses' => 'Web\Frontend\ProfileController@reward',          'as' => 'frontend.profile.reward']);
    Route::post('/profile/pincode',           ['uses' => 'Web\Frontend\ProfileController@pincode',         'as' => 'frontend.profile.pincode']);
    Route::post('/profile/phone',             ['uses' => 'Web\Frontend\ProfileController@phone',           'as' => 'frontend.profile.phone']);
    Route::post('/profile/code',              ['uses' => 'Web\Frontend\ProfileController@code',            'as' => 'frontend.profile.code']);
    Route::post('/profile/agree',             ['uses' => 'Web\Frontend\ProfileController@agree',           'as' => 'frontend.profile.agree']);
    Route::get('/profile/setlang/{lang}',     ['uses' => 'Web\Frontend\ProfileController@setlang',         'as' => 'frontend.profile.setlang']);
    Route::post('/contact',                   ['uses' => 'Web\Frontend\ProfileController@contact_form',    'as' => 'frontend.contact']);

    // Deposit
    Route::post('/profile/deposit/create',    ['uses' => 'Web\Frontend\DepositController@create',          'as' => 'frontend.deposit.create']);

    // KYC
    Route::post('/profile/kyc/upload',        ['uses' => 'Web\Frontend\KycController@upload',              'as' => 'frontend.kyc.upload']);

    // Responsible Gambling
    Route::post('/profile/responsible/exclude', ['uses' => 'Web\Frontend\Responsible\ResponsibleController@exclude', 'as' => 'frontend.responsible.exclude']);
    Route::post('/profile/responsible/limits',  ['uses' => 'Web\Frontend\Responsible\ResponsibleController@limits',  'as' => 'frontend.responsible.limits']);
    Route::post('/profile/responsible/session', ['uses' => 'Web\Frontend\Responsible\ResponsibleController@session', 'as' => 'frontend.responsible.session']);
    Route::post('/profile/responsible/reality', ['uses' => 'Web\Frontend\Responsible\ResponsibleController@reality', 'as' => 'frontend.responsible.reality']);

    // Support Tickets
    // Route::post('/support/create', ['uses' => 'Web\Frontend\TicketController@store', 'as' => 'frontend.support.store']);
    // Route::get('/support/{ticket}',['uses' => 'Web\Frontend\TicketController@show',  'as' => 'frontend.support.show']);
});

/*
|--------------------------------------------------------------------------
| PAYMENT WEBHOOKS — CSRF EXEMPT (handled in VerifyCsrfToken)
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'payment'], function () {
    Route::post('/interkassa/callback',   ['uses' => 'Web\Frontend\Payment\InterkassaController@index',    'as' => 'payment.interkassa.callback']);
    Route::get('/interkassa/success',     ['uses' => 'Web\Frontend\Payment\InterkassaController@success',  'as' => 'payment.interkassa.success']);
    Route::get('/interkassa/fail',        ['uses' => 'Web\Frontend\Payment\InterkassaController@fail',     'as' => 'payment.interkassa.fail']);
    Route::post('/coinbase/callback',     ['uses' => 'Web\Frontend\Payment\CoinbaseController@index',      'as' => 'payment.coinbase.callback']);
    Route::get('/coinbase/success',       ['uses' => 'Web\Frontend\Payment\CoinbaseController@success',    'as' => 'payment.coinbase.success']);
    Route::get('/coinbase/fail',          ['uses' => 'Web\Frontend\Payment\CoinbaseController@fail',       'as' => 'payment.coinbase.fail']);
    Route::get('/coinbase/wait',          ['uses' => 'Web\Frontend\Payment\CoinbaseController@wait',       'as' => 'payment.coinbase.wait']);
    Route::post('/btcpayserver/callback', ['uses' => 'Web\Frontend\Payment\BtcPayServerController@index',  'as' => 'payment.btcpayserver.callback']);
    Route::get('/btcpayserver/redirect',  ['uses' => 'Web\Frontend\Payment\BtcPayServerController@redirect','as' => 'payment.btcpayserver.redirect']);
});

/*
|--------------------------------------------------------------------------
| KYC FILE SERVE (Admin protected)
|--------------------------------------------------------------------------
*/
Route::get('/admin/kyc/{doc}/file', function(\VanguardLTE\KycDocument $doc) {
    if (!auth()->check()) abort(403);
    $path = storage_path('app/' . $doc->file_path);
    if (!file_exists($path)) abort(404);
    return response()->file($path);
})->middleware(['auth', 'session.database'])->name('backend.kyc.file');

/*
|--------------------------------------------------------------------------
| ADMIN BACKEND — All routes require auth + session.database
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth', 'session.database'],
    'namespace'  => 'Web\Backend',
    'as'         => 'backend.',
], function () {

    // Auth
    Route::get('/login',  ['uses' => 'Auth\AuthController@getLogin',  'as' => 'auth.login']);
    Route::post('/login', ['uses' => 'Auth\AuthController@postLogin', 'as' => 'auth.login.post']);
    Route::get('/logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'auth.logout']);

    // Dashboard
    Route::get('/',          ['uses' => 'DashboardController@index', 'as' => 'dashboard']);
    Route::get('/dashboard', ['uses' => 'DashboardController@index', 'as' => 'dashboard.main']);

    // Users
    Route::get('/users',              ['uses' => 'UsersController@index',   'as' => 'user.list']);
    Route::get('/users/create',       ['uses' => 'UsersController@create',  'as' => 'user.create']);
    Route::post('/users',             ['uses' => 'UsersController@store',   'as' => 'user.store']);
    Route::get('/users/{user}/edit',  ['uses' => 'UsersController@edit',    'as' => 'user.edit']);
    Route::put('/users/{user}',       ['uses' => 'UsersController@update',  'as' => 'user.update']);
    Route::delete('/users/{user}',    ['uses' => 'UsersController@destroy', 'as' => 'user.destroy']);
    Route::put('/users/{user}/balance/add', ['uses' => 'UsersController@balanceAdd', 'as' => 'user.balance.add']);
    Route::put('/users/{user}/balance/out', ['uses' => 'UsersController@balanceOut', 'as' => 'user.balance.out']);
    Route::post('/users/balance/update', ['uses' => 'UsersController@updateBalance', 'as' => 'user.balance.update']);
    Route::get('/activity',           ['uses' => 'ActivityController@index','as' => 'user.activity']);
    Route::post('/users/{user}/block',['uses' => 'UsersController@block',   'as' => 'user.block']);

    // Shops
    Route::get('/shops',              ['uses' => 'ShopsController@index',   'as' => 'shop.list']);
    Route::get('/shops/create',       ['uses' => 'ShopsController@create',  'as' => 'shop.create']);
    Route::post('/shops',             ['uses' => 'ShopsController@store',   'as' => 'shop.store']);
    Route::get('/shops/{shop}/edit',  ['uses' => 'ShopsController@edit',    'as' => 'shop.edit']);
    Route::put('/shops/{shop}',       ['uses' => 'ShopsController@update',  'as' => 'shop.update']);
    Route::delete('/shops/{shop}',    ['uses' => 'ShopsController@destroy', 'as' => 'shop.destroy']);
    Route::get('/shops/{shop}/balance',['uses' => 'ShopsController@balance','as' => 'shop.balance']);
    Route::get('/profile/setshop',    ['uses' => 'ShopsController@setshop', 'as' => 'profile.setshop']);

    // Games
    Route::get('/games',              ['uses' => 'GamesController@index',   'as' => 'game.list']);
    Route::get('/games/create',       ['uses' => 'GamesController@create',  'as' => 'game.create']);
    Route::post('/games',             ['uses' => 'GamesController@store',   'as' => 'game.store']);
    Route::get('/games/{game}/edit',  ['uses' => 'GamesController@edit',    'as' => 'game.edit']);
    Route::put('/games/{game}',       ['uses' => 'GamesController@update',  'as' => 'game.update']);
    Route::delete('/games/{game}',    ['uses' => 'GamesController@destroy', 'as' => 'game.destroy']);
    Route::post('/games/clear',       ['uses' => 'GamesController@clear',   'as' => 'game.clear']);
    Route::post('/games/clear-games', ['uses' => 'GamesController@clear_games','as' => 'game.clear_games']);

    // Categories
    Route::get('/categories',                ['uses' => 'CategoriesController@index',   'as' => 'category.list']);
    Route::post('/categories',               ['uses' => 'CategoriesController@store',   'as' => 'category.store']);
    Route::put('/categories/{category}',     ['uses' => 'CategoriesController@update',  'as' => 'category.update']);
    Route::delete('/categories/{category}',  ['uses' => 'CategoriesController@destroy', 'as' => 'category.destroy']);

    // Tournaments
    Route::get('/tournaments',               ['uses' => 'TournamentController@index',   'as' => 'tournament.list']);
    Route::get('/tournaments/create',        ['uses' => 'TournamentController@create',  'as' => 'tournament.create']);
    Route::post('/tournaments',              ['uses' => 'TournamentController@store',   'as' => 'tournament.store']);
    Route::get('/tournaments/{t}/edit',      ['uses' => 'TournamentController@edit',    'as' => 'tournament.edit']);
    Route::put('/tournaments/{t}',           ['uses' => 'TournamentController@update',  'as' => 'tournament.update']);
    Route::delete('/tournaments/{t}',        ['uses' => 'TournamentController@destroy', 'as' => 'tournament.destroy']);

    // Settings
    Route::get('/settings',                  ['uses' => 'SettingsController@index',  'as' => 'settings']);
    Route::put('/settings',                  ['uses' => 'SettingsController@update', 'as' => 'settings.update']);
    Route::post('/settings/banks',           ['uses' => 'SettingsController@banks',  'as' => 'settings.banks']);
    Route::post('/settings/banks-update',    ['uses' => 'SettingsController@banks_update','as'=>'settings.banks.update']);

    // Jackpots
    Route::get('/jackpots',                  ['uses' => 'JPGController@index',   'as' => 'jpg.list']);
    Route::post('/jackpots',                 ['uses' => 'JPGController@store',   'as' => 'jpg.store']);
    Route::put('/jackpots/{jpg}',            ['uses' => 'JPGController@update',  'as' => 'jpg.update']);
    Route::delete('/jackpots/{jpg}',         ['uses' => 'JPGController@destroy', 'as' => 'jpg.destroy']);

    // Happy Hours
    Route::get('/happyhours',                ['uses' => 'HappyHourController@index',   'as' => 'happyhour.list']);
    Route::post('/happyhours',               ['uses' => 'HappyHourController@store',   'as' => 'happyhour.store']);
    Route::put('/happyhours/{hh}',           ['uses' => 'HappyHourController@update',  'as' => 'happyhour.update']);
    Route::delete('/happyhours/{hh}',        ['uses' => 'HappyHourController@destroy', 'as' => 'happyhour.destroy']);

    // VIP Progress
    Route::get('/progress',                  ['uses' => 'ProgressController@index',   'as' => 'progress.list']);
    Route::post('/progress',                 ['uses' => 'ProgressController@store',   'as' => 'progress.store']);
    Route::put('/progress/{p}',              ['uses' => 'ProgressController@update',  'as' => 'progress.update']);
    Route::delete('/progress/{p}',           ['uses' => 'ProgressController@destroy', 'as' => 'progress.destroy']);

    // Welcome Bonuses
    Route::get('/welcomebonus',              ['uses' => 'WelcomeBonusController@index',   'as' => 'welcomebonus.list']);
    Route::post('/welcomebonus',             ['uses' => 'WelcomeBonusController@store',   'as' => 'welcomebonus.store']);
    Route::put('/welcomebonus/{wb}',         ['uses' => 'WelcomeBonusController@update',  'as' => 'welcomebonus.update']);
    Route::delete('/welcomebonus/{wb}',      ['uses' => 'WelcomeBonusController@destroy', 'as' => 'welcomebonus.destroy']);

    // SMS Bonus & Mailing
    Route::get('/smsbonus',                  ['uses' => 'SMSBonusController@index',      'as' => 'smsbonus.list']);
    Route::post('/smsbonus',                 ['uses' => 'SMSBonusController@store',      'as' => 'smsbonus.store']);
    Route::put('/smsbonus/{sb}',             ['uses' => 'SMSBonusController@update',     'as' => 'smsbonus.update']);
    Route::delete('/smsbonus/{sb}',          ['uses' => 'SMSBonusController@destroy',    'as' => 'smsbonus.destroy']);
    Route::get('/smsmailing',                ['uses' => 'SMSMailingController@index',    'as' => 'smsmailing.list']);
    Route::post('/smsmailing',               ['uses' => 'SMSMailingController@store',    'as' => 'smsmailing.store']);
    Route::delete('/smsmailing/{sm}',        ['uses' => 'SMSMailingController@destroy',  'as' => 'smsmailing.destroy']);

    // Support Tickets
    Route::get('/support',                   ['uses' => 'SupportController@index',   'as' => 'support.list']);
    Route::get('/support/{ticket}',          ['uses' => 'SupportController@view',    'as' => 'support.show']);
    Route::post('/support/{ticket}/answer',  ['uses' => 'SupportController@answer',  'as' => 'support.answer']);
    Route::post('/support/{ticket}/close',   ['uses' => 'SupportController@close',   'as' => 'support.destroy']);

    // KYC Review
    Route::get('/kyc',                       ['uses' => 'KycController@index',   'as' => 'kyc.list']);
    Route::get('/kyc/{doc}',                 ['uses' => 'KycController@show',    'as' => 'kyc.show']);
    Route::post('/kyc/{doc}/approve',        ['uses' => 'KycController@approve', 'as' => 'kyc.approve']);
    Route::post('/kyc/{doc}/reject',         ['uses' => 'KycController@reject',  'as' => 'kyc.reject']);
    Route::get('/kyc/user/{user}',           ['uses' => 'KycController@user',    'as' => 'kyc.user']);

    // Withdrawals
    Route::get('/withdrawals',               ['uses' => 'WithdrawController@index',   'as' => 'withdraw.list']);
    Route::post('/withdrawals/{w}/approve',  ['uses' => 'WithdrawController@approve', 'as' => 'withdraw.approve']);
    Route::post('/withdrawals/{w}/reject',   ['uses' => 'WithdrawController@reject',  'as' => 'withdraw.reject']);

    // Statistics & Reports
    Route::get('/statistics',                ['uses' => 'RefundsController@index',   'as' => 'statistics.index']);
    Route::get('/refunds',                   ['uses' => 'RefundsController@refunds', 'as' => 'refunds.list']);

    // Roles & Permissions
    Route::get('/roles',                     ['uses' => 'RolesController@index',   'as' => 'role.list']);
    Route::post('/roles',                    ['uses' => 'RolesController@store',   'as' => 'role.store']);
    Route::put('/roles/{role}',              ['uses' => 'RolesController@update',  'as' => 'role.update']);
    Route::delete('/roles/{role}',           ['uses' => 'RolesController@destroy', 'as' => 'role.destroy']);
    Route::get('/permissions',               ['uses' => 'PermissionsController@index', 'as' => 'permission.list']);

    // Content
    Route::get('/articles',                  ['uses' => 'ArticlesController@index',   'as' => 'article.list']);
    Route::post('/articles',                 ['uses' => 'ArticlesController@store',   'as' => 'article.store']);
    Route::put('/articles/{a}',              ['uses' => 'ArticlesController@update',  'as' => 'article.update']);
    Route::delete('/articles/{a}',           ['uses' => 'ArticlesController@destroy', 'as' => 'article.destroy']);
    Route::get('/faq',                       ['uses' => 'FaqsController@index',       'as' => 'faq.list']);
    Route::post('/faq',                      ['uses' => 'FaqsController@store',       'as' => 'faq.store']);
    Route::put('/faq/{f}',                   ['uses' => 'FaqsController@update',      'as' => 'faq.update']);
    Route::delete('/faq/{f}',               ['uses' => 'FaqsController@destroy',     'as' => 'faq.destroy']);
    Route::get('/rules',                     ['uses' => 'RulesController@index',  'as' => 'rules.list']);
    Route::put('/rules',                     ['uses' => 'RulesController@update', 'as' => 'rules.update']);

    // ATM & Pincodes
    Route::get('/atm',                       ['uses' => 'AtmController@index',       'as' => 'atm.list']);
    Route::post('/atm',                      ['uses' => 'AtmController@store',       'as' => 'atm.store']);
    Route::get('/atm/{atm}/create',          ['uses' => 'AtmController@createNewAtm','as' => 'atm.create']);
    Route::get('/pincodes',                  ['uses' => 'PincodeController@index',   'as' => 'pincode.list']);
    Route::post('/pincodes',                 ['uses' => 'PincodeController@store',   'as' => 'pincode.store']);
    Route::delete('/pincodes/{pincode}',     ['uses' => 'PincodeController@destroy', 'as' => 'pincode.destroy']);

    // Credits
    Route::get('/credits',                   ['uses' => 'CreditController@index',   'as' => 'credit.list']);
    Route::post('/credits',                  ['uses' => 'CreditController@store',   'as' => 'credit.store']);
    Route::put('/credits/{c}',               ['uses' => 'CreditController@update',  'as' => 'credit.update']);
    Route::delete('/credits/{c}',            ['uses' => 'CreditController@destroy', 'as' => 'credit.destroy']);

    // Info Messages
    Route::get('/info',                      ['uses' => 'InfoController@index',   'as' => 'info.list']);
    Route::post('/info',                     ['uses' => 'InfoController@store',   'as' => 'info.store']);
    Route::delete('/info/{info}',            ['uses' => 'InfoController@destroy', 'as' => 'info.destroy']);

    // Terminal & Admin Profile
    Route::get('/terminal',                  ['uses' => 'TerminalController@index',         'as' => 'terminal.index']);
    Route::post('/terminal/create',          ['uses' => 'TerminalController@craeteTerminal', 'as' => 'terminal.create']);
    Route::get('/profile',                   ['uses' => 'ProfileController@index',           'as' => 'profile.index']);
    Route::put('/profile',                   ['uses' => 'ProfileController@update',          'as' => 'profile.update']);
    Route::put('/profile/password',          ['uses' => 'ProfileController@updatePassword',  'as' => 'profile.password']);

    // API Keys
    Route::get('/api-keys',                  ['uses' => 'ApiController@index',   'as' => 'api.list']);
    Route::post('/api-keys',                 ['uses' => 'ApiController@store',   'as' => 'api.store']);
    Route::delete('/api-keys/{api}',         ['uses' => 'ApiController@destroy', 'as' => 'api.destroy']);

    // Open Shifts
    Route::post('/shift/open',               ['uses' => 'DashboardController@start_shift',  'as' => 'shift.open']);
    Route::get('/shifts',                    ['uses' => 'DashboardController@shift_stat', 'as' => 'shift.list']);

    // Wheel of Fortune
    Route::get('/wheel',                     ['uses' => 'DashboardController@wheelfortune',   'as' => 'wheel.list']);
    Route::post('/wheel',                    ['uses' => 'DashboardController@wheelfortune_update',   'as' => 'wheel.store']);
    Route::get('/wheel/status/{status}',     ['uses' => 'DashboardController@wheelfortune_status',  'as' => 'wheel.status']);

    // Invites/Referrals
    Route::get('/invites',                   ['uses' => 'DashboardController@invites',   'as' => 'invite.list']);
    Route::post('/invites',                  ['uses' => 'DashboardController@invite_update',   'as' => 'invite.store']);
    Route::get('/invites/status/{status}',   ['uses' => 'DashboardController@invite_status', 'as' => 'invite.status']);

    // Bonus Preset
    // Route::get('/bonus-preset',              ['uses' => 'BonusPresetController@index',   'as' => 'bonuspreset.list']);
    // Route::post('/bonus-preset',             ['uses' => 'BonusPresetController@store',   'as' => 'bonuspreset.store']);
    // Route::put('/bonus-preset/{bp}',         ['uses' => 'BonusPresetController@update',  'as' => 'bonuspreset.update']);
    // Route::delete('/bonus-preset/{bp}',      ['uses' => 'BonusPresetController@destroy', 'as' => 'bonuspreset.destroy']);
});
