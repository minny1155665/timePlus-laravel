<?php

namespace App\Services;

use Auth;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function getHolderName($event_id)
    {
        $event = Event::find($event_id);
        $holder = $event->users()->first();
        $holder_name = $holder->name;
        return $holder_name;
    }

    // favorite
    public function favorite($event_id)
    {
        $event = Event::find($event_id);
        $event->users()->attach(Auth::id(), ['user_role' => 'favorite']);

        return redirect()->back();
    }

    public function isFavorite($event_id)
    {
        $event = Event::find($event_id);
        $result = !is_null($event->users()
                          ->where('user_id', Auth::id())
                          ->where('user_role', 'favorite')
                          ->first());
        return $result;
    }

    public function cancelFav($event_id)
    {
        $event = Event::find($event_id);
        $event->users()
        ->where('user_id', Auth::id())
        ->wherePivot('user_role', 'favorite')
        ->detach();

        return redirect()->back();
    }

    // attend & help
    public function attend($event_id)
    {
        $event = Event::find($event_id);
        $event->users()->attach(Auth::id(), ['user_role' => 'attendee']);

        return redirect()->back();
    }

    public function help($event_id)
    {
        $event = Event::find($event_id);
        $event->users()->attach(Auth::id(), ['user_role' => 'helper']);

        return redirect()->back();
    }

    public function isAttended($event_id)
    {
        $event = Event::find($event_id);
        $result = !is_null($event->users()
                          ->where('user_id', Auth::id())
                          ->where('user_role', 'attendee')
                          ->orWhere('user_role', 'helper')
                          ->first());
        return $result;
    }

    public function cancelAttend($event_id)
    {
        $event = Event::find($event_id);
        $event->users()
        ->where('user_id', Auth::id())
        ->wherePivot('user_role', 'attendee')
        ->orWherePivot('user_role', 'helper')
        ->detach();

        return redirect()->back();
    }
    
    // calculate if places of attendees and helpers remain
    public function setAttendeeRemainingEvent(Event $event)
    {
        $attend_num = $event->attend_num;
        $attend_num_now = $event->users()
                                ->where('user_role', 'attendee')
                                ->count();
        $attend_num_remaining = $attend_num - $attend_num_now;

        if ($attend_num_remaining > 0)
        {
            DB::table('events')->where('id', $event->id)->update(['attend_remain' => 1]);
        }
        else
        {
            DB::table('events')->where('id', $event->id)->update(['attend_remain' => 0]);
        }
    }

    public function setHelperRemainingEvent(Event $event)
    {
        $help_num = $event->help_num;
        $help_num_now = $event->users()
                            ->where('user_role', 'helper')
                            ->count();
        $help_num_remaining = $help_num - $help_num_now;

        if ($help_num_remaining > 0 || $help_num == 0)
        {
            DB::table('events')->where('id', $event->id)->update(['help_remain' => 1]);
        }
        else
        {
            DB::table('events')->where('id', $event->id)->update(['help_remain' => 0]);
        }
    }

    // end event
    public function endEvent($event_id)
    {
        $event = Event::find($event_id);
        DB::table('events')->where('id', $event_id)->update(['status' => 'past']);
    }

    public function calculate($event_id)
    {
        $event = Event::find($event_id);
        $attend_num_actual = $event->users()->where('user_role', 'attendee')->count();
        $help_num_actual = $event->users()->where('user_role', 'helper')->count();
        $total_points = $event->attend_points * $attend_num_actual;
        if ($help_num_actual == 0)
        {
            $hold_points = $total_points;
            $help_points = 0;
        }
        else 
        {
            $hold_points = round($total_points / ($help_num_actual + 1), 0);
            $help_points = round($total_points / ($help_num_actual + 1), 0);
        }
        
        DB::table('events')->where('id', $event_id)->update(['hold_points' => $hold_points, 
        'help_points' => $help_points]);
    }

    public function distribute($event_id)
    {
        $event = Event::find($event_id);
        $hold_points = $event->hold_points;
        $help_points = $event->help_points;
        $attend_points = $event->attend_points;
        $user_ids = $event->users()->groupBy('user_id')->pluck('user_id');

        foreach ($user_ids as $user_id)
        {
            $user = User::find($user_id);
            $total_points = $user->total_points;
            $roles = $event->users()->where('user_id', $user_id)->pluck('user_role');
            foreach ($roles as $role)
            {
                if ($role == 'holder')
                {
                    $total_points += $hold_points;
                }
                elseif ($role == 'helper')
                {
                    $total_points += $help_points;
                }
                elseif ($role == 'attendee')
                {
                    $total_points -= $attend_points;
                }
                else
                {
                    $total_points += 0;
                }
            }

            DB::table('users')
            ->where('id', $user_id)
            ->update(['total_points' => $total_points]);
        }
    }
}

?>