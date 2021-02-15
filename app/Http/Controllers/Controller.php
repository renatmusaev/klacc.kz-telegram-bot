<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Classroom;
use App\Models\LessonPayment;
use App\Models\PagePayment;
use App\Models\VideoPayment;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Price
    protected $price_1_pages = 2000;
    protected $price_2_pages = 4000;
    protected $price_3_pages = 6000;
    protected $price_video   = 2000;
    protected $price_lessosn = 2000;

    //Секретный ключ интернет-магазина
    protected $walletone_key = "51744c6d5932413076324d7b4336696a5c38343868634c74696778";

    // Отправка SMS
    protected function sendSMS($phone, $message)
    {
        $client = new Client(['verify' => false]);
        
        try {
            $client->request('POST', config('services.smsc.link'), [
                'form_params' => [
                    'login' => config('services.smsc.login'),
                    'psw' => config('services.smsc.password'),
                    'phones' => "+7".$phone,
                    'mes' => $message
                ]
            ]);
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }
    }

    // Оплата за ГДЗ
    protected function payPerPage($uid, $cid, $amount, $code)
    {
        // Пытаемся получить дыннае о действующей подписки
        $subscription = PagePayment::where([
            ['user_id', $uid],
            ['classroom_id', $cid],
            ['end_date', '>', Carbon::now()->format('Y-m-d')]
        ])->orderBy('id', 'desc')->first();

        // Если подписка еще не закончена
        if ($subscription && isset($subscription->end_date)) {
            $carbon = new Carbon($subscription->end_date);
            if ($amount == $this->price_1_pages) {
                $date = $carbon->addMonth();
            } elseif ($amount == $this->price_2_pages) {
                $date = $carbon->addMonths(3);
            } elseif ($amount == $this->price_3_pages) {
                $date = $carbon->addMonths(6);
            } else {
                return false;
            }
        } else if ($amount == $this->price_1_pages) {
            $date = Carbon::now()->addMonth();
        } elseif ($amount == $this->price_2_pages) {
            $date = Carbon::now()->addMonths(3);
        } elseif ($amount == $this->price_3_pages) {
            $date = Carbon::now()->addMonths(6);
        } else {
            return false;
        }

        $pay = new PagePayment();
        $pay->user_id = $uid;
        $pay->classroom_id = $cid;
        $pay->end_date = $date;
        $pay->vendor_code = $code;
        $pay->status = 1;
        $pay->save();
    }

    // Оплата за видео решения
    protected function payPerVideo($uid, $cid, $amount, $code)
    {
        // Пытаемся получить дыннае о действующей подписки
        $subscription = VideoPayment::where([
            ['user_id', $uid],
            ['book_id', $cid],
            ['end_date', '>', Carbon::now()->format('Y-m-d')]
        ])->orderBy('id', 'desc')->first();

        // Если подписка еще не закончена
        if ($subscription && isset($subscription->end_date)) {
            $carbon = new Carbon($subscription->end_date);
            if ($amount == $this->price_video) {
                $date = $carbon->addMonth();
            } else {
                return false;
            }
        } else if ($amount == $this->price_video) {
            $date = Carbon::now()->addMonth();
        } else {
            return false;
        }

        $pay = new VideoPayment();
        $pay->user_id = $uid;
        $pay->book_id = $cid;
        $pay->end_date = $date;
        $pay->vendor_code = $code;
        $pay->status = 1;
        $pay->save();
    }

    // Оплата за видеоуроки
    protected function payPerLessosn($uid, $cid, $amount, $code)
    {
        // Пытаемся получить дыннае о действующей подписки
        $subscription = LessonPayment::where([
            ['user_id', $uid],
            ['book_id', $cid],
            ['end_date', '>', Carbon::now()->format('Y-m-d')]
        ])->orderBy('id', 'desc')->first();

        // Если подписка еще не закончена
        if ($subscription && isset($subscription->end_date)) {
            $carbon = new Carbon($subscription->end_date);
            if ($amount == $this->price_lessosn) {
                $date = $carbon->addMonth();
            } else {
                return false;
            }
        } else if ($amount == $this->price_video) {
            $date = Carbon::now()->addMonth();
        } else {
            return false;
        }

        $pay = new LessonPayment();
        $pay->user_id = $uid;
        $pay->book_id = $cid;
        $pay->end_date = $date;
        $pay->vendor_code = $code;
        $pay->status = 1;
        $pay->save();
    }
}
