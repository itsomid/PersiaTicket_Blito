<?php

namespace App\Http\Controllers\Panel;

use App\Models\Promotion;
use App\Models\Show;
use App\Models\Showtime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PromotionsController extends Controller
{
    //
    public function index(Request $request)
    {

        if($request->user()->isAdmin())
            return view('panel.promotions',['promotions'=> Promotion::all()]);

        return abort(403);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "show_uid" => "size:10|string",
            "code" => "required|string|min:5|unique:promotions,code",
            "since_date" => "required",
            "until_date" => "required",
            "constant_discount" => "integer",
            "percent_discount" => "min:1|max:100"
        ]);
        if ($validator->passes()) {

            $user = $request->user();

            $promotion = new Promotion();
            $promotion->code = strtoupper($request->input('code'));
            if($request->has('show_uid'))
            {
                $show = Show::findByUID($request->input('show_uid'));
                $promotion->show_id = $show->id;
            }
            $promotion->constant_discount = $request->input('constant_discount');
            $promotion->showtime_id = Showtime::realId($request->input('showtime_uid'));
            $promotion->percent_discount = doubleval($request->input('percent_discount')/100);
            if($request->has('usage_count') && $request->input('usage_count') !== null)
            {
                $promotion->usage_count = $request->input('usage_count');
            }else{
                $promotion->usage_count = -1;
            }
            $promotion->since_date = \SeebBlade::carbonFromPersian($request->input('since_date'),'yyyy/MM/dd HH:mm',false,true);
            $promotion->until_date = \SeebBlade::carbonFromPersian($request->input('until_date'),'yyyy/MM/dd HH:mm',false,true);
            $promotion->created_by_user_id = $request->user()->id;
            $promotion->save();
            return response()->make(['result' => true],201,[]);
        }
        return response()->json(['result' => false, 'message' => implode(',', $validator->errors()->all())],200);
    }
    public function setStatus($promotion_id,$status, Request $request)
    {
        if (!$request->user()->isAdmin())
            return abort(403);
        $promotion = Promotion::find($promotion_id);
        $promotion->status = $status;
        $promotion->save();
    }
}
