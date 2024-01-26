<?php

namespace App\Http\Controllers;

use App\Cat;
use Illuminate\Support\Facades\DB;

class BirthdayController extends Controller
{
    public function index()
    {
        $cats = $this->getUpcomingBirthdays();

        return view('birthdays.index', compact('cats'));
    }

    private function getUpcomingBirthdays()
    {
        $birthdayDateRaw = "concat(YEAR(CURDATE()), '-', RIGHT(dob, 5)) as birthday_date";

        $catBirthdayQuery = Cat::whereNotNull('dob')
            ->select('cats.full_name', 'cats.dob', 'cats.id as cat_id', DB::raw($birthdayDateRaw))
            ->orderBy('birthday_date', 'asc')
            ->havingBetween('birthday_date', [today()->format('Y-m-d'), today()->addDays(60)->format('Y-m-d')]);

        $cats = $catBirthdayQuery->get();

        return $cats;
    }
}
