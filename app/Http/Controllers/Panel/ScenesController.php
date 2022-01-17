<?php

namespace App\Http\Controllers\Panel;

use App\Models\Scene;
use App\Models\Seat;
use App\Models\SeatPlan;
use App\Models\SeatRow;
use App\Models\SeatZone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ScenesController extends Controller
{
    public function newScene()
    {
        return view('panel.newscene', ['scene' => null]);
    }
    public function index()
    {
        return view('panel.sceneslist', ['scenes' => Scene::whereSourceId(1)->get()]);
    }
    public function edit($id)
    {
        $scene = Scene::findOrFail($id);
        $colors = [];
        foreach ($scene->zones as $zone)
        {
            array_push($colors, substr(str_shuffle('ABCDEF0123456789'), 0, 6));
        }

        //return $plan_image;
        return view('panel.newscene', ['scene' => $scene, 'colors' =>$colors]);
    }
    public function delete($id)
    {

        $scene = Scene::find($id);

        if($scene->showtimes()->count() == 0)
        {
//            return $scene->zones()->delete();
//            return $scene->showtimes()->get();
             Seat::whereIn('zone_id',$scene->zones()->select('id')->get()->values())->delete();
             SeatRow::whereIn('zone_id',$scene->zones()->select('id')->get()->values())->delete();
//             return 1;
            $scene->zones()->delete();
            $scene->plans()->delete();




            $scene->delete();
        }

        return redirect()->route('scenes/list');
    }
    public function save(Request $request)
    {

        $data = $request->input('data');


        $scene = new Scene([
            'name' => $data['scene']['sceneName'],
            'address' => $data['scene']['sceneAddress'],
            'city' => $data['scene']['sceneCity'],
            'phone' => $data['scene']['scenePhone'],

        ]);
        $scene->location = [doubleval($data['scene']['scenelat']), doubleval($data['scene']['scenelng'])];
        $scene->save();
        $planImage = base64_decode(substr($data['scene']['scenePhoto'], strpos($data['scene']['scenePhoto'], ",")+1));
        $planImage_url = "images/scenes/plan-".time().mt_rand(10000,99999).".jpg";
        Storage::put("public/".$planImage_url, $planImage, 'public');
        $image_url = asset("/storage/".$planImage_url);

        $seatPlan = SeatPlan::create([
            'title' => 'Scene',
            'image_url' => $image_url,
            'scene_id' => $scene->id
        ]);


        foreach ($data['zones'] as $zone)
        {

            $theZone = SeatZone::create([
                'name' => $zone['title'],
                'x' => $zone['x'],
                'y' => $zone['y'],
                'scene_id' => $scene->id,
                'plan_id' => $seatPlan->id
            ]);

            foreach ($zone['rows'] as $row)
            {
                $theRow = SeatRow::create([
                    'row' => $row['title'],
                    'zone_id' => $theZone->id
                ]);
                $seats = $row['seats'];
                $space_to_left = 0.0;

                while (count($seats) > 0)
                {
                    $seat = array_shift($seats);
                    if(is_null($seat))
                    {
                        $space_to_left += 0.5;
                        //return response()->json(['result' => false,'message' => $space_to_left, 'data' => $request->all()],201);
                    }
                    else
                        {
                            $seat = new Seat([
                                'row_id' => $theRow->id,
                                'column' => $seat,
                                'zone_id' => $theZone->id,
                                'space_to_left' => $space_to_left,
                                'space_to_right' => 0
                            ]);
                            $seat->save();
                            $space_to_left = 0.0;
                    }
                }
            }
        }
        $scene->save();
        $scene->calculateSeatsCount();
        $scene->save();
        return response()->json(['result' => true,'message' => ''],201);
    }
}
