

Route::get('/contrats', [App\Http\Controllers\ContratController::class, 'index']);
Route::post('/contrats', [App\Http\Controllers\ContratController::class, 'store']);
Route::get('/contrats/{id}', [App\Http\Controllers\ContratController::class, 'show']);
Route::post('/contrats/{id}/update', [App\Http\Controllers\ContratController::class, 'update']);
Route::post('/contrats/{id}/destroy', [App\Http\Controllers\ContratController::class, 'destroy']);
Route::post('/contrats/destroy-group', [App\Http\Controllers\ContratController::class, 'destroy_group']); 


Route::get('/garanties', [App\Http\Controllers\GarantieController::class, 'index']);
Route::post('/garanties', [App\Http\Controllers\GarantieController::class, 'store']);
Route::get('/garanties/{id}', [App\Http\Controllers\GarantieController::class, 'show']);
Route::post('/garanties/{id}/update', [App\Http\Controllers\GarantieController::class, 'update']);
Route::post('/garanties/{id}/destroy', [App\Http\Controllers\GarantieController::class, 'destroy']);
Route::post('/garanties/destroy-group', [App\Http\Controllers\GarantieController::class, 'destroy_group']); 


Route::get('/beneficiaires', [App\Http\Controllers\BeneficiaireController::class, 'index']);
Route::post('/beneficiaires', [App\Http\Controllers\BeneficiaireController::class, 'store']);
Route::get('/beneficiaires/{id}', [App\Http\Controllers\BeneficiaireController::class, 'show']);
Route::post('/beneficiaires/{id}/update', [App\Http\Controllers\BeneficiaireController::class, 'update']);
Route::post('/beneficiaires/{id}/destroy', [App\Http\Controllers\BeneficiaireController::class, 'destroy']);
Route::post('/beneficiaires/destroy-group', [App\Http\Controllers\BeneficiaireController::class, 'destroy_group']); 


Route::get('/couvertures', [App\Http\Controllers\CouvertureController::class, 'index']);
Route::post('/couvertures', [App\Http\Controllers\CouvertureController::class, 'store']);
Route::get('/couvertures/{id}', [App\Http\Controllers\CouvertureController::class, 'show']);
Route::post('/couvertures/{id}/update', [App\Http\Controllers\CouvertureController::class, 'update']);
Route::post('/couvertures/{id}/destroy', [App\Http\Controllers\CouvertureController::class, 'destroy']);
Route::post('/couvertures/destroy-group', [App\Http\Controllers\CouvertureController::class, 'destroy_group']); 


Route::get('/souscripteurs', [App\Http\Controllers\SouscripteurController::class, 'index']);
Route::post('/souscripteurs', [App\Http\Controllers\SouscripteurController::class, 'store']);
Route::get('/souscripteurs/{id}', [App\Http\Controllers\SouscripteurController::class, 'show']);
Route::post('/souscripteurs/{id}/update', [App\Http\Controllers\SouscripteurController::class, 'update']);
Route::post('/souscripteurs/{id}/destroy', [App\Http\Controllers\SouscripteurController::class, 'destroy']);
Route::post('/souscripteurs/destroy-group', [App\Http\Controllers\SouscripteurController::class, 'destroy_group']); 
