<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $country_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $shows
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    //
    protected $fillable = ['name', 'country_code'];




    public function shows()
    {
        return $this->hasMany('\App\Models\Show')->where('status','enabled');
    }
    public function categories()
    {
        return Category::with(['shows' => function ($query) {
            $query->where('city_id', '=', $this->id)->where('status','enabled')->has('showtimes');
        }]);

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
