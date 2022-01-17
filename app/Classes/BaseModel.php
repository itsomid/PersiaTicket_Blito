<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 8/11/17
 * Time: 10:22 PM
 */

namespace App\Classes;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * App\Classes\BaseModel
 *
 * @property-read \$uid $uid
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    public static $uidConnection = "main";

    public static function realId($uid) {
        $id = Hashids::connection(get_called_class()::$uidConnection)->decode($uid);
        if(count($id) == 0)
            return null;
        else
            return $id[0];
    }
    /**
     * @return $uid
     */
    public function getUidAttribute()
    {
        return Hashids::connection(get_class($this)::$uidConnection)->encode($this->id);
    }

    /**
     * @param $uid
     * @return null or get_called_class()
     */
    public static function findByUID($uid)
    {
        //return get_called_class();
        $id = get_called_class()::realId($uid);
        if(is_null($id))
            return null;
        else
            return get_called_class()::find($id);
    }

}