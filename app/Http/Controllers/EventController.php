<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $event = Event::all();
        return response()->json([
            'status' => 'success',
            'event' => $event,
        ]);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'date' => 'required',
                'location' => 'required',
                'type' => 'required',
                'competences' =>'required',
            ]);

            $user_id = Auth::id();

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'location' => $request->location,
                'type' => $request->type,
                'competences' => $request->competences,
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'event created successfully',
                'event' => $event,
            ], 201);

        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function show($id)
    {
        $event = Event::find($id);
        return response()->json([
            'status' => 'success',
            'event' => $event,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date' => 'required',
            'location' => 'required',
            'type' => 'required',
            'competences' => 'required',
        ]);

        $user_id = Auth::id();
        $event = Event::find($id);
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->location = $request->location;
        $event->type = $request->type;
        $event->competences = $request->competences;
        $event->user_id = $user_id;
        $event->save();

        return response()->json([
            'status' => 'success',
            'message' => 'event updated successfully',
            'event' => $event,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'event deleted successfully',
            'event' => $event,
        ]);
    }

    public function displayEventOfganisator()
    {
        $userId = Auth::id();
        $event = Event::where('user_id', $userId)->get();
        return response()->json([
            'status' => 'success',
            'event' => $event,
        ]);
    }
    public function postulationsOfEvent()
    {
        $userId = Auth::id();
        $postulations = Event::where('user_id', $userId)->with('postulations')->get()->pluck('postulations')->flatten();
        return response()->json([
            'status' => 'success',
            'event' => $postulations
            ,
        ]);
    }

    public function search(Request $request)
    {

        $request->validate([
            'location' => 'string|nullable',
            'type' => 'string|nullable',
        ]);
        $location = $request->input('location');
        $type = $request->input('type');
        $query = Event::query();

        if ($location) {
            $query->where('location', 'like', "%$location%");
        }
        if ($type) {
            $query->where('type', $type);
        }
        $events = $query->get();

        return response()->json([
            'status' => 'success',
            'events' => $events,
        ]);
    }


}



