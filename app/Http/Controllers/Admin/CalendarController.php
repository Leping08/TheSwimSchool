<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\User;

class CalendarController extends Controller
{
    /**
     * @param  User  $user
     * @return User
     */
    public function show(User $user)
    {
        $events = $this->calendarEvents($user);

        return $user;
    }

    /**
     * @param  User  $user
     * @return array
     */
    public function calendarEvents(User $user)
    {

    }
}