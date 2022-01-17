<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Producer
 *
 * @property int $id
 * @property string $title
 * @property string $logo_url
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Producer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Producer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Producer whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Producer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Producer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Producer whereUserId($value)
 * @mixin \Eloquent
 */
class Producer extends Model
{
    //
}
