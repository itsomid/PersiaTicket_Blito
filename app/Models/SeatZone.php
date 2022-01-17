<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeatZone
 *
 * @property int $id
 * @property string $name
 * @property float $x
 * @property float $y
 * @property string|null $zonemap_image_url
 * @property int $scene_id
 * @property int $plan_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\SeatPlan $plan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeatRow[] $rows
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Seat[] $seats
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereSceneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatZone whereZonemapImageUrl($value)
 * @mixin \Eloquent
 */
class SeatZone extends Model
{
    protected $table = "zones";
    protected $fillable = ['name', 'x', 'y', 'scene_id', 'plan_id'];
    protected $hidden = ['scene_id','plan_id','created_at','updated_at'];
    public function seats()
    {
        return $this->hasManyThrough('App\Models\Seat','App\Models\SeatRow','zone_id','row_id');
    }
    public function rows()
    {
        return $this->hasMany('App\Models\SeatRow','zone_id')->with('seats');
    }
    public function tickets()
    {
        return $this->hasManyThrough('App\Models\Ticket','App\Models\Seat','zone_id','seat_id');
    }
    public function plan() {
        return $this->belongsTo('App\Models\SeatPlan', 'plan_id');
    }
}
