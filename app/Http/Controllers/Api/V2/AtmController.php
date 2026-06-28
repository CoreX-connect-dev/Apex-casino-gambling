<?php

namespace VanguardLTE\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use VanguardLTE\Http\Controllers\Controller;

class AtmController extends Controller
{
    public function index(Request $request)
    {
        $payload = $request->json()->all();
        $method = $payload['controller'] . ucwords($payload['action']);
        if(method_exists($this, $method)) {
            return $this->$method($request);
        }
        return response()->json(['success' => false, 'msg' => 'Method not found'], 404);
    }

    public function atmPing($request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'atm_id' => 'ide2WtBxo8sC7M6yF$#@ImBx',
                'atm_name' => 'Main Terminal',
                'atm_parent_id' => '5538',
                'atm_enabled' => '1',
            ]
        ]);
    }

    public function activateUser(Request $request) { return $this->notImplemented(); }
    public function checkBarcodeAsync(Request $request) { return $this->notImplemented(); }
    public function saveBarcodeAsync(Request $request) { return $this->notImplemented(); }
    public function PendingCashIN(Request $request) { return $this->notImplemented(); }
    public function CashINAsync(Request $request) { return $this->notImplemented(); }
    public function forgotPass(Request $request) { return $this->notImplemented(); }
    public function resetPass(Request $request) { return $this->notImplemented(); }
    public function checkMagCardAsync(Request $request) { return $this->notImplemented(); }
    public function checkForPanic(Request $request) { return $this->notImplemented(); }
    public function createUser(Request $request) { return $this->notImplemented(); }
    public function updateRecServer(Request $request) { return $this->notImplemented(); }
    public function checkServerCreditsAsync(Request $request) { return $this->notImplemented(); }
    public function createUserAsync(Request $request) { return $this->notImplemented(); }
    public function createUpdateCode(Request $request) { return $this->notImplemented(); }
    public function SaveSettings(Request $request) { return $this->notImplemented(); }
    public function checkSignInAsync(Request $request) { return $this->notImplemented(); }
    public function checkVoucherAsync(Request $request) { return $this->notImplemented(); }
    public function createWithdrawCodeAsync(Request $request) { return $this->notImplemented(); }
    public function CashOUTAsync(Request $request) { return $this->notImplemented(); }

    private function notImplemented()
    {
        return response()->json(['success' => false, 'msg' => 'Endpoint under construction for demo'], 501);
    }
}
