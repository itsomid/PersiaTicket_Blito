<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Seat
 *
 * @property int $id
 * @property int|null $column
 * @property int $space_to_right
 * @property int $space_to_left
 * @property int $zone_id
 * @property int|null $row_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\SeatRow|null $row
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereSpaceToLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereSpaceToRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Seat whereZoneId($value)
 * @mixin \Eloquent
 */
class Seat extends Model
{
    protected $fillable = ['column','row_id','zone_id','space_to_right','space_to_left'];

    protected $hidden = ['created_at','updated_at','zone_id','row_id'];

    public function tickets() {
        return $this->hasMany('App\Models\Ticket');
    }
    public function row() {
        return $this->belongsTo('App\Models\SeatRow');
    }

    /*
     * Factory Methods
     */
    public static function createSeatsFor($zone, $seats, $first_row = 1)
    {
        $i = $first_row;
        foreach ($seats as $seat_count)
        {
            $row = SeatRow::create([
                'row' => $i,
                'zone_id' => $zone->id
            ]);

            for($j = $seat_count[1]; $j <= $seat_count[2]; $j++)
            {
                //$rand1 = rand(-5, 2);
                //$rand2 = rand(-5, 2);

                $seat = new Seat([
                    'row_id' => $row->id,
                    'column' => $j,
                    'zone_id' => $zone->id,
                    'space_to_left' => $j == $seat_count[1] ? $seat_count[0] : 0,
                    'space_to_right' => 0
                ]);
                $seat->save();
            }
            $i++;
        }
    }
}
