<?php

namespace App\Http\Controllers;

use App\Models\Postulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostulationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function ctreatePostulation(Request $request){

        $postulation =$request->validate([
            'event_id' => ['required'],
            'skills' => ['required'],
      
        ]);
       
        $postulation['user_id'] = Auth::id();
        $postule =  Postulation::create($postulation);
        return response()->json([
            'status' => 'success',
            'message' => 'event created successfully',
            'postulation' =>  $postule,
        ], 201);
       
       

    }



    public function accepteReservation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);
   
        $postulation = postulation::findOrFail($id);
        if (Auth::id() !== $postulation->user_id) {

            return response()->json([
                'status' => 'error',
                'message' => 'not auth ',
            ], 500);
        }
    
      $postule =  $postulation->update(['status' => $request->input('status')]);
   
         return response()->json([
            'status' => 'success',
            'message' => 'event updated successfully',
            'postulation' =>  $postule,
        ]);
    }


public function showbenevolePostulation(){
        $userId = Auth::id();
        $postule = postulation::where('user_id', $userId)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'event updated successfully',
            'postulation' =>  $postule,
        ]);

}



}






