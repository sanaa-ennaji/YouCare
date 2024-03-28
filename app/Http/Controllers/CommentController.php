<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function createComment(Request $request)
    {
       
        $request->validate([
            'organisator_id' => 'required', 
            'content' => 'required|string|max:255', 
        ]);

        try {
            
            $comment = Comment::create([
                'user_id' => Auth::id(), 
                'organisator_id' => $request->input('organisator_id'),
                'content' => $request->input('content'),
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Comment created successfully',
                'comment' => $comment,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create comment: ' . $e->getMessage(),
            ], 500);
        }
    }
}



