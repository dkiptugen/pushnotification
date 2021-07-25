<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    private $api;
    public function __construct()
    {
        $this->api = 'https://vas.standardmedia.co.ke/api/';
    }

    public function getLoginPage()
    {
        if(auth()->check())
        {
            $url = url()->previous();

            if(strpos($url,'/login') !== false)
                $url = url('/');

            return redirect($url);
        }
        $page = "auth";

        return view('auth.login', compact('page'));
    }

    public function getRegisterPage()
    {
        if(auth()->check())
        {
            $url = url()->previous();

            if(strpos($url,'/register') !== false)
                $url = url('/');

            return redirect($url);
        }
        $page = "auth";

        return view('register',compact('page'));
    }

    public function getResetPage()
    {
        if(auth()->check())
        {
            $url = url()->previous();

            if(strpos($url,'/reset') !== false)
                $url = url('/');

            return redirect($url);
        }
        $page = "auth";

        return view('reset',compact('page'));
    }

    public function login(Request $request)
    {
        
        $username = $request->email;
        $password = $request->password;
        $url = $request->url;

        $user =  new User();

        $params = ["body"=>json_encode(['username'=> $username, 'password'=>$password,"app_id"=> 17,"app_secret"=>"pFvwrdA3ycw6VKq3"])];
        $response = null;
        $client = new Client(['headers' => [ 'Content-Type' => 'application/json' ],'verify'=> base_path('/cacert.pem'),'http_errors'=>false]);
        
        try {

            $response = $client->request('POST', $this->api . 'auth', $params);

        }catch (Exception $e)
        {
            //dd("Exception has been caught", $e);
        }

        $headers = $response->getHeaders();
        $body = $response->getBody()->getContents();
        $objbody = json_decode($body);

        if(property_exists($objbody ,'message'))
        {
            Session::flash('error', $objbody->message);
            return redirect()->back();
        }

        $user->id = $objbody->id;
        $user->email = $objbody->email;
        $user->name = $objbody->name;

        $existing = $user->where('email',$user->email)->first();

        
        if($existing != null){
            
            Auth::setUser($user);
            Auth::login($user);

            $url = url('/');

            $request->session()->flash('loginnotify', true);

            if($existing->id != $objbody->id){
                //update the existing user
                $existing->id = $objbody->id;
                $existing->save();
            }
            return redirect($url);
        } else {
            Session::flash('error', "User not found. Please contact the administrator");
            return redirect()->back();
        }
    }

    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $phone = $request->phone;
        $url = $request->url;

        $user =  new User();

        $params = ["body"=>json_encode(['name'=> $name,'email'=> $email ,'password'=>$password,'password_confirmation'=>$password_confirmation,"app_id"=> 17,"app_secret"=>"pFvwrdA3ycw6VKq3"])];
        $response = null;
        $client = new Client(['headers' => [ 'Content-Type' => 'application/json' ],'verify'=> base_path('/cacert.pem'),'http_errors'=>false]);
        try {

            $response = $client->request('POST', $this->api . 'register', $params);

        }catch (Exception $e)
        {

        }

        $headers = $response->getHeaders();
        $body = $response->getBody()->getContents();
        $objbody = json_decode($body);


        if(property_exists($objbody ,'message') && ( (int) $response->getStatusCode()) > 250)
        {
            Session::flash('error', $objbody->message);
            return redirect()->back();
        }

        $user->id = $objbody->id;
        $user->email = $objbody->email;
        $user->name = $objbody->name;
        $user->phone = $phone;



        $existing = $user->find($objbody->id);

        if(is_null($existing))
        {
            $user->save();
            $this->login($request);
        }
        
        $url = url('/');
        return redirect($url);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $redirect_url = $request->url;

        $url = \url('/');

        $params = ["body"=>json_encode(['email'=> $email, 'redirect_url'=> $url ,"app_id"=> 17,"app_secret"=>"pFvwrdA3ycw6VKq3" ])];

        //return $params;
        $response = null;
        $client = new Client(['headers' => [ 'Content-Type' => 'application/json' ],'verify'=> base_path('/cacert.pem'),'http_errors'=>false]);
        try {

            $response = $client->request('POST', $this->api . 'email/password', $params);

        }catch (Exception $e)
        {

        }

        $headers = $response->getHeaders();
        $body = $response->getBody()->getContents();
        $objbody = json_decode($body);

        if(property_exists($objbody ,'message'))
        {
            $request->session()->flash('resetmsg', $objbody->message);
            $request->session()->flash('artresetmsg', $objbody->message);

            return redirect($redirect_url);
        }

        return redirect('/');
    }

    public function logout()
    {
        Session::forget('expiry_date');
        Auth::logout();

        return redirect()->route("login");
    }
}
