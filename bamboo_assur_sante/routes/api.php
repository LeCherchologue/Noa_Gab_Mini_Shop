

Route::get('/tests', [App\Http\Controllers\TestController::class, 'index']);
Route::post('/tests', [App\Http\Controllers\TestController::class, 'store']);
Route::get('/tests/{id}', [App\Http\Controllers\TestController::class, 'show']);
Route::post('/tests/{id}/update', [App\Http\Controllers\TestController::class, 'update']);
Route::post('/tests/{id}/destroy', [App\Http\Controllers\TestController::class, 'destroy']);
Route::post('/tests/destroy-group', [App\Http\Controllers\TestController::class, 'destroy_group']); 


Route::get('/souscripteurs', [App\Http\Controllers\SouscripteurController::class, 'index']);
Route::post('/souscripteurs', [App\Http\Controllers\SouscripteurController::class, 'store']);
Route::get('/souscripteurs/{id}', [App\Http\Controllers\SouscripteurController::class, 'show']);
Route::post('/souscripteurs/{id}/update', [App\Http\Controllers\SouscripteurController::class, 'update']);
Route::post('/souscripteurs/{id}/destroy', [App\Http\Controllers\SouscripteurController::class, 'destroy']);
Route::post('/souscripteurs/destroy-group', [App\Http\Controllers\SouscripteurController::class, 'destroy_group']); 


Route::get('/couvertures', [App\Http\Controllers\CouvertureController::class, 'index']);
Route::post('/couvertures', [App\Http\Controllers\CouvertureController::class, 'store']);
Route::get('/couvertures/{id}', [App\Http\Controllers\CouvertureController::class, 'show']);
Route::post('/couvertures/{id}/update', [App\Http\Controllers\CouvertureController::class, 'update']);
Route::post('/couvertures/{id}/destroy', [App\Http\Controllers\CouvertureController::class, 'destroy']);
Route::post('/couvertures/destroy-group', [App\Http\Controllers\CouvertureController::class, 'destroy_group']); 


Route::get('/beneficiaires', [App\Http\Controllers\BeneficiaireController::class, 'index']);
Route::post('/beneficiaires', [App\Http\Controllers\BeneficiaireController::class, 'store']);
Route::get('/beneficiaires/{id}', [App\Http\Controllers\BeneficiaireController::class, 'show']);
Route::post('/beneficiaires/{id}/update', [App\Http\Controllers\BeneficiaireController::class, 'update']);
Route::post('/beneficiaires/{id}/destroy', [App\Http\Controllers\BeneficiaireController::class, 'destroy']);
Route::post('/beneficiaires/destroy-group', [App\Http\Controllers\BeneficiaireController::class, 'destroy_group']); 


Route::get('/garanties', [App\Http\Controllers\GarantieController::class, 'index']);
Route::post('/garanties', [App\Http\Controllers\GarantieController::class, 'store']);
Route::get('/garanties/{id}', [App\Http\Controllers\GarantieController::class, 'show']);
Route::post('/garanties/{id}/update', [App\Http\Controllers\GarantieController::class, 'update']);
Route::post('/garanties/{id}/destroy', [App\Http\Controllers\GarantieController::class, 'destroy']);
Route::post('/garanties/destroy-group', [App\Http\Controllers\GarantieController::class, 'destroy_group']); 


Route::get('/contrats', [App\Http\Controllers\ContratController::class, 'index']);
Route::post('/contrats', [App\Http\Controllers\ContratController::class, 'store']);
Route::get('/contrats/{id}', [App\Http\Controllers\ContratController::class, 'show']);
Route::post('/contrats/{id}/update', [App\Http\Controllers\ContratController::class, 'update']);
Route::post('/contrats/{id}/destroy', [App\Http\Controllers\ContratController::class, 'destroy']);
Route::post('/contrats/destroy-group', [App\Http\Controllers\ContratController::class, 'destroy_group']); 


Route::get('/paiements', [App\Http\Controllers\PaiementController::class, 'index']);
Route::post('/paiements', [App\Http\Controllers\PaiementController::class, 'store']);
Route::get('/paiements/{id}', [App\Http\Controllers\PaiementController::class, 'show']);
Route::post('/paiements/{id}/update', [App\Http\Controllers\PaiementController::class, 'update']);
Route::post('/paiements/{id}/destroy', [App\Http\Controllers\PaiementController::class, 'destroy']);
Route::post('/paiements/destroy-group', [App\Http\Controllers\PaiementController::class, 'destroy_group']); 


Route::get('/echeances', [App\Http\Controllers\EcheanceController::class, 'index']);
Route::post('/echeances', [App\Http\Controllers\EcheanceController::class, 'store']);
Route::get('/echeances/{id}', [App\Http\Controllers\EcheanceController::class, 'show']);
Route::post('/echeances/{id}/update', [App\Http\Controllers\EcheanceController::class, 'update']);
Route::post('/echeances/{id}/destroy', [App\Http\Controllers\EcheanceController::class, 'destroy']);
Route::post('/echeances/destroy-group', [App\Http\Controllers\EcheanceController::class, 'destroy_group']); 


Route::get('/demande_remboursements', [App\Http\Controllers\DemandeRemboursementController::class, 'index']);
Route::post('/demande_remboursements', [App\Http\Controllers\DemandeRemboursementController::class, 'store']);
Route::get('/demande_remboursements/{id}', [App\Http\Controllers\DemandeRemboursementController::class, 'show']);
Route::post('/demande_remboursements/{id}/update', [App\Http\Controllers\DemandeRemboursementController::class, 'update']);
Route::post('/demande_remboursements/{id}/destroy', [App\Http\Controllers\DemandeRemboursementController::class, 'destroy']);
Route::post('/demande_remboursements/destroy-group', [App\Http\Controllers\DemandeRemboursementController::class, 'destroy_group']); 


Route::get('/frais_medicals', [App\Http\Controllers\FraisMedicalController::class, 'index']);
Route::post('/frais_medicals', [App\Http\Controllers\FraisMedicalController::class, 'store']);
Route::get('/frais_medicals/{id}', [App\Http\Controllers\FraisMedicalController::class, 'show']);
Route::post('/frais_medicals/{id}/update', [App\Http\Controllers\FraisMedicalController::class, 'update']);
Route::post('/frais_medicals/{id}/destroy', [App\Http\Controllers\FraisMedicalController::class, 'destroy']);
Route::post('/frais_medicals/destroy-group', [App\Http\Controllers\FraisMedicalController::class, 'destroy_group']); 


Route::get('/regle_remboursements', [App\Http\Controllers\RegleRemboursementController::class, 'index']);
Route::post('/regle_remboursements', [App\Http\Controllers\RegleRemboursementController::class, 'store']);
Route::get('/regle_remboursements/{id}', [App\Http\Controllers\RegleRemboursementController::class, 'show']);
Route::post('/regle_remboursements/{id}/update', [App\Http\Controllers\RegleRemboursementController::class, 'update']);
Route::post('/regle_remboursements/{id}/destroy', [App\Http\Controllers\RegleRemboursementController::class, 'destroy']);
Route::post('/regle_remboursements/destroy-group', [App\Http\Controllers\RegleRemboursementController::class, 'destroy_group']); 
