<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Currency;

class GetdataController extends Controller
{
    
    public $data;

    public function getDataFromApi(){
        //$rates = $this->call();
        //print_r($rates);

        $url = "https://freecurrencyapi.net/api/v2/latest?apikey=11a3e5c0-9e1a-11ec-96e0-a5dd2ea87e04&base_currency=RUB";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        if(curl_exec($ch) === false){
            echo 'Ошибка curl: ' . curl_error($ch);
        }
        
        $rates = json_decode($response);
        print_r($rates);

        echo '<pre>';
            echo $rates->query->timestamp;
            echo '<br/>';
            echo $usd = $rates->data->USD;
            echo '<br/>';
            echo $eur = $rates->data->EUR;
        echo '</pre>';

        //Currency::create(['currency_code'=>'USD', 'value'=>$rates->data->USD * 10000, 'date'=> Carbon::parse($rates->query->timestamp)->setTimezone('UTC')]);
        //Currency::create(['currency_code'=>'EUR', 'value'=>$rates->data->EUR * 10000, 'date'=> Carbon::parse($rates->query->timestamp)->setTimezone('UTC')]);


    }

    private function call(){
        $url = "https://freecurrencyapi.net/api/v2/latest?apikey=11a3e5c0-9e1a-11ec-96e0-a5dd2ea87e04&base_currency=USD";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function setData(){
        $data = Currency::orderBy('id')->whereDate('created_at', '>=', '01-01-2020')->get();

        $date = $data->where('currency_code', 'USD')->pluck('date')->toArray();
        $values[] = ['currency_code' => 'USD', 'value' => $data->where('currency_code', 'USD')->pluck('value')->toArray()];
        $values[] = ['currency_code' => 'EUR', 'value' => $data->where('currency_code', 'EUR')->pluck('value')->toArray()];

        $this->data = [ 'data' => [
            'date' => $date,
            'values' => $values
            ]
        ];
    }
    
    public function getData(){
        $this->setData();
        return view('welcome', ['rates' => $this->data]);
    }

}