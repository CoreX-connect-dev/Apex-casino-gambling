<?php
namespace VanguardLTE {
    class SelfExclusion extends \Illuminate\Database\Eloquent\Model {
        protected $table = 'self_exclusions';
        protected $fillable = ['user_id','period','ends_at','shop_id'];
        protected $dates = ['ends_at'];
        public function user() { return $this->belongsTo('VanguardLTE\User'); }
        public function isActive(): bool { return $this->ends_at === null || $this->ends_at->isFuture(); }
    }
}
