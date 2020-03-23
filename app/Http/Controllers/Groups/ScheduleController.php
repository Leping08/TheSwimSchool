<?php


namespace App\Http\Controllers\Groups;


use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('groups.schedule');
    }
}