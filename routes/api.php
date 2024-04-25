<?php

use App\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->apiResource('/links', LinkController::class);

Route::get("/profile/{user}", function (\App\Models\User $user) {
    $links = $user->links()->select("short_link")->get();
    return response()->json([
        "user" => $user,
        "links" => $links
    ]);
});