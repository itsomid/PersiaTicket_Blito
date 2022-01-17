<?php

namespace App;

use App\Models\Promotion;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $password
 * @property string $mobile
 * @property string|null $code
 * @property string|null $avatar_url
 * @property string|null $ip_address
 * @property int $access_level
 * @property string $status
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $favorites
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Show[] $ownShows
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $ownShowsOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $reservedTickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Producer $producer
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile','code','first_name','last_name','email','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','code','ip_address'
    ];

    public function reservedTickets() {
        return $this->hasMany('App\Models\Ticket','reserved_by_user_id')->with('seat');
    }
    public function tickets() {
        return $this->hasManyThrough('App\Models\Ticket','App\Models\Order');
    }
    public function orders() {
        return $this->hasMany('App\Models\Order');
    }

    public function payments() {
        return $this->hasMany('App\Models\Payment');
    }
    public function producer()
    {
        return $this->hasOne('App\Models\Producer');
    }

    public function isAdmin()
    {
        return $this->access_level == 10;
    }


    public function favorites()
    {
        return $this->belongsToMany('App\Models\Show');
    }

    public function fullName()
    {
        if (is_null($this->first_name) && is_null($this->last_name))
        {
            return $this->mobile ?? "";
        }

        $name = $this->first_name." ".$this->last_name;
        if (isset($this->producer))
        {
            $name .= ' ('.$this->producer->title.')';
        }
        return $name;
    }
    public static function generateCode() {
        $length = 5;
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /*
     * Admin
     *
     */
    public function ownShows() {
        return $this->hasMany('App\Models\Show','admin_id');
    }
    public function ownShowsOrders() {
        return $this->hasManyThrough('App\Models\Order','App\Models\Show','admin_id','show_id');
    }

    public function updateProfile($first_name = null, $last_name = null, $email = null, $mobile = null)
    {
        $errors = [];
        $this->first_name = !is_null($first_name) ? $first_name : $this->first_name;
        $this->last_name = !is_null($last_name) ? $last_name : $this->last_name;
        $email = strtolower($email);
        if($this->email != $email)
        {
            if(User::whereEmail($email)->count() > 0)
            {
                $errors[] = 1;
            }else
            {
                $this->email = $email;
            }
        }
        if($this->mobile != $mobile)
        {
            if(User::whereMobile($mobile)->count() > 0)
            {
                $errors[] = 0;
            }else {
                $this->mobile = $mobile;
            }
        }
        $this->save();
        return $errors;
    }
}
