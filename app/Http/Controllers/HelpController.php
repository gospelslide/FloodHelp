<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

include_once __DIR__ . '/config.php';

class HelpController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $gen = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=';
        $latitude = Input::get('lat');
        $longitude = Input::get('lng');
        $radius = 1000;

        $gen = $gen . $latitude . ',' . $longitude . '&radius=' . $radius;

        //Nearest hospitals
        $url = $gen . '&type=hospital' . '&key=' . PLACES_KEY;

        $response = file_get_contents($url);
        $hospitals = json_decode($response, true);

        //Nearest police stations
        $url = $gen . '&type=police' . '&key=' . PLACES_KEY;

        $response = file_get_contents($url);
        $police = json_decode($response, true);

        //Nearest fire stations
        $url = $gen . '&type=fire_station' . '&key=' . PLACES_KEY;

        $response = file_get_contents($url);
        $fire_station = json_decode($response, true);

        //Nearest pharmacies
        $url = $gen . '&type=pharmacy' . '&key=' . PLACES_KEY;

        $response = file_get_contents($url);
        $pharmacy = json_decode($response, true);

        $contact['hospitals'] = $hospitals;
        $contact['police'] = $police;
        $contact['fire_station'] = $fire_station;
        $contact['pharmacy'] = $pharmacy;

        $contact['latitude'] = $latitude;
        $contact['longitude'] = $longitude;

        //Weather updates
        $getWeather=array();
        $json_string=file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&units=metric&lang=de&mode=json&APPID=9d10e5fc866fde56747f225d82050f55");
        $jsonData = json_decode($json_string, true);
        date_default_timezone_set("Asia/Calcutta");
        $forecast[0]=$jsonData['weather']['0']['main'];
        $forecast[1]=$jsonData['main']['temp'];
        $forecast[2]=$jsonData['main']['temp_min'];
        $forecast[3]=$jsonData['main']['temp_max'];
        $forecast[4]=$jsonData['main']['humidity'];
        $forecast[5]=date("Y/m/d")." ".date("H:i:s");
        $getWeather[0]=$forecast;
        //FORECAST
        $json_string = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?lat=18.975&lon=72.8258&units=metric&lang=de&mode=json&APPID=9d10e5fc866fde56747f225d82050f55");
        $jsonData = json_decode($json_string, true);
        $forecast=array();
        $forecast=array();
        $counter=0;
        foreach ($jsonData['list'] AS $item) {
        $forecast[0]=$item['main']['temp'];
        $forecast[1]=$item['main']['temp_min'];
        $forecast[2]=$item['main']['temp_max'];
        $forecast[3]=$item['main']['humidity'];
        if($item['rain']==null)
            $forecast[4]='-';
        else
            $forecast[4]=$item['rain']['3h'];
        $forecast[5]=$item['dt_txt'];
        $forecast_all[]=$forecast;
        $counter++;
        if($counter==3)
        break;
        }
        $getWeather[1]=$forecast_all;
        $contact['getWeather'] = $getWeather;

        return view('helpme')->with('contact', $contact);
    }

    public function message()
    {   
        include('way2sms-api.php');
        $name = Input::get('name');
        $mobile = Input::get('mobile');
        $address = Input::get('address');

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
        $url .= $address;
        $url = str_replace(' ', '+', $url);
        $url = $url . '&' . 'key=' . GEOCODING_KEY;

        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if(count($response['results']))
        {   
            $latitude = $response['results'][0]['geometry']['location']['lat'];
            $longitude = $response['results'][0]['geometry']['location']['lng'];
        }

        $radius = 1000;

        $gen = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=';
        $gen = $gen . $latitude . ',' . $longitude . '&radius=' . $radius;

        //Nearest hospitals
        $url = $gen . '&type=hospital' . '&key=' . PLACES_KEY;

        $response = file_get_contents($url);
        $hospitals = json_decode($response, true);

        //Nearest police stations
        $url = $gen . '&type=police' . '&key=' . PLACES_KEY;

        $response = file_get_contents($url);
        $police = json_decode($response, true);

        $message = 'Nearby Hospital-';
        $message .= $hospitals['results'][0]['name'] . ',' . $hospitals['results'][0]['vicinity'];
        if(strlen($message)<140)
            sendWay2SMS ( SMS_NO , SMS_PASS , $mobile , $message); 

        $message = 'Nearby Police Station-';
        $message .= $police['results'][0]['name'] . ',' . $police['results'][0]['vicinity'];

        if(strlen($message)<140)
            sendWay2SMS ( SMS_NO , SMS_PASS , $mobile , $message); 
    }

    public function details()
    {
        $name = Input::get('name');
        $mobile = Input::get('mobile');
        $no_of_people = Input::get('no_of_people');
        $message = Input::get('message');
        $latitude = Input::get('lat');
        $longitude = Input::get('lng');

        DB::table('people_stuck')->insert(['name' => $name,'mobile' => $mobile, 
            'persons' => $no_of_people, 'message' => $message, 'latitude' => $latitude,'longitude' => $longitude ]);

        return "Success!";
    }

    public function location()
    {
        return view('locate');
    }

    public function weather()
    {
        $getWeather=array();
        $json_string=file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=18.975&lon=72.8258&units=metric&lang=de&mode=json&APPID=9d10e5fc866fde56747f225d82050f55");
        $jsonData = json_decode($json_string, true);
        date_default_timezone_set("Asia/Calcutta");
        $forecast[0]=$jsonData['weather']['0']['main'];
        $forecast[1]=$jsonData['main']['temp'];
        $forecast[2]=$jsonData['main']['temp_min'];
        $forecast[3]=$jsonData['main']['temp_max'];
        $forecast[4]=$jsonData['main']['humidity'];
        $forecast[5]=date("Y/m/d")." ".date("H:i:s");
        $getWeather[0]=$forecast;
        //FORECAST
        $json_string = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?lat=18.975&lon=72.8258&units=metric&lang=de&mode=json&APPID=9d10e5fc866fde56747f225d82050f55");
        $jsonData = json_decode($json_string, true);
        $forecast=array();
        $forecast=array();
        $counter=0;
        foreach ($jsonData['list'] AS $item) {
        $forecast[0]=$item['main']['temp'];
        $forecast[1]=$item['main']['temp_min'];
        $forecast[2]=$item['main']['temp_max'];
        $forecast[3]=$item['main']['humidity'];
        $forecast[4]=$item['rain'];
        $forecast[5]=$item['dt_txt'];
        $forecast_all[]=$forecast;
        $counter++;
        if($counter==3)
        break;
        }
        $getWeather[1]=$forecast_all;
        return view('testing')->with('getWeather',$getWeather);
    }
}
