<?php

use App\Config;
use App\OrderLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

if (!function_exists('currency_format')) {
    function currency_format($value, $thousand_separator = '.', $default_currency = 'Rp')
    {
        return 'Rp ' . number_format($value, 0, ',', $thousand_separator);
    }
}

if (!function_exists('numbering_format')) {
    function numbering_format($value, $thousand_separator = '.', $default_currency = 'Rp')
    {
        return number_format($value, 0, ',', $thousand_separator);
    }
}

if (!function_exists('delete_image')) {
    function delete_image($url)
    {
        Storage::delete($url);

        return true;
    }
}

if (!function_exists('shareFacebook')) {
    function shareFacebook($url)
    {
        return 'https://www.facebook.com/sharer/sharer.php?' . http_build_query([
            'u' => $url,
        ]);
    }
}

if (!function_exists('shareTwitter')) {
    function shareTwitter($url, $text = '')
    {
        return 'https://twitter.com/intent/tweet?' . http_build_query(compact('url', 'text'));
    }
}

if (!function_exists('shareGplus')) {
    function shareGplus($url)
    {
        return 'https://plus.google.com/share?' . http_build_query([
            'url' => $url,
        ]);
    }
}

if (!function_exists('shareLinkedIn')) {
    function shareLinkedIn($url, $text = '')
    {
        return 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . http_build_query(compact('text'));
    }
}

if (!function_exists('shareLine')) {
    function shareLine($url)
    {
        return 'http://line.me/R/msg/text/?' . $url;
    }
}

if (!function_exists('bccAdminEmails')) {
    function bccAdminEmails()
    {
        $emails = Config::where('name', 'bcc_email_system')->first();
        $bcc    = str_replace(' ', '', $emails->value);
        $bcc    = explode(',', $bcc);

        foreach ($bcc as $index => $email) {
            if ($email == '') {
                unset($bcc[$index]);
            }
        }

        return $bcc;
    }
}

if (!function_exists('insertRhapsodieLog')) {
    function insertRhapsodieLog($description, $type, $id, $details = '')
    {
        $a                 = [];
        $a['type']         = $type;
        $a['created_at']   = date('Y-m-d H:i:s');
        $a['ipaddress']    = $_SERVER['REMOTE_ADDR'];
        $a['useragent']    = $_SERVER['HTTP_USER_AGENT'];
        $a['url']          = Request::url();
        $a['description']  = $description;
        $a['details']      = $details;
        $a['id_cms_users'] = $id;
        DB::table('rhapsodie_logs')->insert($a);
    }
}

if (!function_exists('printReadMore')) {
    function printReadMore($string, $class = '', $url = '')
    {
        $string = strip_tags($string);
        if (strlen($string) > 200) {
            $stringCut = substr($string, 0, 200);
            $endPoint  = strrpos($stringCut, ' ');

            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        };

        return $string;
    }
}

if (!function_exists('insertOrderLog')) {
    function insertOrderLog($order, $status, $type)
    {
        $log                  = new OrderLog;
        $log->order_id        = $order->id;
        $log->status          = $status;
        $log->notes           = 'System (' . $type . ') update status to ' . ucwords($status);
        $log->admin_id        = 'Nicepay';
        $log->save();
    }
}
