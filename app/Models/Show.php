<?php

namespace App\Models;

use App\Classes\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Show
 *
 * @property int $id
 * @property string $title
 * @property string|null $artist_name
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $details
 * @property int $source_id
 * @property array $source_details
 * @property int|null $source_related_id
 * @property string|null $from_date
 * @property string|null $to_date
 * @property string $status
 * @property string $thumb_url
 * @property string $main_image_url
 * @property string|null $background_color
 * @property array $sponsors
 * @property string|null $terms_of_service
 * @property string|null $license_url
 * @property int $admin_id
 * @property int $city_id
 * @property int|null $category_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $admin
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genre[] $genres
 * @property-read mixed $scene
 * @property-read \$uid $uid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \App\Models\Producer $producer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Promotion[] $promotions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Showtime[] $showtimes
 * @property-read \App\Models\Source $source
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereArtistName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereLicenseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereMainImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereSourceDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereSourceRelatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereSponsors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereTermsOfService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereThumbUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Show whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Showtime[] $allShowtimes
 * @property-read \App\Models\Category|null $category
 */
class Show extends BaseModel
{
    public static $uidConnection = 'show';
    protected $appends = ['uid','scene'];
    protected $hidden = ['id','license_url',''];
    protected $fillable = ['title', 'artist_name', 'subtitle', 'description', 'from_date', 'to_date', 'thumb_url', 'main_image_url', 'background_color', 'category_id', 'city_id','source_id','source_details','source_related_id'];
    protected $casts = [
        'source_details' => 'array',
        'sponsors' => 'array',
    ];

    public function showtimes()
    {
        return $this->hasMany('App\Models\Showtime')->with('scene')->where('status','enabled');
    }
    public function allShowtimes()
    {
        return $this->hasMany('App\Models\Showtime')->with('scene');
    }
    public function promotions()
    {
        return $this->hasMany('App\Models\Promotion');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function source()
    {
        return $this->belongsTo('App\Models\Source');
    }
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }


    public function seats()
    {
        return Ticket::whereIn('showtime_id',array_map(function($o){return $o['id'];}, $this->allShowtimes->toArray()));
    }
    public function report()
    {
        $reportChart = $this->orders()->select(\DB::raw('SUM(price) as total, DATE(created_at) as date'))->where('status','approved')->groupBy('date')->get();
        $totalSale = $this->orders()->where('status','approved')->where('type','normal')->sum('price');
        $totalSeats = $this->seats()->count();
        $totalSoldSeats = $this->seats()->where('status','sold')->count();

        $prices = array_map(function($o) {return intVal($o['total']);}, $reportChart->toArray());
        $dates = array_map(function($o){ return \SeebBlade::prettyDateWithFormat(Carbon::parse($o['date']),'dd MMM yyyy');}, $reportChart->toArray());
        return ['chart_data_prices' => $prices,
                'chart_data_dates' => $dates,
                'total_sale' => $totalSale,
                'total_seats' => $totalSeats,
                'total_sold_seats' => $totalSoldSeats,
            ];
    }

    /*public function sponsor()
    {
        return $this->belongsTo('App\Models\Sponsor.disabled');
    }*/
    public function getSceneAttribute()
    {
        /** @var Showtime $showtime */
        $showtime = $this->allShowtimes()->first();
        return (is_null($showtime))? null : $showtime->scene;
    }

    public function genreIds()
    {
        $ids = [];
        foreach ($this->genres as $genre)
        {
            $ids[] = $genre->id;
        }
        return $ids;
    }


}

class ShowSponsor {
    public $name;
    public $logo_url;
    public $link;

    public function __construct($name,$logo_url,$link)
    {
        $this->name = $name;
        $this->logo_url = $logo_url;
        $this->link = $link;
    }
}
