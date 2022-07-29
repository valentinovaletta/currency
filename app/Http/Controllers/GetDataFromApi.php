<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Currency;
use App\Http\Controllers\TelegramController;

class GetDataFromApi extends Controller
{
    public function getData(){
        
        $message = new TelegramController;

        try{
            $data = $this->currencyapi();
            $rates = json_decode($data);

            $date = $rates->meta->last_updated_at;
            $usd = round ((1 / $rates->data->USD->value), 4) * 10000;
            $eur = round ((1 / $rates->data->EUR->value), 4) * 10000;

            $message->send( $date . " \n USD = " . $usd . " \n EUR = ". $eur );

        } catch( \Exception $e){
            $date = date('Y-m-d H:i:s');
            $usd = 0;
            $eur = 0;
            $message->send( 'There is an error while update data from API ' . $e->getMessage() );
            return false;
        }

        Currency::create(['currency_code'=>'USD', 'value'=>$usd, 'date'=> Carbon::parse($date)->setTimezone('UTC')]);
        Currency::create(['currency_code'=>'EUR', 'value'=>$eur, 'date'=> Carbon::parse($date)->setTimezone('UTC')]);

        return true;
    }

    private function currencyapi(){

        $url = "https://api.currencyapi.com/v3/latest?apikey=11a3e5c0-9e1a-11ec-96e0-a5dd2ea87e04&base_currency=RUB";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

}
