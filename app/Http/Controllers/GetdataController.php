<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Currency;

class GetdataController extends Controller
{
    
    public $data;

    public function getDataFromApi(){
        $rates = json_decode(file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'));
        Currency::create(['currency_code'=>'USD', 'value'=>$rates->Valute->USD->Value * 10000, 'date'=> Carbon::parse($rates->Date)->setTimezone('UTC')]);
        Currency::create(['currency_code'=>'EUR', 'value'=>$rates->Valute->EUR->Value * 10000, 'date'=> Carbon::parse($rates->Date)->setTimezone('UTC')]);
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