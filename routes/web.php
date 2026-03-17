<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

////////////////////
//////////////////////////
//Directeur
Route::get('/students/profile', function (Request $request) {
    $currentTab = $request->query('tab', 'notes');

    return view('students.profile', [
        'tab' => $currentTab,
    ]);
});
