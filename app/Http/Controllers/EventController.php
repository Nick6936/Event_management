<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('category')->get(); 

        return response()->json([
            'message' => 'List of Events',
            'events' => $events
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
                'location' => 'required|string',
                'category_id' => 'required|exists:categories,id', // Ensure category_id exists
            ]);

            $event = Event::create($validatedData); // Include category_id in the mass assignment

            return response()->json([
                'message' => 'New Event Added',
                'event' => $event->load('category') // Eager load the category
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error adding event: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to add new event',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json([
            'message' => 'Fetched Event',
            'event' => $event->load('category') 
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id', 
        ]);

        $event->update($validatedData);

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event->load('category') 
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully',
            'event' => $event
        ], 200);
    }
}
