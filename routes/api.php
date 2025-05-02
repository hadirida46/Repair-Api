    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\API\v1\ReportController;

    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\FeedbackController;
    use App\Http\Controllers\JobProgressController;
    

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/job/{jobId}/progress', [JobProgressController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);  
        Route::post('/reports', [ReportController::class, 'store']);  
        Route::get('/reports/{report}', [ReportController::class, 'show']); 
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/feedbacks', [FeedbackController::class, 'store']);
        Route::get('/feedbacks/{feedback}', [FeedbackController::class, 'show']);
        Route::put('/feedbacks/{feedback}', [FeedbackController::class, 'update']);
        Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy']);
        Route::get('/specialists/{specialist}/feedbacks', function ($specialistId) {
            return \App\Models\Feedback::where('specialist_id', $specialistId)->get();
        });
    });