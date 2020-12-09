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
            ->select(DB::raw('COUNT(events.id) as pocet'), 'faculties.name as meno', 'events.id_faculty as fid', 'events.*')
            ->join('faculties', 'events.id_faculty', '=', 'faculties.id')
            ->whereBetween('events.beginning', [Carbon::now()->subYear(), Carbon::now()])
            ->groupBy('faculties.name')
            ->get();

        $data = [];
        $array = [];
        $array2 = [];
        $array3 = [];

        $i = 0;
        foreach ($query as $event) {
            array_push($array, $event->meno);
            array_push($array2, $event->pocet);


            $array3[$event->meno] = $this->getDepartmentsCount($event->fid, $event->id_department);
            $i++;
        }

        $data['faculty'] = $array;
        $data['count'] = $array2;
        $data['departments'] = $array3;

        return json_encode($data);
    }

    public function getDepartmentsCount($id, $id_departmentt)
    {
        $query = DB::table('events')
            ->select(DB::raw('COUNT(events.id_department) as pocet'), 'departments.name as meno')
            ->join('departments', 'events.id_department', '=', 'departments.id')
            ->whereBetween('events.beginning', [Carbon::now()->subYear(), Carbon::now()])
            ->where('events.id_faculty', '=', $id)
            ->groupBy('departments.name')
            ->get();

        $array = [];
        foreach ($query as $event) {
            if (!empty($id_departmentt)) {
                array_push($array, $event->meno);
                array_push($array, $event->pocet);

            } else {
                array_push($array, 'faculty');
                array_push($array, $event->pocet);

            }
        }
        return $array;
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
