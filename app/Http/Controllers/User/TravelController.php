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
        $travelPackages = TravelPackage::visible()->get();

        return view('user.travel-packages.index', compact('travelPackages'));
    }

    /**
     * Display the specified travel package.
     */
    public function show(TravelPackage $travelPackage): View
    {
        // If the package is not visible, redirect back with an error
        if (!$travelPackage->is_visible) {
            return redirect()->route('travel-packages.index')
                ->with('error', 'The requested travel package is not available.');
        }

        return view('user.travel-packages.show', compact('travelPackage'));
    }
}
