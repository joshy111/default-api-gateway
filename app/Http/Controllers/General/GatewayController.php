<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use Illuminate\Support\Facades\Http;
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
        $token = $request->token;
        // $token = '$2y$10$V9SLEafi3QeSaC9dpiDeo.njdM805jVuVjMdCQzM023GoR2J7ztGO';

        // Incase payload is being sent || For POST requests ** Be sure to change requests to data in all API's 
        // i.e from $request->query to $request->data->query
        $data = $request->data;

        $gateway = Gateway::select(['API_NAME', 'API_URL', 'API_METHOD', 'API_TOKEN'])->where('API_NAME', $api_name)->first();

        if(!$gateway){
            return;
        }

        // return $gateway;

        # Validate Token
        if(!$token == $gateway->API_TOKEN){
            return;
        }

        
        // # Make Call to API
        $result = $this->forward($gateway->API_URL, $gateway->API_METHOD, $data);

        return $result;

    }

    protected function forward($api_url, $api_method, $data){

        $response = Http::withOptions([
            'verify' => false
        ])->$api_method($api_url, [
            'data' => $data,
        ]);

        return $response->getBody();
    }

    
}
