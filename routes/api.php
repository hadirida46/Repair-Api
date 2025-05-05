    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\API\v1\ReportController;
    use App\Http\Controllers\API\v1\UserController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\JobController;
    use App\Http\Controllers\ChatController;
    use App\Http\Controllers\ChatListController;
    

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::post('/profile/update', [ProfileController::class, 'update']);
        Route::post('/logout', [ProfileController::class, 'logout']);
        Route::delete('/profile/delete', [ProfileController::class, 'destroy']);
    });
    
    Route::middleware('auth:api')->group(function () {
        Route::post('/reports', [ReportController::class, 'create']); 
        Route::get('/reports', [ReportController::class, 'index']);  
        Route::get('/reports/{id}', [ReportController::class, 'show']);  
        Route::delete('/reports/{id}', [ReportController::class, 'destroy']);  
    });

    Route::post('assign-job/{reportId}/{specialistId}', [JobController::class, 'assignJobToSpecialist']);
    
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/{sender_id}/{receiver_id}', [ChatController::class, 'getMessages']);
    Route::get('/chat-list/{user_id}', [ChatController::class, 'getChatList']);
