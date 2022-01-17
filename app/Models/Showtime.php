<?php

namespace App\Models;

use App\Classes\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Showtime
 *
 * @property int $id
 * @property string $datetime
 * @property array $source_details
 * @property string $status
 * @property int $show_id
 * @property int $scene_id
 * @property int|null $source_related_id
 * @property int $source_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $remaining_seats
 * @property-read \$uid $uid
 * @property-read \App\Models\Scene $scene
 * @property-read \App\Models\Show $show
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereSceneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereSourceDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereSourceRelatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $available_since
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Showtime whereAvailableSince($value)
 */
class Showtime extends BaseModel
{
    //
    public static $uidConnection = "showtime";
    protected $fillable = ['datetime', 'scene_id', 'show_id', 'source_details','source_id','source_related_id','available_since'];
    protected $hidden = ['show_id'];
    protected $appends = ['uid','remaining_seats'];
    protected $casts = [
        'source_details' => 'array',
    ];
    public function scene() {
        return $this->belongsTo('App\Models\Scene');
    }
    public function show() {
        return $this->belongsTo('App\Models\Show');
    }
    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }
    public function getRemainingSeatsAttribute()
    {
            $details = new ShowTimeCache($this->id);
            return $details->remaining_seats;
    }

    /*
     * Factory Methods
     */
    public static function createRawShowTimeForShow($show, $scene, $datetime, $available)
    {
        $showtime = Showtime::create([
            'datetime' => $datetime,
            'scene_id' => $scene->id,
            'show_id' => $show->id,
            'available_since' => $available,
        ]);
        $showtime->status = 'enabled';
        $showtime->save();
        return $showtime;
    }
    public static function createShowTimeForShow($show, $scene, $datetime,$prices, $source = null, $source_related_id = null)
    {
        $showTime = Showtime::create([
            'datetime' => $datetime,
            'scene_id' => $scene->id,
            'show_id' => $show->id
        ]);
        $showTime->status = 'enabled';
        $showTime->save();

        foreach ($scene->zones as $zone)
        {
            $priceList = $prices[$zone->id];
            foreach ($zone->seats as $seat)
            {
                $price = $priceList[$seat->row->row];
                $ticket = Ticket::create([
                    'price' => $price < 0 ? 0 : $price,
                    'seat_id' => $seat->id,
                    'showtime_id' => $showTime->id,
                    'status' => $price < 0 ? 'disabled' : 'available',
                    'ticket_info' => [
                        'zone' => $zone->name,
                        'row' => strval($seat->row->row),
                        'seat' => strval($seat->column)
                    ]
                ]);
                if (!is_null($source))
                {
                    $ticket->source_id = $source->id;
                    $ticket->source_related_id = $source_related_id;
                }
                $ticket->save();
            }
        }
    }
    public static function cacheKey($showtime_id)
    {
        return 'showtime_'.$showtime_id;
    }



    public function seatDetails($compact = true)
    {
        $showtime = $this;
        $priced_seats = [];
        $disabled_seats = [];
        $zones = [];
        foreach ($showtime->show->scene->zones as $zone)
        {
            $zones[$zone->id.""] = [
                "seats_count" => $zone->seats()->count(),
                "priced_count" => 0,
                "disabled_count" => 0,
                "known_count" => 0,
                "worth" => 0,
                "name" => $zone->name
            ];
        }
        foreach($showtime->tickets as $ticket)
        {
            if ($ticket->status == "disabled")
            {
                if ($compact)
                    $disabled_seats[] = $ticket->seat->id.":disabled";
                else
                    $disabled_seats[] = $ticket->seat;

                $zones[$ticket->seat->row->zone->id.""]["disabled_count"]++;
                $zones[$ticket->seat->row->zone->id.""]["known_count"]++;
            }
            else if ($ticket->price != 0) {
                if ($compact)
                    $priced_seats[] = $ticket->seat->id.":".$ticket->price;
                else
                    $priced_seats[] = $ticket->seat;

                $zones[$ticket->seat->row->zone->id.""]["priced_count"]++;
                $zones[$ticket->seat->row->zone->id.""]["worth"]+= $ticket->price;
                $zones[$ticket->seat->row->zone->id.""]["known_count"]++;
            }
        }
        return ['priced' => $priced_seats, 'disabled' => $disabled_seats, 'zones' => $zones];
    }
}

class ShowTimeCache {
    public $remaining_seats;
    //public $tickets;
    public $zones;
    public $price_classes;


    public function __construct($showtime_id)
    {
        $cacheKey = Showtime::cacheKey($showtime_id);
        if(!\Cache::has($cacheKey))
        {
            // get data
            $this->price_classes = [];
            $showtime = Showtime::whereId($showtime_id)->first();
            //$this->tickets = $showtime->tickets;
            $this->remaining_seats = $showtime->tickets()->where('status','available')->count();
            $this->zones = [];
            foreach ($showtime->scene->zones()->with('plan')->get() as $zone)
            {

                $price_classes = array_column($zone->rows()
                    ->join('seats', 'rows.id', '=', 'seats.row_id')
                    ->join('tickets', 'seats.id', '=', 'tickets.seat_id')
                    ->select('tickets.price')->distinct()
                    ->get()->toArray(),'price');
                if (($key = array_search(0, $price_classes)) !== false) {
                    unset($price_classes[$key]);
                }
                $price_classes = array_values($price_classes);
                $this->zones[] = [
                    'zone' => $zone,
                    'remaining' => $zone->seats()->whereHas('tickets', function ($query) use($showtime_id) {$query->where('showtime_id', $showtime_id)->where('status','available');})->count(),
                    'rows' => $zone->rows()->with(['seats.tickets' => function ($query) use($showtime_id) {$query->where('showtime_id', $showtime_id);}])->get(),
                    'price_classes' => $price_classes
                ];
                $this->price_classes = array_merge($this->price_classes,$price_classes);
                sort($this->price_classes );
                //$this->price_classes = array_values($this->price_classes);
            }
            //json_encode
            $this->price_classes = array_values(array_unique($this->price_classes));

            \Cache::put($cacheKey,json_encode($this),Carbon::now()->addMinutes(60));
        }else {
            foreach (get_object_vars(json_decode(\Cache::get($cacheKey))) as $key => $value)
            {
                $this->$key = $value;
            }
        }
    }
}