<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Source
 *
 * @property int $id
 * @property string $title
 * @property string|null $class_name
 * @property int|null $owner_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Source extends Model
{
    //
    protected $fillable = ['class_name','title','owner_id'];
}
