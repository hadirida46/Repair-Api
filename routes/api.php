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
    use App\Http\Controllers\JobProgressController;
    use App\Http\Controllers\FeedbackController;


    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::post('/profile/update', [ProfileController::class, 'update']);
        Route::post('/logout', [ProfileController::class, 'logout']);
        Route::delete('/profile/delete', [ProfileController::class, 'destroy']);
    });
    
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/reports/assigned', [ReportController::class, 'myAssignedReports']);
        Route::post('/reports', [ReportController::class, 'create']); 
        Route::get('/reports', [ReportController::class, 'index']);  
        Route::get('/reports/{id}', [ReportController::class, 'show']);  
        Route::delete('/reports/{id}', [ReportController::class, 'destroy']); 
        Route::get('/reports/{id}/specialists',[ReportController::class, 'findSpecialists']);
        Route::get('/user/reports', [ReportController::class, 'getReports']);
        Route::post('/reports/{id}/assign', [ReportController::class, 'assignToSpecialist']);
        Route::patch('/reports/{id}/status', [ReportController::class, 'updateStatus']);
    });

    Route::middleware('auth:sanctum')->group(function () {
    Route::get('reports/{report}/progress', [JobProgressController::class, 'index']);
    Route::post('reports/{report}/progress', [JobProgressController::class, 'store']);

    });
    
    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/{receiver_id}', [ChatController::class, 'getMessages']);
    Route::get('/chat-list', [ChatController::class, 'getChatList']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/feedback', [FeedbackController::class, 'store']);
        Route::get('/feedback/specialist/{specialist_id}', [FeedbackController::class, 'getFeedbackForSpecialist']);
        Route::get('/feedback/specialist', [FeedbackController::class, 'getFeedbackBySpecialistToken']);
    });