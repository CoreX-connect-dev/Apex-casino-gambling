<?php
namespace VanguardLTE\Http\Controllers\Web\Frontend\Responsible {
    use Illuminate\Http\Request; use Carbon\Carbon;
    class ResponsibleController extends \VanguardLTE\Http\Controllers\Controller {
        public function __construct() { $this->middleware('auth'); }
        public function exclude(Request $request) {
            $request->validate(['period'=>'required|in:1,7,30,180,365,permanent']);
            $user = auth()->user();
            \VanguardLTE\SelfExclusion::where('user_id',$user->id)->delete();
            $endsAt = $request->period==='permanent' ? null : Carbon::now()->addDays((int)$request->period);
            \VanguardLTE\SelfExclusion::create(['user_id'=>$user->id,'period'=>$request->period,'ends_at'=>$endsAt,'shop_id'=>$user->shop_id]);
            $user->update(['is_blocked'=>1]);
            auth()->logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
            return redirect('/')->with('success',__('app.self_exclusion_activated'));
        }
        public function limits(Request $request) {
            $request->validate(['daily_limit'=>'nullable|numeric|min:1','weekly_limit'=>'nullable|numeric|min:1','monthly_limit'=>'nullable|numeric|min:1']);
            $user = auth()->user(); $limit = \VanguardLTE\DepositLimit::firstOrNew(['user_id'=>$user->id]);
            $limit->daily_limit = $request->daily_limit ?: null; $limit->weekly_limit = $request->weekly_limit ?: null; $limit->monthly_limit = $request->monthly_limit ?: null;
            $limit->user_id = $user->id; $limit->save();
            return $request->wantsJson() ? response()->json(['success'=>__('app.limits_updated')]) : redirect()->back()->with('success',__('app.limits_updated'));
        }
        public function session(Request $request) {
            $request->validate(['session_limit'=>'nullable|integer|in:30,60,90,120,180,240']);
            $user = auth()->user(); $limit = \VanguardLTE\DepositLimit::firstOrNew(['user_id'=>$user->id]);
            $limit->user_id = $user->id; $limit->session_limit = $request->session_limit ?: null; $limit->save();
            return $request->wantsJson() ? response()->json(['success'=>__('app.session_limit_updated')]) : redirect()->back()->with('success',__('app.session_limit_updated'));
        }
        public function reality(Request $request) {
            $request->validate(['reality_check'=>'nullable|integer|in:15,30,60,120']);
            $user = auth()->user(); $limit = \VanguardLTE\DepositLimit::firstOrNew(['user_id'=>$user->id]);
            $limit->user_id = $user->id; $limit->reality_check = $request->reality_check ?: null; $limit->save();
            return $request->wantsJson() ? response()->json(['success'=>__('app.reality_check_updated')]) : redirect()->back()->with('success',__('app.reality_check_updated'));
        }
    }
}
