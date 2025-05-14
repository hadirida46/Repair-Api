<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'specialist_id' => 'required|exists:users,id',
            'comment' => 'required|string|max:1000', 
        ]);

        // Create a new feedback entry
        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'specialist_id' => $request->specialist_id,
            'comment' => $request->comment, 
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully.',
            'feedback' => $feedback,
        ], 201);
    }

    /**
     * Get all feedback for a specific specialist.
     */
    public function getFeedbackForSpecialist($specialist_id)
    {
        $feedbacks = Feedback::where('specialist_id', $specialist_id)->get();

        if ($feedbacks->isEmpty()) {
            return response()->json([
                'message' => 'No feedback found for this specialist.',
            ], 404);
        }

        return response()->json([
            'feedbacks' => $feedbacks,
        ]);
    }
    public function getFeedbackBySpecialistToken(Request $request)
    {
        $specialist = Auth::user();

        if ($specialist->role !== 'specialist') {
            return response()->json([
                'message' => 'You are not authorized to view this feedback.',
            ], 403);
        }

        $feedbacks = Feedback::where('specialist_id', $specialist->id)->get();

        if ($feedbacks->isEmpty()) {
            return response()->json([
                'message' => 'No feedback found for this specialist.',
            ], 404);
        }

        return response()->json([
            'feedbacks' => $feedbacks,
        ]);
    }
}
