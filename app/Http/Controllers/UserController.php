<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('personalPage', ['user' => $user]);
    }

    public function showFavorite()
    {
        $favorites = (new UserService())->getFavorites();
        return view('favoriteList', ['favorites' => $favorites]);
    }

    public function getHolds()
    {
        $holdings = (new UserService())->getHoldings();
        $holdeds = (new UserService())->getHoldeds();
        return view('holdList', ['holdings' => $holdings, 'holdeds' => $holdeds]);
    }

    public function getTickets()
    {
        $helps = (new UserService())->getHelpTickets();
        $attends = (new UserService())->getAttendTickets();
        return view('ticketList', ['helps' => $helps, 'attends' => $attends]);
    }

    public static function getAttendedEventNum()
    {
        $eventNum = (new UserService())->getAttendedEventNum();
        return $eventNum;
    }
}
