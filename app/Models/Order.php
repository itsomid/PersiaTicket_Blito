<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * App\Models\Order
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $user_id
 * @property int|null $show_id
 * @property int $price
 * @property int|null $source_related_id
 * @property int $source_id
 * @property array $source_details
 * @property string $status
 * @property-read \$uid $uid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereSourceDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereSourceRelatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $promotion_id
 * @property-read \App\Models\Promotion|null $promotion
 * @property-read \App\Models\Show|null $show
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePromotionId($value)
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereType($value)
 */
class Order extends Model
{
    public static $uidConnection = 'order';
   protected $hidden = ['id'];
   protected $appends = ['uid'];
    protected $fillable = ['user_id'];
    protected $casts = [
        'source_details' => 'array',
//        'sum'=>'integer'
    ];



    public static function realId($uid) {
        //$id = ($uid - 14320) / 3;
        return $uid;
    }
    /**
     * @return $uid
     */
    public function getUidAttribute()
    {
        return $this->id;
    }

    /**
     * @param $uid
     * @return null or get_called_class()
     */
    public static function findByUID($uid)
    {
        //return get_called_class();
        $id = Order::realId($uid);
        if(is_null($id))
            return null;
        else
            return Order::find($id);
    }

    public function tickets()
    {
        return $this->hasMany('\App\Models\Ticket')->with(['showtime.show']);
    }

//    public function getSumAttribute()
//    {
//        return (int) $this->hasMany('\App\Models\Ticket')->sum('price');
//    }
    public function show() {
        return $this->belongsTo('\App\Models\Show');
    }
    public function payments() {
        return $this->hasMany('\App\Models\Payment')->where('status','successful');
    }
    public function allpayments() {
        return $this->hasMany('\App\Models\Payment');
    }
    public function promotion()
    {
        return $this->belongsTo('\App\Models\Promotion');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function calculate()
    {
        $price = 0;
        foreach ($this->tickets as $ticket)
        {
            if(is_null($this->show_id))
            {
                $this->show_id = $ticket->showtime->show_id;
            }
            $price += $ticket->price;
        }
        if(!is_null($this->promotion))
        {
            $price -= $this->promotion->calculate($price);
        }
        $this->price = $price;
        $this->save();
        return $price;
    }

    public function applyPromotion(Promotion $promotion)
    {
        $this->promotion_id = $promotion->id;
        $this->calculate();
    }
    public function cancel()
    {
        $this->status = 'canceled';
        $tickets = [];
        foreach ($this->tickets as $ticket)
        {
            $ticket->order_id = null;
            $ticket->reserved_at = null;
            $ticket->status = 'available';
            $ticket->reserved_by_user_id = null;
            $ticket->save();
            array_push($tickets,$ticket->id);
        }

        $source_details = [];
        if (is_null($this->source_details))
        {
            $source_details = $this->source_details;
        }


        $source_details['canceled_tickets'] = $tickets;
        $this->source_details = $source_details;
        $this->save();
    }


    public static function createOrderForTickets($ids, User $user, $disabled_allowed = false)
    {
        // determine if the tickets are available to reserve?

//        return $existingOrder = Ticket::whereIn('id',$ids)->whereIn('status',['available', 'reserved'])->groupBy('order_id')->select('order_id')->first();
        $existingOrder = Ticket::whereIn('id',$ids)->whereIn('status',['available', 'reserved'])->groupBy('order_id')->select('order_id')->first();

        if(!is_null($existingOrder) && !is_null($existingOrder->order_id))
        {
            $order = Order::with('tickets')->find($existingOrder->order_id);
            if($order->user_id == $user->id)
            {
                return $order;
            }else {
                return 400;
            }
        }
        DB::beginTransaction();
        //create order
        $order = Order::create([
            'user_id' => $user->id
        ]);

        $statuses = ['available'];
        if ($disabled_allowed)
            array_push($statuses,'disabled');

         $reservedCount = DB::table('tickets')->where(['reserved_by_user_id' => null, 'order_id' => null])->whereIn('id',$ids)->whereIn('status',$statuses)->orWhere(['status'=> 'reserved', 'reserved_by_user_id' => $user->id])->whereIn('id',$ids)->lockForUpdate()->update(['reserved_by_user_id' => $user->id, 'status' => 'reserved','reserved_at' => Carbon::now()->toDateTimeString(),'order_id' => $order->id]);
        if($reservedCount == count($ids))
        {

            // check if there will be orphan 1-seats
            $safe = true;
            foreach ($ids as $id)
            {
                // TODO: finish algorithm
                if(!Ticket::find($id)->singleAdjacentSeatSafe())
                {
                    $safe = false;
                }
            }
            if($safe)
            {
                DB::commit();
                if(count($order->tickets) > 0)
                {
                    $order->showtime_id = $order->tickets[0]->showtime_id;
                    $cacheKey = Showtime::cacheKey($order->tickets[0]->showtime_id);
                    \Cache::forget($cacheKey);
                }
                $order->calculate();
                return $order;
            }else{
                DB::rollBack();
                return 406;
            }
        }else {
            DB::rollBack();
            return 400;
        }

    }

    public static function createOrderForExternalTickets(Showtime $showtime, User $user, $seats, $totalPrice, $reserveId, $traceNumber)
    {

        $order = Order::create([
            'user_id' => $user->id
        ]);
        $order->price = $totalPrice;
        $order->source_related_id = $reserveId;
        $order->source_id = $showtime->show->source_id;
        $order->user_id = $user->id;
        $order->show_id = $showtime->show->id;
        $order->showtime_id = $showtime->id;
        $order->source_details = [
            'trace_number' => $traceNumber,
            'reserve_id' => $reserveId,
            'urn' => $showtime->show->source_details['urn']
        ];
        $order->status = 'pending';
        $order->save();


        $seats = explode(',',$seats);

        if(count($seats)>1){

            foreach ($seats as $seat)
            {
                $seat_details = explode('-',$seat);
                $zone = "";
                $row = 0;
                $seat = 0;
                switch(count($seat_details))
                {
                    case 2:
                        $row = $seat_details[0];
                        $seat = $seat_details[1];
                        break;
                    case 3:
                        $zone = $seat_details[0];
                        $row = $seat_details[1];
                        $seat = $seat_details[2];
                        break;
                }
                Ticket::newTicketForExternalTicket($order,$showtime,$zone,$row,$seat);
            }
        }
        else{
            foreach ($seats as $seat)
            {
                $seat_details = explode('-',$seat);
                $zone = "";
                $row = 0;
                $seat = 0;
                switch(count($seat_details))
                {
                    case 2:
                        $row = $seat_details[0];
                        $seat = $seat_details[1];
                        break;
                    case 3:
                        $zone = $seat_details[0];
                        $row = $seat_details[1];
                        $seat = $seat_details[2];
                        break;
                }
                Ticket::newTicketForExternalTicket($order,$showtime,$zone,$row,$seat);
            }
        }


        return $order;
    }
}
