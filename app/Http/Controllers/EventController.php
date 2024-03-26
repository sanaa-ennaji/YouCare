<?php

namespace App\Http\Controllers;

use App\Models\Event;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EventController extends Controller
{
  
        public function __construct()
        {
            $this->middleware('auth:api');
        }
    
        public function index()
        {
            $event= Event::all();
            return response()->json([
                'status' => 'success',
                'event' => $event,
            ]);
        }
    
    
        public function store(Request $request)
        {
            try {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string|max:255',
                    'date' => 'required',
                    'location' => 'required',
                    'skills' => 'required',
                    'user_id' => 'required',
                ]);
        
                $event = Event::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'date' => $request->date,
                    'location' => $request->location,
                    'skills' => $request->skills,
                    'user_id' => $request->user_id,
                ]);
        
                return response()->json([
                    'status' => 'success',
                    'message' => 'event created successfully',
                    'event' => $event,
                ], 201); // HTTP status code for successful creation
        
            } catch (QueryException $e) {
                // Database exception
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
                'skills' => 'required',
                'user_id' => 'required',
            ]);
    
            $event = Event::find($id);
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->location = $request->location;
            $event->skills = $request->skills;
            $event->user_id = $request->user_id;
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
    }

