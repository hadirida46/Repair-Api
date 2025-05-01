    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ReportController;
    use Illuminate\Support\Facades\DB;

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);  
        Route::post('/reports', [ReportController::class, 'store']);  
        Route::get('/reports/{report}', [ReportController::class, 'show']); 
    });