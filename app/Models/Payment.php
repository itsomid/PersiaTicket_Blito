<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Seeb\shSMS;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $via
 * @property string|null $authority
 * @property string $payment_details
 * @property int $amount
 * @property int|null $user_id
 * @property int|null $order_id
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $payment_info
 * @property-read \$uid $uid
 * @property-read \App\Models\Order|null $order
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereVia($value)
 * @mixin \Eloquent
 */
class Payment extends BaseModel
{
    public static $uidConnection = 'payment';
    protected $hidden = ['authority','payment_details', 'user_id','order_id','id'];
    protected $appends = ['payment_info', 'uid'];
    public function details()
    {
        return json_decode($this->payment_details);
    }
    public function setDetails($details)
    {
        $this->payment_details = json_encode($details);
        $this->save();
    }
    public function getPaymentInfoAttribute() {
        return $this->details();
    }
    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function setPaid()
    {
        $this->status = 'successful';
        $this->save();
        /** @var Order $order */
        $order = $this->order;
        //$order->tickets()->update(['status' => 'sold', 'reserved_at' => null, 'reserved_by_user_id' => null]);
        $order->status = 'approved';
        $order->save();
        foreach ($order->tickets as $ticket)
        {
            if($order->user->id != $ticket->reserved_by_user_id)
            {
                continue;
            }
            $ticket->reserved_at = null;
            $ticket->status = 'sold';
            $ticket->reserved_by_user_id = null;
            $ticket->save();
        }
        shSMS::sendPurchase($order->user->mobile, $order->id);
//        var_dump($this->order->showtime_id);
//        die();
        //cache()->delete($this->order->showtime_id);

    }
    public function setFailed()
    {
        $this->status = 'failed';
        $this->save();
        /** @var Order $order */
        $order = $this->order;
        foreach ($order->tickets as $ticket)
        {
            if($order->user->id != $ticket->reserved_by_user_id)
            {
                continue;
            }
            $ticket->order_id = null;
            $ticket->reserved_at = null;
            $ticket->status = 'available';
            $ticket->reserved_by_user_id = null;
            $ticket->save();
        }
        //cache()->delete($this->order->showtime_id);
    }
}
