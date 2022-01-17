<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeatRow
 *
 * @property int $id
 * @property int|null $row
 * @property int $zone_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Seat[] $seats
 * @property-read \App\Models\SeatZone $zone
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatRow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatRow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatRow whereRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatRow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatRow whereZoneId($value)
 * @mixin \Eloquent
 */
class SeatRow extends Model
{
    //
    protected $table = "rows";

    protected $fillable = ['row', 'zone_id'];

    public function seats() {
        return $this->hasMany('App\Models\Seat','row_id');
    }
    public function zone() {
        return $this->belongsTo('App\Models\SeatZone','zone_id');
    }
}
