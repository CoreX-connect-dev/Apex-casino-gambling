<?php
namespace VanguardLTE\Http\Controllers\Web\Frontend {
    use Illuminate\Http\Request; use Illuminate\Support\Facades\Storage;
    class KycController extends \VanguardLTE\Http\Controllers\Controller {
        public function __construct() { $this->middleware('auth'); }
        public function upload(Request $request) {
            $request->validate(['type'=>'required|in:id_front,id_back,selfie,proof_address','document'=>'required|file|mimes:jpeg,jpg,png,pdf|max:5120']);
            $user = auth()->user(); $type = $request->type;
            $existing = \VanguardLTE\KycDocument::where(['user_id'=>$user->id,'type'=>$type])->first();
            if ($existing && $existing->status !== 'rejected') return response()->json(['error'=>__('app.document_already_submitted')],422);
            $path = $request->file('document')->store('kyc/'.$user->id,'local');
            if ($existing) { Storage::disk('local')->delete($existing->file_path); $existing->update(['file_path'=>$path,'status'=>'pending','reviewed_by'=>null,'reviewed_at'=>null,'rejection_reason'=>null]); }
            else { \VanguardLTE\KycDocument::create(['user_id'=>$user->id,'type'=>$type,'file_path'=>$path,'status'=>'pending','shop_id'=>$user->shop_id]); }
            return response()->json(['success'=>__('app.document_uploaded_successfully')]);
        }
    }
}
