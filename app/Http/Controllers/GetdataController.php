<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\Models\Currency;

class GetdataController extends Controller
{

    public function getData(){

        $data = Currency::orderBy('id')->whereDate('created_at', '>=', Carbon::now()->subDays(7))->get();

        $date = $data->where('currency_code', 'USD')->pluck('date')->toArray();
        $values[] = ['currency_code' => 'USD', 'value' => $data->where('currency_code', 'USD')->pluck('value')->toArray()];
        $values[] = ['currency_code' => 'EUR', 'value' => $data->where('currency_code', 'EUR')->pluck('value')->toArray()];

        $rates = [ 'data' => [
            'date' => $date,
            'values' => $values
            ]
        ];

        return view('welcome', ['rates' => $rates]);
    }

}