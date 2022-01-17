<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * App\Models\Device
 *
 * @property integer $id
 * @property string $platform
 * @property string $os_version
 * @property string $device_model
 * @property string $device_token
 * @property string $onesignal_identifier
 * @property integer $user_id
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $uid
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device wherePlatform($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereOsVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereDeviceModel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereDeviceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereOnesignalIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $bundle_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Device whereBundleId($value)
 */
class Device extends Model
{

    protected $appends = ['uid'];
    protected $hidden = ['id'];

    public function getUidAttribute()
    {
        return Hashids::connection('device')->encode($this->id);
    }

    public function is_driver() {
        return (strtolower($this->bundle_id) == 'co.seeb.hamloodriver');
    }
}
