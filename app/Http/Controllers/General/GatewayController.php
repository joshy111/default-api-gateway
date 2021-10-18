<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    public function index(Request $request){
        $this->validate($request, [
            'api_name' => 'required',
            'token' => 'required',
        ]);

        // Used to retrieve api url
        $api_name = $request->api_name; 

        // Used to validate Request
        // $token = $request->token;
        $token = '$2y$10$V9SLEafi3QeSaC9dpiDeo.njdM805jVuVjMdCQzM023GoR2J7ztGO';

        // Incase payload is being sent || For POST requests
        $data = $request->data;

        $gateway = Gateway::where('API_NAME', $api_name)->get();

        # Validate Token
        if(!$gateway->API_TOKEN == $token){
            return;
        }

        # Make Call to API
        $result = $this->forward($gateway->API_URL, $gateway->API_METHOD, $data);

        return $result;

    }

    protected function forward($api_url, $api_method, $data){
        $client = new \GuzzleHttp\Client();

        $response = $client->request("$api_method", $api_url, [$data]);

        return $response;
    }
}
