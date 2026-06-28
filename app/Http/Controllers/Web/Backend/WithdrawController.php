<?php
namespace VanguardLTE\Http\Controllers\Web\Backend {
    use Illuminate\Http\Request;
    class WithdrawController extends \VanguardLTE\Http\Controllers\Controller {
        public function __construct() { $this->middleware(['auth','session.database']); }
        public function index(Request $request) {
            $status = $request->get('status','0');
            $withdrawals = \VanguardLTE\Withdraw::with(['user','shop'])->when($status!=='all',fn($q)=>$q->where('status',$status))->orderBy('id','DESC')->paginate(30);
            return view('backend.withdrawals.index',compact('withdrawals','status'));
        }
        public function approve(Request $request, \VanguardLTE\Withdraw $withdraw) {
            if ($withdraw->status !== 0) return response()->json(['error'=>'Already processed'],422);
            $withdraw->update(['status'=>1]);
            try { \VanguardLTE\Statistic::create(['user_id'=>$withdraw->user_id,'payeer_id'=>auth()->id(),'system'=>'withdraw_approved','title'=>'WD','type'=>'out','sum'=>$withdraw->amount,'shop_id'=>$withdraw->shop_id,'created_at'=>now()]); } catch(\Exception $e) {}
            return $request->wantsJson() ? response()->json(['success'=>true]) : redirect()->back()->with('success','Withdrawal approved.');
        }
        public function reject(Request $request, \VanguardLTE\Withdraw $withdraw) {
            if ($withdraw->status !== 0) return response()->json(['error'=>'Already processed'],422);
            $withdraw->update(['status'=>2]);
            $user = $withdraw->user;
            if ($user) { $user->increment('balance',$withdraw->amount); try { \VanguardLTE\Message::create(['user_id'=>$user->id,'type'=>'withdraw_rejected','value'=>number_format($withdraw->amount,2).' '.$withdraw->currency,'status'=>0,'shop_id'=>$withdraw->shop_id]); } catch(\Exception $e) {} }
            return $request->wantsJson() ? response()->json(['success'=>true]) : redirect()->back()->with('success','Withdrawal rejected and balance refunded.');
        }
    }
}
