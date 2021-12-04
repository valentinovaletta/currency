<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class GetdataController extends Controller
{
    
    public $data;

    public function GetdataFromApi(){

        $rates = json_decode(file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'));
        return view('welcome',['rates' => $rates->Valute->USD->Value]);

    }

    public function Getdata(){
        return $this->data;
    }

}
