<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoucherCodeController extends Controller
{
    public function index(Request $request)
    {
        $codes = $request->user()->voucherCodes()->get();
        return response()->json($codes);
    }

    public function generate(Request $request)
    {
        $user = $request->user();

        if ($user->voucherCodes()->count() >= 10) {
            return response()->json(['error' => 'You cannot generate more than 10 codes!'], 400);
        }

        $voucherCode = VoucherCode::generate($user);

        return response()->json(['code' => $voucherCode->code], 201);
    }

    public function destroy($id)
    {
        $voucherCode = VoucherCode::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $voucherCode->delete();

        return response()->json(['message' => 'Voucher code deleted'], 200);
    }
}
