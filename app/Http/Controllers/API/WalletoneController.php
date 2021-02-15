<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletoneController extends Controller
{
    // Формирование платежной формы
    public function fpf(Request $request)
    {
        if (auth()->guard('api')->user() && $request->has('cid') && $request->has('amount') && $request->has('type')) {
            $user   = auth()->guard('api')->user();
            $amount = $request->amount;
            $cid    = $request->cid;
            $code   = rand(10000, 99999) . $user->id;
            $type   = $request->type;
            
            // Добавление полей формы в ассоциативный массив
            $fields["WMI_MERCHANT_ID"]      = "192944545189";
            $fields["WMI_PAYMENT_AMOUNT"]   = $amount;
            $fields["WMI_CURRENCY_ID"]      = "398";
            $fields["WMI_AUTO_LOCATION"]    = 1;
            $fields["WMI_PAYMENT_NO"]       = $code;
            $fields["WMI_DESCRIPTION"]      = "BASE64:".base64_encode(''.$code);
            $fields["WMI_EXPIRED_DATE"]     = date('Y-m-d', strtotime('+10 day'))."T23:59:59";
            $fields["WMI_SUCCESS_URL"]      = "https://klacc.kz/payment/success";
            $fields["WMI_FAIL_URL"]         = "https://klacc.kz/payment/fail";
            $fields["UID"]                  = (int) $user->id;
            $fields["CID"]                  = (int) $cid;
            $fields["TID"]                  = (int) $type;

            //Сортировка значений внутри полей
            foreach($fields as $name => $val) {
                if(is_array($val)) {
                    usort($val, "strcasecmp");
                    $fields[$name] = $val;
                }
            }

            uksort($fields, "strcasecmp");
            $fieldValues = "";

            foreach($fields as $value) {
                if(is_array($value)) {
                    foreach($value as $v) {
                        $v = iconv("utf-8", "windows-1251", $v);
                        $fieldValues .= $v;
                    }
                } else {
                    $value = iconv("utf-8", "windows-1251", $value);
                    $fieldValues .= $value;
                }
            }
            $signature = base64_encode(pack("H*", md5($fieldValues . $this->walletone_key)));
            $fields["WMI_SIGNATURE"] = $signature;
            return response()->json($fields);
        }
        return response()->json('Error');
    }
}
