use App\Http\Controllers\Api\JemaatController;

Route::get('/jemaat-search', [JemaatController::class, 'search']);