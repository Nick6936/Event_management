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
        $events = Event::with('category')->get(); // Eager load category

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
                'title' => 'string',
                'description' => 'string',
                'date' => 'date',
                'location' => 'string',
                'category_id' => 'exists:categories,id', // Ensure category_id exists
            ]);

            $event = Event::create($validatedData); // Include category_id in the mass assignment

            return response()->json([
                'message' => 'New Event Added',
                'event' => $event->load('category'),
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
        try {
            $validatedData = $request->validate([
                'title' => 'string',
                'description' => 'string',
                'date' => 'date',
                'location' => 'string',
                'category_id' => 'exists:categories,id',
            ]);
    

            $event->update(array_filter($validatedData)); // array_filter to remove null values
    
            return response()->json([
                'message' => 'Event updated successfully',
                'event' => $event->load('category')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating event: ' . $e->getMessage());
    
            return response()->json([
                'error' => 'Failed to update event',
                'message' => $e->getMessage()
            ], 500);
        }
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
