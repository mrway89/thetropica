<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class Maintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ipList = DB::table('configs')->where('name', 'whitelist_ip')->first();
        $maintenanceStatus = DB::table('configs')->where('name', 'maintenance_mode')->first();

        if ($maintenanceStatus->value == 1) {
            $ip                     = $request->ip();
            $whitelistIP            = str_replace(' ', '', $ipList->value);
            $whitelistIP            = explode(',', $whitelistIP);
            if (!in_array($ip, $whitelistIP)) {
                return redirect('coming-soon');
            }
        }

        return $next($request);
    }
}
