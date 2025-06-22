<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a list of the user's bookings.
     */
    public function myBookings(): View
    {
        $bookings = Auth::user()->bookings()->with('travelPackage')->latest()->get();

        return view('user.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(TravelPackage $travelPackage): View
    {
        return view('user.bookings.create', compact('travelPackage'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @throws ValidationException
     */
    public function store(Request $request, TravelPackage $travelPackage): RedirectResponse
    {
        $request->validate([
            'number_of_travelers' => 'required|integer|min:1|max:' . $travelPackage->available_slots,
        ]);

        // Check if there are enough available slots
        if ($travelPackage->available_slots < $request->number_of_travelers) {
            return back()->withErrors(['number_of_travelers' => 'Not enough available slots for this booking.']);
        }

        // Create the booking
        $booking = new Booking([
            'user_id' => Auth::id(),
            'travel_package_id' => $travelPackage->id,
            'number_of_travelers' => $request->number_of_travelers,
            'status' => 'pending',
        ]);

        $booking->save();

        // Update available slots
        $travelPackage->available_slots -= $request->number_of_travelers;
        $travelPackage->save();

        return redirect()->route('bookings.my-bookings')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking): View
    {
        // Make sure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.bookings.show', compact('booking'));
    }
}
