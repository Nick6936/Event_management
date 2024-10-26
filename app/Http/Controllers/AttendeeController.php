<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendees = Attendee::with('event')->get();

        return response()->json([
            'message' => 'List of Attendees',
            'attendees' => $attendees,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:attendees,email',
                'event_id' => 'required|exists:events,id',
            ]);

            $attendee = Attendee::create($validatedData);

            return response()->json([
                'message' => 'New Attendee Added',
                'attendee' => $attendee,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error adding attendee: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to add new attendee',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendee $attendee)
    {
        return response()->json([
            'message' => 'Fetched Attendee',
            'attendee' => $attendee,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendee $attendee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:attendees,email,' . $attendee->id,
            'event_id' => 'required|exists:events,id',
        ]);

        $attendee->update($validatedData);

        return response()->json([
            'message' => 'Attendee updated successfully',
            'attendee' => $attendee,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendee $attendee)
    {
        $attendee->delete();

        return response()->json([
            'message' => 'Attendee deleted successfully',
            'attendee' => $attendee,
        ], 200);
    }
}
