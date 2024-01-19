<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\GosendTrack;
use function GuzzleHttp\json_decode;

class GosendController extends CoreController
{
    public function webhook()
    {
        $json_result = file_get_contents('php://input');
        $result      = json_decode($json_result);

        $track = GosendTrack::where('gojek_code', $result->booking_id)->first();
        if ($track) {
            $track->status          = $result->type;
            $track->data_webhook    = $json_result;
            $track->save();
        }

        return;
    }
}
