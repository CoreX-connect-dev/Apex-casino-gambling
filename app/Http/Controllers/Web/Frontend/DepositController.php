<?php
namespace VanguardLTE\Http\Controllers\Web\Frontend {
    include_once(base_path().'/app/ShopCore.php');
    include_once(base_path().'/app/ShopGame.php');
    class DepositController extends \VanguardLTE\Http\Controllers\Controller {
        public function __construct() { $this->middleware('auth'); }
        public function create(\Illuminate\Http\Request $request) {
            $request->validate(['system'=>'required|in:interkassa,coinbase,btcpayserver','credit_id'=>'nullable|integer','sum'=>'nullable|numeric|min:1']);
            $user = auth()->user(); $shop_id = $user->shop_id; $system = $request->system;
            $excl = \VanguardLTE\SelfExclusion::where('user_id',$user->id)->where(function($q){$q->whereNull('ends_at')->orWhere('ends_at','>',now());})->first();
            if ($excl) return response()->json(['error'=>__('app.account_excluded')],403);
            $sum = 0; $credit = null;
            if ($request->credit_id) { $credit = \VanguardLTE\Credit::find($request->credit_id); $sum = $credit ? floatval($credit->price) : 0; }
            elseif ($request->sum) { $sum = floatval($request->sum); }
            if ($sum <= 0) return response()->json(['error'=>__('app.wrong_sum')],422);
            $depLimit = \VanguardLTE\DepositLimit::where('user_id',$user->id)->first();
            if ($depLimit) { $check = $depLimit->canDeposit($sum); if (!$check['allowed']) return response()->json(['error'=>__('app.'.$check['reason'])],422); }
            $payment = \VanguardLTE\Payment::create(['user_id'=>$user->id,'sum'=>$sum,'currency'=>$user->shop?$user->shop->currency:'USD','credit_id'=>$credit?$credit->id:null,'status'=>0,'system'=>$system,'shop_id'=>$shop_id]);
            if ($system==='interkassa') return $this->interkassa($payment,$shop_id);
            if ($system==='coinbase')   return $this->coinbase($payment,$shop_id);
            if ($system==='btcpayserver') return $this->btcpay($payment,$shop_id);
            return response()->json(['error'=>'Payment system not found'],404);
        }
        protected function interkassa($payment,$shop_id) {
            $sid = \VanguardLTE\Lib\Setting::get_value('interkassa','shop_id',$shop_id);
            $key = \VanguardLTE\Lib\Setting::get_value('interkassa','token',$shop_id);
            if (!$sid||!$key) { $payment->delete(); return response()->json(['error'=>__('app.payment_system_not_configured')],503); }
            $form = ['ik_co_id'=>$sid,'ik_pm_no'=>$payment->id,'ik_am'=>number_format($payment->sum,2,'.',''),'ik_cur'=>$payment->currency,'ik_desc'=>'Deposit #'.$payment->id,'ik_ia'=>route('payment.interkassa.callback'),'ik_suc_u'=>route('payment.interkassa.success'),'ik_fal_u'=>route('payment.interkassa.fail')];
            $sign = $form; ksort($sign,SORT_STRING); array_push($sign,$key); $form['ik_sign'] = base64_encode(md5(implode(':',$sign),true));
            return response()->json(['status'=>'redirect','method'=>'POST','url'=>'https://sci.interkassa.com/','fields'=>$form]);
        }
        protected function coinbase($payment,$shop_id) {
            $api = \VanguardLTE\Lib\Setting::get_value('coinbase','api_key',$shop_id);
            if (!$api) { $payment->delete(); return response()->json(['error'=>__('app.payment_system_not_configured')],503); }
            $resp = \Illuminate\Support\Facades\Http::withHeaders(['X-CC-Api-Key'=>$api,'X-CC-Version'=>'2018-03-22'])->post('https://api.commerce.coinbase.com/charges',['name'=>'Deposit','description'=>'Casino deposit #'.$payment->id,'pricing_type'=>'fixed_price','local_price'=>['amount'=>(string)$payment->sum,'currency'=>$payment->currency],'redirect_url'=>route('payment.coinbase.success'),'cancel_url'=>route('payment.coinbase.fail')]);
            if (!$resp->successful()||!isset($resp['data']['hosted_url'])) { $payment->delete(); return response()->json(['error'=>__('app.payment_create_error')],500); }
            return response()->json(['status'=>'redirect','method'=>'GET','url'=>$resp['data']['hosted_url']]);
        }
        protected function btcpay($payment,$shop_id) {
            $server = rtrim(\VanguardLTE\Lib\Setting::get_value('btcpayserver','server',$shop_id),'/');
            $storeId = \VanguardLTE\Lib\Setting::get_value('btcpayserver','store_id',$shop_id);
            $token = \VanguardLTE\Lib\Setting::get_value('btcpayserver','api_token',$shop_id);
            if (!$server||!$storeId||!$token) { $payment->delete(); return response()->json(['error'=>__('app.payment_system_not_configured')],503); }
            $resp = \Illuminate\Support\Facades\Http::withHeaders(['Authorization'=>'token '.$token])->post("{$server}/api/v1/stores/{$storeId}/invoices",['amount'=>(string)$payment->sum,'currency'=>$payment->currency,'orderId'=>(string)$payment->id,'redirectURL'=>route('payment.btcpayserver.redirect'),'notificationURL'=>route('payment.btcpayserver.callback')]);
            if (!$resp->successful()||!isset($resp['checkoutLink'])) { $payment->delete(); return response()->json(['error'=>__('app.payment_create_error')],500); }
            return response()->json(['status'=>'redirect','method'=>'GET','url'=>$resp['checkoutLink']]);
        }
    }
}
