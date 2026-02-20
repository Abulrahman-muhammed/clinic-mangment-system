<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Major;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        $majors = Major::orderBy('id', 'desc')
        ->limit(4)
        ->get();

        $doctors = Doctor::with('major')
        ->orderBy('id', 'desc')
        ->limit(4)
        ->get();

        $services = Service::orderBy('id', 'desc')
        ->limit(4)
        ->get();

        return view('front.pages.home', compact('majors', 'doctors', 'services'));
    }

    // about us page
    public function about() {
        return view('front.pages.about');
    }
}
