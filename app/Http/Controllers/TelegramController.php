<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller{
    
    public function send( $message ){
        return $this->sendMessage(494963311, $message, ENV('TELEGRAM_TOKEN'));
    }

    private function sendMessage($chatID, $message, $token) {
    
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($message);
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
