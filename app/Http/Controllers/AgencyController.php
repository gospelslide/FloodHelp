<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
include_once __DIR__ . '/config.php';
class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check())
        {
            $donations = Db::table('donation')->get();
            return view('agency')->with('donations', $donations);
        }
        else
            return redirect('/login');
    }
    public function display()
    {
        return view('login');
    }
    public function validation()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $agency = DB::table('agency')->where('email',$email)->first();
        $errors = 'Invalid username or password!';
        if($agency)
        {
            if(!strcmp($agency->password,$password))
            {
                Auth::loginUsingId($agency->id);
                return redirect('/agency_home');
            }   
        }
        return redirect()->back()->withErrors($errors);
    }
    public function add()
    {
        if(Auth::check())
            return view('add_camp');
        else
            return redirect('/login');
    }
    public function addCamp()
    {
        $name = Input::get('name');
        $organizer = Input::get('organizer');
        $helplines = Input::get('mobile');
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
        DB::table('camp')->insert(['name' => $name, 'organizer' => $organizer,
            'helpline' => $helplines, 'address' => $address, 
            'latitude' => $latitude, 'longitude' => $longitude]);
        $errors = "Camp information successfully added";
        return view('add_camp')->with('errors', $errors);
    }
    public function alerts()
    {
        if(Auth::check())
        {
            if(count(Input::all()))
            {
                $message = Input::get('message');
                $created = Carbon::now();
                DB::table('alerts')->insert(['message' => $message,
                    'created_at' => $created]);
                $errors = "Alert successfully added.";
                return view('alerts')->with('errors', $errors);
            }
            return view('alerts');
        }
        else return redirect('/login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}