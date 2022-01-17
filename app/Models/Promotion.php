<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Promotion
 *
 * @property int $id
 * @property string $code
 * @property string $since_date
 * @property string $until_date
 * @property int $constant_discount
 * @property float $percent_discount
 * @property int $usage_count
 * @property int|null $user_id
 * @property int|null $show_id
 * @property int|null $created_by_user_id
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereConstantDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereCreatedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion wherePercentDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereSinceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereUntilDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereUsageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promotion whereUserId($value)
 * @mixin \Eloquent
 */
class Promotion extends Model
{

    public function calculate($price)
    {
        return $this->constant_discount + $price * $this->percent_discount;
    }
    public function showtime()
    {
        return $this->belongsTo('App\Models\Showtime');
    }

    // Factory methods

    public static function getQuery(User $user,Show $show, Showtime $showtime, $code)
    {
        return Promotion::where('status','enabled')->where(function($query) use ($user) {

            $query->where('user_id',$user->id)->orWhereNull('user_id');

        })->where(function ($query) use ($show) {

            $query->where('show_id',$show->id)->orWhereNull('show_id');

        })->where(function ($query) use ($showtime) {

            $query->where('showtime_id',$showtime->id)->orWhereNull('showtime_id');

        })->where('code',$code)->where('usage_count', '<>', 0)->where('since_date','<=', Carbon::now()->toDateTimeString())->where('until_date','>=',Carbon::now()->toDateTimeString());
    }
}
