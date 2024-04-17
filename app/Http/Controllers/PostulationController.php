<?php

namespace App\Http\Controllers;

use App\Models\Postulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class PostulationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
 * @OA\Post(
 *     path="/api/Postulation",
 *     summary="Create a postulation for an event",
 *     tags={"Postulations"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"event_id", "skills"},
 *             @OA\Property(property="event_id", type="integer", example="1"),
 *             @OA\Property(property="skills", type="string", example="Skill 1, Skill 2")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Postulation created successfully",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *     )
 * )
 */
    public function createPostulation (Request $request){

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

/**
 * @OA\Put(
 *     path="/api/accepte",
 *     summary="Accept or reject a postulation",
 *     tags={"Postulations"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the postulation to accept or reject",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(property="status", type="string", enum={"accepted", "rejected"}, example="accepted")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Postulation updated successfully",
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Postulation not found",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *     )
 * )
 */

    public function acceptePostulation(Request $request, $id)
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

/**
 * @OA\Get(
 *     path="/api/benevole/postulation",
 *     summary="Get postulations of the authenticated user",
 *     tags={"Postulations"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of postulations of the authenticated user",
 *         )
 *     )
 * )
 */


 
 public function postulationsOfEvent()
 {
     try {
         $userId = auth()->user()->id;
 
         $postulations = Postulation::whereHas('event', fn($q) => $q->where('user_id', $userId))
             ->with('user')
             ->get();
 
         return response()->json([
             'status' => 'success',
             'postulations' => $postulations,
         ], 200);
     } catch (\Exception $e) {
         return response()->json([
             'status' => 'error',
             'message' => $e->getMessage(),
         ], 500);
     }
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






