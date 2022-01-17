<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeatPlan
 *
 * @property int $id
 * @property string $title
 * @property string|null $image_url
 * @property int $scene_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatPlan whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatPlan whereSceneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatPlan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeatPlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeatPlan extends Model
{
    protected $table = "plans";
    protected $fillable = ['title', 'image_url', 'scene_id'];
    protected $hidden = ['id','scene_id', 'created_at','updated_at'];
}
