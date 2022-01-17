<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Scene
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string|null $phone
 * @property string|null $main_image_url
 * @property int|null $source_related_id
 * @property int $source_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeatPlan[] $plans
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeatZone[] $zones
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereMainImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereSourceRelatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $seats_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scene whereSeatsCount($value)
 */
class Scene extends Model
{
protected $fillable = ['name', 'address', 'city', 'phone','source_related_id','source_id'];
protected $hidden = ['created_at','updated_at'];



    public function zones()
    {
       return  $this->hasMany('App\Models\SeatZone');
    }
    public function plans()
    {
        return $this->hasMany('App\Models\SeatPlan');
    }
    public function showtimes()
    {
        return $this->hasMany('App\Models\Showtime');
    }
    public function calculateSeatsCount()
    {
        $seatsCount = 0;
        foreach ($this->zones as $zone)
        {
            $seatsCount+= $zone->seats()->count();
        }
        $this->seats_count = $seatsCount;
    }
    /*
      *
      * Location related methods
      *
      */

    protected $geofields = ['location'];

    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value[0],$value[1])");
    }

    public function getLocationAttribute($value){

        preg_match_all('/([0-9\.]+)/',$value,$matches);
        return $matches[1];
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }
}
