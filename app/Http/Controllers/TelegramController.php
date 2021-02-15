<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    private $title_kaz = "🇰🇿 Телеграмм ботқа қош келдіңіз!";
    private $title_rus = "🇷🇺 Вас приветствует телеграмм бот!";
    private $output = null;
    private $image = null;
    private $buttons = null;

    //
    public function index() {

        $bot = Telegram::getWebHookUpdates();
        if (!$bot->isEmpty()) {
            $chat_id = $bot['message']['chat']['id'];
            $text = $bot['message']['text'];

            // START
            if ($text == '/start') {
                $this->output  = $this->title_kaz."\r\n".$this->title_rus;
                $this->output .= "\r\n\r\n";
                $this->output .= "Өзіңізге ыңғайлы қарым-қатынас тілін таңдаңыз!\r\n";
                $this->output .= "Выберите удобный для вас язык общения!";

                // $language = Language::get();

                // foreach ($language as $key => $value) {
                //     $buttons[] = Keyboard::button(['text' => $value->name]);
                // }

                // $this->buttons = [$buttons];

                $btn1 = Keyboard::button(['text' => 'Қазақша']);
				$btn2 = Keyboard::button(['text' => 'На русском']);
                
                $this->buttons = [
                    [$btn1, $btn2]
                ];

                $keyboard = Keyboard::make([
                    'keyboard' => $this->buttons,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);

                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $this->output,
                    'reply_markup' => $keyboard
                ]);
            }
        }
    }
}
