<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property int $price
 * @property string $code
 * @property int|null $seat_id
 * @property int $showtime_id
 * @property int|null $source_id
 * @property array $ticket_info
 * @property int|null $reserved_by_user_id
 * @property string|null $reserved_at
 * @property int|null $order_id
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \$uid $uid
 * @property-read \App\Models\Seat|null $seat
 * @property-read \App\Models\Showtime $showtime
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereReservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereReservedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereSeatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereShowtimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereTicketInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Order|null $order
 */
class Ticket extends BaseModel
{
    public static $uidConnection = 'ticket';

    protected $fillable = ['price', 'seat_id', 'showtime_id', 'status','ticket_info'];
    protected $appends = ['uid'];
//    protected $hidden = ['id','code','updated_at','created_at','seat_id', 'showtime_id', 'source_id','status','uid','reserved_by_user_id','reserved_at','price'];
    protected $hidden = ['id','code','updated_at','created_at','seat_id', 'showtime_id', 'source_id'];
    protected $casts = [
        'ticket_info' => 'array',
    ];


    public function showtime()
    {
        return $this->belongsTo('App\Models\Showtime');
    }
    public function seat()
    {
        return $this->belongsTo('App\Models\Seat');
    }
    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
    public function iosOrder(){
        return $this->belongsTo('App\Models\Order')->where('agent','ios');
    }
    public function androidOrder(){
        return $this->belongsTo('App\Models\Order')->where('agent','android');
    }public function webOrder(){
        return $this->belongsTo('App\Models\Order')->where('agent','web');
    }
    private function checkTickets($entryTickets) {

        $tickets = [];
        foreach ($entryTickets as $ticket)
        {
            if(!is_null($ticket->seat))
                $tickets[] = $ticket;
        }
        switch(count($tickets))
        {
            case 1:
                if($tickets[0]->status == 'available')
                {
                    return false;
                }
                break;
            case 2:
                if($tickets[0]->status == 'available')
                {
                    if($tickets[1]->status != 'available')
                    {
                        return false;
                    }
                }
                break;
        }
        return true;
    }
    public function singleAdjacentSeatSafe()
    {

        $ticketsBefore = Ticket::with(['seat' => function($query)
        {
            return $query->where('row_id', $this->seat->row_id);
        }])->where('id','<',$this->id)->take(2)->orderBy('id','DESC')->get();
        $ticketsAfter = Ticket::with(['seat' => function($query)
        {
            return $query->where('row_id', $this->seat->row_id);
        }])->where('id','>',$this->id)->take(2)->orderBy('id','ASC')->get();

        return true;// $this->checkTickets($ticketsAfter) && $this->checkTickets($ticketsBefore);
    }
    /*
    public function getTicketInfoAttribute()
    {
        return json_decode($this->details);
    }
*/


    /*
     * Factory Methods
     */
    public static function newTicketForExternalTicket(Order $order,Showtime $showtime,$zone,$row,$seat)
    {
        $ticket = new Ticket();
        $ticket->price = -1;
        $ticket->showtime_id = $showtime->id;
        $ticket->source_id = $showtime->show->source_id;
        $ticket->status = 'external';
        $ticket->ticket_info = [
            'zone' => $zone,
            'row' => strval($row),
            'seat' => strval($seat)
        ];
        $ticket->order_id = $order->id;
        $ticket->save();
        return $ticket;
    }
    /*
     * Updating model status
     */
    public function reserveForUser(User $user) {

        if($user->reservedTickets()->count() < 5)
        {
            if (Ticket::whereId($this->id)->where('reserved_by_user_id','=',null)->where('status','=','available')->lockForUpdate()->update(['reserved_by_user_id' => $user->id, 'status' => 'reserved','reserved_at' => Carbon::now()->toDateTimeString()]) > 0) {
                $this->touch();
                return [true,200];
            }
        }
        return [false,406];
    }

    public function cancelReservationFor(User $user) {

        if (Ticket::whereId($this->id)->where('reserved_by_user_id','=',$user->id)->where('status','=','reserved')->lockForUpdate()->update(['reserved_by_user_id' => null, 'status' => 'available','reserved_at' => null]) > 0) {
            $this->touch();
            return [true,200];
        }
        return [false,404];
    }
}
