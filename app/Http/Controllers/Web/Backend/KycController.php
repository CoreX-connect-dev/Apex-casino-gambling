<?php
namespace VanguardLTE\Http\Controllers\Web\Backend {
    use Illuminate\Http\Request; use Illuminate\Support\Facades\Storage;
    class KycController extends \VanguardLTE\Http\Controllers\Controller {
        public function __construct() { $this->middleware(['auth','session.database']); }
        public function index(Request $request) {
            $status = $request->get('status','pending');
            $docs = \VanguardLTE\KycDocument::with('user')->when($status!=='all',fn($q)=>$q->where('status',$status))->orderBy('id','DESC')->paginate(30);
            return view('backend.kyc.index',compact('docs','status'));
        }
        public function show(\VanguardLTE\KycDocument $doc) { $doc->load('user'); return view('backend.kyc.show',compact('doc')); }
        public function user(\VanguardLTE\User $user) { $docs = \VanguardLTE\KycDocument::where('user_id',$user->id)->get(); return view('backend.kyc.user',compact('user','docs')); }
        public function approve(Request $request, \VanguardLTE\KycDocument $doc) {
            $doc->update(['status'=>'approved','reviewed_by'=>auth()->id(),'reviewed_at'=>now(),'rejection_reason'=>null]);
            try { \VanguardLTE\Message::create(['user_id'=>$doc->user_id,'type'=>'kyc_approved','value'=>$doc->type,'status'=>0,'shop_id'=>$doc->shop_id]); } catch(\Exception $e) {}
            return $request->wantsJson() ? response()->json(['success'=>true]) : redirect()->route('backend.kyc.list')->with('success','Document approved.');
        }
        public function reject(Request $request, \VanguardLTE\KycDocument $doc) {
            $request->validate(['reason'=>'required|string|max:500']);
            $doc->update(['status'=>'rejected','reviewed_by'=>auth()->id(),'reviewed_at'=>now(),'rejection_reason'=>$request->reason]);
            try { \VanguardLTE\Message::create(['user_id'=>$doc->user_id,'type'=>'kyc_rejected','value'=>$request->reason,'status'=>0,'shop_id'=>$doc->shop_id]); } catch(\Exception $e) {}
            return $request->wantsJson() ? response()->json(['success'=>true]) : redirect()->route('backend.kyc.list')->with('success','Document rejected.');
        }
    }
}
