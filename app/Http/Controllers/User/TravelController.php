<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelController extends Controller
{
    /**
     * Display a listing of the travel packages.
     */
    public function index(): View
    {
        $travelPackages = TravelPackage::all();

        return view('user.travel-packages.index', compact('travelPackages'));
    }

    /**
     * Display the specified travel package.
     */
    public function show(TravelPackage $travelPackage): View
    {
        return view('user.travel-packages.show', compact('travelPackage'));
    }
}
