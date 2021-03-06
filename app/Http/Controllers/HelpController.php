<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

include_once __DIR__ . '/config.php';

class HelpController extends Controller
{

    public function home()
    {
        $alerts = DB::table('alerts')->get();
        return view('index')->with('alerts', $alerts);
    }

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

        $relief_camp = DB::table('camp')->get();
        $contact['camps'] = $relief_camp;

        return view('helpme')->with('contact', $contact);
    }

    public function distance($lat1, $lon1, $lat2, $lon2) 
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $distance = $miles*1.609344;

        return $distance;
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

            $min = 10000;
            $camps = DB::table('camp')->get();
            foreach($camps as $camp)
            {
                $clat = $camp->latitude;
                $clng = $camp->longitude;

                $dist = $this->distance($clat, $clng, $latitude, $longitude);
                if($dist<$min)
                {
                    $min = $dist;
                    $nearest = $camp;
                }
            }

            $messageCamp = "Nearby Relief Camp-";
            $messageCamp .=  $nearest->name . ',' . $nearest->address . ', Helpline-' . 
                $nearest->helpline;

            //Nearest camp
            DB::table('people_stuck')->insert(['name' => $name,'mobile' => $mobile,
                'address' => $address,
                'latitude' => $latitude,'longitude' => $longitude ]);

            if(strlen($messageCamp)<140)
                sendWay2SMS(SMS_NO, SMS_PASS, $mobile, $messageCamp);

            $radius = 1000;

            $gen = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=';
            $gen = $gen . $latitude . ',' . $longitude . '&radius=' . $radius;

            //Nearest hospitals
            $url = $gen . '&type=hospital' . '&key=' . PLACES_KEY;

            $response = file_get_contents($url);
            $hospitals = json_decode($response, true);

            if(count($hospitals['results']))
            {
                $messageHosp = 'Nearby Hospital-';
                $messageHosp .= $hospitals['results'][0]['name'] . ',' . $hospitals['results'][0]['vicinity'];

                if(strlen($messageHosp)<140)
                    sendWay2SMS (SMS_NO, SMS_PASS, $mobile, $messageHosp); 
            }

            //Nearest police stations
            $url = $gen . '&type=police' . '&key=' . PLACES_KEY;

            $response = file_get_contents($url);
            $police = json_decode($response, true);

            if(count($police['results']))
            {
                $messagePol = 'Nearby Police Station-';
                $messagePol .= $police['results'][0]['name'] . ',' . $police['results'][0]['vicinity'];

                if(strlen($messagePol)<140)
                    sendWay2SMS (SMS_NO, SMS_PASS, $mobile, $messagePol); 
            }

            $errors = "Important contact information has been provided to the number";
            return view('locate')->with('errors', $errors);
        }
        else
        {
            $errors = "Please enter the address in the given format!";
            return view('locate')->with('errors', $errors);
        }
    }

    public function details()
    {
        $name = Input::get('name');
        $mobile = Input::get('mobile');
        $no_of_people = Input::get('no_of_people');
        $message = Input::get('message');
        $latitude = Input::get('lat');
        $longitude = Input::get('lng');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
        $url = $url . $latitude . ',' . $longitude . '&key=' . GEOCODING_KEY;

        $response = file_get_contents($url);
        $response = json_decode($response, true); 

        $address = $response['results'][0]['address_components'][0]['long_name'] . ','
                    . $response['results'][0]['address_components'][1]['long_name'] . ','
                    . $response['results'][0]['address_components'][2]['long_name'] . ','
                    . $response['results'][0]['address_components'][3]['long_name'] . ','
                    . $response['results'][0]['address_components'][4]['long_name'];
           
        DB::table('people_stuck')->insert(['name' => $name,'mobile' => $mobile, 
            'persons' => $no_of_people, 'message' => $message, 'address' => $address, 'latitude' => $latitude,'longitude' => $longitude ]);

        $errors = "Information added successfully!";
        return redirect('/find');
    }

    public function location()
    {
        return view('locate');
    }

    public function weather()
    {
        $weather = "http://api.openweathermap.org/data/2.5/weather?q=";
        $fore = "http://api.openweathermap.org/data/2.5/forecast?q=";
        $next = "&units=metric&lang=de&mode=json&APPID=";
        $getWeather=array();

        if(!is_null(Input::get('city')))
        {
            $city = Input::get('city');

            $weather = $weather . $city .$next . WEATHER_KEY;
            $fore = $fore . $city . $next . WEATHER_KEY;

            $weather = str_replace(' ', '+', $weather);
            $fore = str_replace(' ', '+', $fore);

            $json_string=file_get_contents($weather);
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
            $json_string = file_get_contents($fore);
            $jsonData = json_decode($json_string, true);
            $forecast=array();
            $forecast=array();
            $counter=0;
            foreach ($jsonData['list'] AS $item) {
            $forecast[0]=$item['main']['temp'];
            $forecast[1]=$item['main']['temp_min'];
            $forecast[2]=$item['main']['temp_max'];
            $forecast[3]=$item['main']['humidity'];
            $forecast[4]=$item['weather'][0]['main'];
            $forecast[5]=$item['dt_txt'];
            $forecast_all[]=$forecast;
            $counter++;
            if($counter==4)
            break;
            }
            $getWeather[1]=$forecast_all;
            $getWeather['city'] = $city;

        }

        return view('weather')->with('getWeather',$getWeather);
    }

    public function find()
    {
        if(!is_null(Input::get('mobile')))
        {
            $mobile = Input::get('mobile');
            $people_stuck = DB::table('people_stuck')
            ->where('mobile', $mobile)->get();
        }
        else
            $people_stuck = DB::table('people_stuck')->get();
        return view('find')->with('people_stuck', $people_stuck);
    }

    public function submit()
    {
        $name = Input::get('name');
        $email = Input::get('email');
        $items = Input::get('item');

        DB::table('donation')->insert(['name' => $name, 'email' => $email,
            'item' => $items]);

        $data['name'] = $name;
        $data['items'] = $items;

        Mail::send('donation_email', ['data' => $data], function ($message) use ($email)
        {
            $message->to($email);
        });

        $errors = "We have recieved your donation request,check your email for details";
        return view('donate')->with('errors', $errors);
    }

    public function camps()
    {
        $camps = DB::table('camp')->get();
        return view('camps')->with('camps', $camps);
    }

    public function donate()
    {
        return view('donate');
    }

    public function fund()
    {
        $amt=Input::get('fund');
        return view('fund')->with('fund',$amt);
    }
}
