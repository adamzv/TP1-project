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
     * Get events according faculties for last year and new
     *
     * @return false|string
     */
    public function getEventsFaculties()
    {
        $data = [];
        $data = $this->getFacultiesLastYearEventsCount($data);
        $data += $this->getFacultiesNewEventsCount($data);

        return json_encode($data);
    }

    /**
     * Get number of events for each faculty for last year
     *
     * @param $data
     * @return false|string
     */
    public function getFacultiesLastYearEventsCount($data)
    {
        $query = DB::table('events')
            ->select(DB::raw('COUNT(events.id) as pocet'), 'faculties.name as meno')
            ->join('faculties', 'events.id_faculty', '=', 'faculties.id')
            ->whereBetween('events.beginning', [Carbon::now()->subYear(), Carbon::now()])
            ->groupBy('faculties.name')
            ->get();

        $array = ['Fakulty'];
        $array2 = ['Počet eventov za posledný rok'];

        $i = 0;
        foreach ($query as $event) {
            $array['faculty' . $i] = $event->meno;
            $array2['pocet' . $i] = $event->pocet;
            $i++;
        }

        $data['faculty'] = $json_object = array_values($array);
        $data['pocet'] = $json_object2 = array_values($array2);

        return $data;
    }

    /**
     * Get number of new events for each faculty
     *
     * @param $data
     * @return false|string
     */
    public function getFacultiesNewEventsCount($data)
    {
        $query = DB::table('events')
            ->select(DB::raw('COUNT(events.id) as pocet'), 'faculties.name as meno')
            ->join('faculties', 'events.id_faculty', '=', 'faculties.id')
            ->where('events.beginning', '>=', Carbon::now())
            ->groupBy('faculties.name')
            ->get();

        $array = ['Fakulty'];
        $array2 = ['Počet nadchádzajúcich eventov'];

        $i = 0;
        foreach ($query as $event) {
            $array['faculty' . $i] = $event->meno;
            $array2['pocet' . $i] = $event->pocet;
            $i++;
        }

        $data['faculty1'] = $json_object = array_values($array);
        $data['pocet1'] = $json_object2 = array_values($array2);

        return $data;
    }

    /**
     * Returns number of events according faculty department (not using)
     *
     * @param $id
     * @param $id_departmentt
     * @return array
     */
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
     * Returns all stats for admin header
     *
     * @return array
     */
    public function getStats()
    {
        $data = [];
        array_push($data, $this->getOnlineUsers());
        array_push($data, $this->getRegisteredUsers());
        array_push($data, $this->getNewEvents());

        return $data;
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

    /**
     * Get number of registered users
     *
     * @return Collection
     */
    public function getRegisteredUsers()
    {
        return $query = DB::table('users')
            ->select(DB::raw('COUNT(DISTINCT(users.id)) as registrovani'))
            ->join('roles', 'roles.id', '=', 'users.id_role')
            ->whereNotNull('users.email_verified_at')
            ->where('roles.type', '!=', 'admin')
            ->where('roles.type', '!=', 'host<')
            ->get();
    }

    /**
     * Get number of events, that are planned
     *
     * @return Collection
     */
    public function getNewEvents()
    {
        return $query = DB::table('events')
            ->select(DB::raw('COUNT(DISTINCT(events.id)) as eventy'))
            ->where('events.beginning', '>=', Carbon::now())
            ->get();
    }
}
