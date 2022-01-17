<?php

namespace App\Http\Controllers\API;

use App\Models\Promotion;
use App\Models\Show;
use App\Models\Showtime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PromotionsController extends Controller
{
    public function checkPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "promo_code" => "required|alpha_num",
            "show_uid" => "required|alpha_num",
            "price" => "required|numeric",
        ]);
        if ($validator->passes()) {
             $show_uid = $request->get('show_uid');

            $price = $request->get('price');
            $code = $request->get('promo_code');
            $showtime_uid = $request->get('showtime_id');

            $showtime =Showtime::findByUID($showtime_uid);
            $show = Show::findByUID($show_uid);
            if (!is_null($show)) {
                 $promotion = Promotion::getQuery($request->user(),$show,$showtime,$code)->firstOrFail();
                 $discount = $promotion->calculate($price);
                return ['discount' => $discount,
                        'final_price' => $price - $discount
                ];
            }
        }
        return response()->json(['errors' => $validator->errors()->all()],400);

    }
}
