<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class StatsController
 * @author lacal
 */
class StatsController extends Controller
{
    /**
     * Get number of events for each faculty
     *
     * @return false|string
     */
    public function getFacultiesEventsCount()
    {
        $query = DB::table('events')
            ->select(DB::raw('COUNT(events.id) as pocet'), 'faculties.name as meno')
            ->join('faculties', 'events.id_faculty', '=', 'faculties.id')
            ->whereBetween('events.beginning', [Carbon::now()->subYear(), Carbon::now()])
            ->groupBy('faculties.name')
            ->get();

        $data = [];
        $array = [];
        $array2 = [];

        $i = 0;
        foreach ($query as $event) {
            array_push($array, $event->meno);
            array_push($array2, $event->pocet);
            $i++;
        }

        $data['faculty'] = $array;
        $data['count'] = $array2;

        return json_encode($data);
    }

    /**
     * Get number of online users
     *
     * @return Collection
     */
    public function getOnlineUsers()
    {
        return $query = DB::table('oauth_access_tokens')
            ->select(DB::raw('COUNT(DISTINCT(user_id)) AS pocet'))
            ->where('oauth_access_tokens.expires_at', '>=', Carbon::now())
            ->get();
    }
}
