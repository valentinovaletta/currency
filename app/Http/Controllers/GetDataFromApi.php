<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Currency;

class GetDataFromApi extends Controller
{
    public function __invoke()
    {
        $rates = json_decode(file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'));
        Currency::create(['currency_code'=>'USD', 'value'=>$rates->Valute->USD->Value * 10000, 'date'=> Carbon::parse($rates->Date)->setTimezone('UTC')]);
        Currency::create(['currency_code'=>'EUR', 'value'=>$rates->Valute->EUR->Value * 10000, 'date'=> Carbon::parse($rates->Date)->setTimezone('UTC')]);
    }
}
