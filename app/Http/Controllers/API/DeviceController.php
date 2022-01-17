<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use App\Models\Order;
use Illuminate\Http\Request;
use GuzzleHttp;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Vinkla\Hashids\Facades\Hashids;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "platform" => "required|in:ios,android",
            "device_token" => "required",
            "onesignal_id" => "required"
        ]);
        if ($validator->passes()) {
            $device = Device::where('device_token',$request->input("device_token"))->first();
            if(!isset($device->id)){
                $device = new Device();
            }
            $production = (!is_null($request->input('production')) && $request->input('production') == 1);

            $device->platform = $request->input("platform");
            $device->device_token = $request->input("device_token");
            $device->device_model = $request->input("device_model");
            $device->os_version = $request->input("os_version");
            $device->user_id = $request->user()->id;
            /*if(!isset($device->onesignal_identifier))
            {
                $response = $this->createPlayer($device->platform, $device->device_token, $device->device_model, $device->os_version,
                    $production);
                // check if there is a duplicate for this
                $oldDevice = Device::where('onesignal_identifier',$response->id)->first();
                if(!is_null($oldDevice))
                {
                    $oldDevice->delete();
                }
                $device->onesignal_identifier = $response->id;
            }*/
            $device->onesignal_identifier = $request->input('onesignal_id');
            $device->status = 1;
            $device->save();

            return response()->make(["device_id" => $device->uid],201);
        }
        return response()->json(['errors' => $validator->errors()->all()],400);
    }
    public function destroy($id)
    {
        $id = Hashids::connection('device')->decode($id);

        $device = Device::find($id)->first();
        if(isset($device->id))
        {
            $device->status = 0;
            $device->save();
            return ["result" => true];
        }
        return ["result" => false];
    }
    public function update(Request $request,$id)
    {
        $id = Hashids::connection('device')->decode($id);
        $validator = Validator::make($request->all(), [
            "platform" => "required|in:ios,android",
            "device_token" => "required",
        ]);
        if ($validator->passes()) {

            $device = Device::find($id)->first();
            if(isset($device->id) && $device->platform == $request->input("platform"))
            {
                $device->device_token = $request->input("device_token");
                $response = $this->createPlayer($device->platform, $device->device_token, $device->device_model, $device->os_version);
                $device->onesignal_identifier = $response->id;
                $device->save();
                return response()->make(["device_id" => $device->uid],200);
            }
        }
        return response()->json(['errors' => $validator->errors()->all()],400);
    }



    private function createPlayer($platform,$device_token,$device_model, $device_os, $production = false) {
        $client = new GuzzleHttp\Client([
            'verify' => false
        ]);

        $config = 'services.onesignal';
        $rest_key = config($config)['rest_api_key'];
        $app_id = config($config)['app_id'];

        //'test_type' => 1
        $json = [
            'device_type' => ($platform == 'ios') ? 0 : 1, //implement more if needed
            'app_id' => $app_id,
            'identifier' => $device_token,
            'device_os' => $device_os,
            'device_model' => $device_model,

        ];
        if(!$production)
        {
            $json['test_type'] = 2;
        }
        $response = $client->post('https://onesignal.com/api/v1/players',[
            'headers' => [
                'Authorization' => 'Basic '.$rest_key
            ],
            'json' => $json
        ]);
        return json_decode($response->getBody());
    }
}
