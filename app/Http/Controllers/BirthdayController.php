<?php

namespace App\Http\Controllers;

use App\Cat;
use Illuminate\Support\Facades\DB;

class BirthdayController extends Controller
{
    public function index()
    {
        $cats = $this->getUpcomingBirthdays(date("Y"), date("m"), date("d"));

        return view('birthdays.index', compact('cats'));
    }

    public function date(int $year = 0, int $month = 0, int $day = 0)
    {
        if ($year == 0) {
            $year = date("Y");
        }
        if ($month == 0) {
            $month = date("m");
        }
        if ($day == 0) {
            $day = date("d");
        }
        $cats = $this->getUpcomingBirthdays($year, $month, $day);

        return view('birthdays.index', compact('cats'));
    }

    private function getUpcomingBirthdays(int $year, int $month, int $day)
    {
        //$birthdayDateRaw = "concat(YEAR(CURDATE()), '-', RIGHT(dob, 5)) as birthday_date";
        if ($year > 1000 && $month <= 12 && $day <= 31 && $month > 0 && $day > 0) {
            $birthdayDateRaw = "concat(" . $year . ", '-', " . $month . ", '-', " . $day . ") as birthday_date";
    
            $catBirthdayQuery = Cat::whereNotNull('dob')
                ->select('cats.full_name', 'cats.dob', 'cats.id as cat_id', DB::raw($birthdayDateRaw))
                ->orderBy('birthday_date', 'asc')
                ->havingBetween('birthday_date', [today()->format('Y-m-d'), today()->addDays(60)->format('Y-m-d')]);
    
            $cats = $catBirthdayQuery->get();
    
            return $cats;
        } else {
            return [];
        }
    }
}
