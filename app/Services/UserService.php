<?php
namespace App\Services;

use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    // get events
    public function getFavorites()
    {
        $user = Auth::user();
        $events = $user->events()->where('user_role', 'favorite')->orderBy('date')->get();
        return $events;
    }

    public function getHoldings()
    {
        $user = Auth::user();
        $holdings = $user->events()
                    ->where('user_role', 'holder')
                    ->where('status', 'not_yet')
                    ->orderBy('date')
                    ->get();
        return $holdings;
    }

    public function getHoldeds()
    {
        $user = Auth::user();
        $holdeds = $user->events()
                    ->where('user_role', 'holder')
                    ->where('status', 'past')
                    ->orderBy('date')
                    ->get();
        return $holdeds;
    }

    public function getHelpTickets()
    {
        $user = Auth::user();
        $events = $user->events();
        $tickets = $events
                    ->Where('user_role', 'helper')
                    ->where('status', 'not_yet')
                    ->orderBy('date')
                    ->get();
        return $tickets;
    }

    public function getAttendTickets()
    {
        $user = Auth::user();
        $events = $user->events();
        $tickets = $events
                    ->Where('user_role', 'attendee')
                    ->where('status', 'not_yet')
                    ->orderBy('date')
                    ->get();
        return $tickets;
    }

    // get events' counts
    public function getAttendedEventNum()
    {
        $user = Auth::user();
        $eventNum = $user->events()
                    ->where('user_role', 'attendee')
                    ->where('status', 'past')
                    ->count();
        return $eventNum;
    }
}
?>