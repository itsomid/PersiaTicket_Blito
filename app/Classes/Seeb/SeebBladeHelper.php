<?php

namespace App\Classes\Seeb;


use App\Models\Scene;
use Carbon\Carbon;
use IntlCalendar;
use IntlDateFormatter;
use NumberFormatter;

class SeebBladeHelper
{
    public function isActive($exact,$name,$true,$false)
    {
        //$route = \Request::route()->getName();//\Request::getUri();//route()->getName();
        $route = \Request::getUri();//route()->getName();

        return ($exact && $route == $name) || (!$exact && substr($route,0,strlen($name)) === $name)? $true : $false;
    }

    public function persianDigits($number)
    {
        $formatter= new NumberFormatter('fa_IR', NumberFormatter::DECIMAL);
        return $formatter->format($number);
    }
    public function prettyDate($date)
    {
        $formatter = new IntlDateFormatter('fa_IR', IntlDateFormatter::NONE,
            IntlDateFormatter::FULL, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL);
        $formatter->setPattern("dd MMM yyyy در ساعت HH:mm:ss");
        return $formatter->format(strtotime($date));
    }
    public function prettyDateWithFormat($date,$format, $locale = 'fa_IR')
    {
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::NONE,
            IntlDateFormatter::FULL, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL);
        $calendar = IntlCalendar::createInstance(
            'Asia/Tehran', $locale."@calendar=persian");
        $formatter->setCalendar($calendar);
        $formatter->setPattern($format);
        return $formatter->format(strtotime($date));
    }

    public function prettyDateDiff($from, $to)
    {
        $diff = \Carbon\Carbon::parse($to)->diff(\Carbon\Carbon::parse($from));
        $days = $diff->format('%d');
        $hours = $diff->format('%h');
        $minutes = $diff->format('%i');
        $seconds = $diff->format('%s');
        $final = "";
        $final .= ($days > 0)? $days." روز ":"";
        $final .= ($hours > 0)? $hours." ساعت ":"";
        $final .= ($minutes > 0)? $minutes." دقیقه ":"";
        $final .= ($final != "")? "و ":"";
        $final .= $seconds." ثانیه";

        return $final;

    }
    public function carbonFromPersian($dateString, $format = "d-MM-yyyy HH:mm:ss",$convert = true,$persianCalendar = false)
    {
        $formatter = new IntlDateFormatter('fa_@calendar=persian', IntlDateFormatter::NONE,
            IntlDateFormatter::FULL, 'Asia/Tehran', IntlDateFormatter::TRADITIONAL);

        if ($persianCalendar)
        {
            $calendar = IntlCalendar::createInstance(
                config('app.timezone'), "fa@calendar=persian");
            $formatter->setCalendar($calendar);
        }
        $formatter->setPattern($format);
        if ($convert)
        {
            $dateComponents = explode('/',$dateString);
            $dateString = "$dateComponents[2]-$dateComponents[1]-$dateComponents[0] 00:00:00";
        }
        $formatter->setLenient(true);
        $date = $formatter->parse($dateString);
        return Carbon::createFromTimestamp($date);
    }
    public function staticMapUrl($scene)
    {
        $url = "http://maps.googleapis.com/maps/api/staticmap?size=634x300&maptype=map";
        $url .= "&markers=icon:http://hamloo.com/seeb-pnl/images/pin-destination.png|".$scene->location[0].','.$scene->location[1]."&key=AIzaSyDkL9w6tZ4wNRlKxq1rtSs5tbzEB2PC1Ss";
        return $url;
    }
}