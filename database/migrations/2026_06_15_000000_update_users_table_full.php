<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('currency', 10)->default('USD')->after('password');
            $table->string('avatar')->nullable()->after('currency');
            $table->decimal('balance', 15, 2)->default(0.00)->after('avatar');
            $table->decimal('shop_limit', 15, 2)->default(0.00)->after('balance');
            $table->timestamp('last_login')->nullable()->after('shop_limit');
            $table->string('confirmation_token')->nullable()->after('last_login');
            $table->enum('status', ['Active', 'Banned', 'Unconfirmed'])->default('Active')->after('confirmation_token');
            $table->boolean('is_demo_agent')->default(false)->after('status');
            $table->string('google2fa_secret')->nullable()->after('is_demo_agent');
            $table->boolean('google2fa_enable')->default(false)->after('google2fa_secret');
            $table->integer('rating')->default(0)->after('google2fa_enable');
            $table->boolean('agreed')->default(false)->after('rating');
            $table->boolean('free_demo')->default(false)->after('agreed');
            
            // Stats & Counters
            $table->integer('count_tournaments')->default(0)->after('free_demo');
            $table->integer('count_happyhours')->default(0)->after('count_tournaments');
            $table->integer('count_refunds')->default(0)->after('count_happyhours');
            $table->integer('count_progress')->default(0)->after('count_refunds');
            $table->integer('count_daily_entries')->default(0)->after('count_progress');
            $table->integer('count_invite')->default(0)->after('count_daily_entries');
            $table->integer('count_welcomebonus')->default(0)->after('count_invite');
            $table->integer('count_smsbonus')->default(0)->after('count_welcomebonus');
            $table->integer('count_wheelfortune')->default(0)->after('count_smsbonus');
            
            $table->decimal('tournaments', 15, 2)->default(0)->after('count_wheelfortune');
            $table->decimal('happyhours', 15, 2)->default(0)->after('tournaments');
            $table->decimal('refunds', 15, 2)->default(0)->after('happyhours');
            $table->decimal('progress', 15, 2)->default(0)->after('refunds');
            $table->decimal('daily_entries', 15, 2)->default(0)->after('progress');
            $table->decimal('invite', 15, 2)->default(0)->after('daily_entries');
            $table->decimal('welcomebonus', 15, 2)->default(0)->after('invite');
            $table->decimal('smsbonus', 15, 2)->default(0)->after('welcomebonus');
            $table->decimal('wheelfortune', 15, 2)->default(0)->after('smsbonus');
            
            $table->decimal('total_in', 15, 2)->default(0)->after('wheelfortune');
            $table->decimal('total_out', 15, 2)->default(0)->after('total_in');
            $table->string('language', 5)->default('en')->after('total_out');
            $table->string('phone')->nullable()->after('language');
            $table->boolean('phone_verified')->default(false)->after('phone');
            $table->string('sms_token')->nullable()->after('phone_verified');
            $table->unsignedBigInteger('inviter_id')->nullable()->after('sms_token');
            $table->unsignedBigInteger('role_id')->default(1)->after('inviter_id');
            $table->decimal('count_balance', 15, 2)->default(0)->after('role_id');
            $table->unsignedBigInteger('parent_id')->nullable()->after('count_balance');
            $table->unsignedBigInteger('shop_id')->nullable()->after('parent_id');
            $table->text('session')->nullable()->after('shop_id');
            $table->boolean('is_blocked')->default(false)->after('session');
            $table->string('auth_token')->nullable()->after('is_blocked');
            $table->timestamp('last_online')->nullable()->after('auth_token');
            $table->timestamp('sms_token_date')->nullable()->after('last_online');
            $table->timestamp('last_daily_entry')->nullable()->after('sms_token_date');
            $table->timestamp('last_bid')->nullable()->after('last_daily_entry');
            $table->timestamp('last_progress')->nullable()->after('last_bid');
            $table->timestamp('last_wheelfortune')->nullable()->after('last_progress');
            
            // Required for User model methods
            $table->decimal('address', 15, 2)->default(0)->after('last_wheelfortune'); 
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('currency');
            $table->dropColumn('avatar');
            $table->dropColumn('balance');
            $table->dropColumn('shop_limit');
            $table->dropColumn('last_login');
            $table->dropColumn('confirmation_token');
            $table->dropColumn('status');
            $table->dropColumn('is_demo_agent');
            $table->dropColumn('google2fa_secret');
            $table->dropColumn('google2fa_enable');
            $table->dropColumn('rating');
            $table->dropColumn('agreed');
            $table->dropColumn('free_demo');
            $table->dropColumn('count_tournaments');
            $table->dropColumn('count_happyhours');
            $table->dropColumn('count_refunds');
            $table->dropColumn('count_progress');
            $table->dropColumn('count_daily_entries');
            $table->dropColumn('count_invite');
            $table->dropColumn('count_welcomebonus');
            $table->dropColumn('count_smsbonus');
            $table->dropColumn('count_wheelfortune');
            $table->dropColumn('tournaments');
            $table->dropColumn('happyhours');
            $table->dropColumn('refunds');
            $table->dropColumn('progress');
            $table->dropColumn('daily_entries');
            $table->dropColumn('invite');
            $table->dropColumn('welcomebonus');
            $table->dropColumn('smsbonus');
            $table->dropColumn('wheelfortune');
            $table->dropColumn('total_in');
            $table->dropColumn('total_out');
            $table->dropColumn('language');
            $table->dropColumn('phone');
            $table->dropColumn('phone_verified');
            $table->dropColumn('sms_token');
            $table->dropColumn('inviter_id');
            $table->dropColumn('role_id');
            $table->dropColumn('count_balance');
            $table->dropColumn('parent_id');
            $table->dropColumn('shop_id');
            $table->dropColumn('session');
            $table->dropColumn('is_blocked');
            $table->dropColumn('auth_token');
            $table->dropColumn('last_online');
            $table->dropColumn('sms_token_date');
            $table->dropColumn('last_daily_entry');
            $table->dropColumn('last_bid');
            $table->dropColumn('last_progress');
            $table->dropColumn('last_wheelfortune');
            $table->dropColumn('address');
        });
    }
};
