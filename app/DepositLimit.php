<?php
namespace VanguardLTE {
    class DepositLimit extends \Illuminate\Database\Eloquent\Model {
        protected $table = 'deposit_limits';
        protected $fillable = ['user_id','daily_limit','weekly_limit','monthly_limit','daily_spent','weekly_spent','monthly_spent','daily_reset_at','weekly_reset_at','monthly_reset_at','session_limit','reality_check'];
        protected $dates = ['daily_reset_at','weekly_reset_at','monthly_reset_at'];
        public function user() { return $this->belongsTo('VanguardLTE\User'); }
        public function canDeposit(float $amount): array {
            $this->resetIfNeeded();
            if ($this->daily_limit && ($this->daily_spent + $amount) > $this->daily_limit) return ['allowed'=>false,'reason'=>'daily_limit_reached'];
            if ($this->weekly_limit && ($this->weekly_spent + $amount) > $this->weekly_limit) return ['allowed'=>false,'reason'=>'weekly_limit_reached'];
            if ($this->monthly_limit && ($this->monthly_spent + $amount) > $this->monthly_limit) return ['allowed'=>false,'reason'=>'monthly_limit_reached'];
            return ['allowed'=>true];
        }
        public function recordDeposit(float $amount): void {
            $this->increment('daily_spent',$amount); $this->increment('weekly_spent',$amount); $this->increment('monthly_spent',$amount);
        }
        private function resetIfNeeded(): void {
            $now = \Carbon\Carbon::now();
            if (!$this->daily_reset_at || $now->diffInDays($this->daily_reset_at) >= 1) $this->update(['daily_spent'=>0,'daily_reset_at'=>$now]);
            if (!$this->weekly_reset_at || $now->diffInDays($this->weekly_reset_at) >= 7) $this->update(['weekly_spent'=>0,'weekly_reset_at'=>$now]);
            if (!$this->monthly_reset_at || $now->diffInDays($this->monthly_reset_at) >= 30) $this->update(['monthly_spent'=>0,'monthly_reset_at'=>$now]);
        }
    }
}
