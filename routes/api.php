<?php

use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\EmpleadoController;
use App\Http\Controllers\API\FacturaController;
use App\Http\Controllers\API\OpcionController;
use App\Http\Controllers\API\PerfilController;
use App\Http\Controllers\API\ProductoController;
use App\Models\API\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group(['prefix'=>'user'],function(){
    Route::get("getUsers/{limit}/{offset}",[UsuarioController::class,'get_users']);

    Route::get("getAllUsers",[UsuarioController::class,'get_all_users']);

    Route::post("saveUser", [UsuarioController::class,'save_user']);

    Route::post("getUserByEmail",[UsuarioController::class,'get_user_by_email']);
   
    Route::get("getUserByID/{id}",[UsuarioController::class,'get_user_by_id']);

    Route::post("changePassword", [UsuarioController::class,'change_password']);

});

Route::group(['prefix'=>'employee'],function(){

    Route::get("getEmployeeByCod/{id}",[EmpleadoController::class,'get_employee']);

});

Route::group(['prefix'=>'profile'],function(){

    Route::get("getProfiles/{limit}/{offset}",[PerfilController::class,'get_profiles']);
    Route::get("getAllProfiles",[PerfilController::class,'get_all_profiles']);
    Route::get("getUserProfile/{profile}",[PerfilController::class,'get_users_profile']);
    Route::post("saveProfile",[PerfilController::class,'save_profiles']);
    Route::post("assignProfile",[PerfilController::class,'assign_profile']);
    Route::delete("deleteProfile/{codigo}",[PerfilController::class,'delete_profile']);
    Route::delete("desassignProfile/{perfil}/{codigo}",[PerfilController::class,'desassign_profile']);

    Route::get("getProfileUser/{email}",[PerfilController::class,'get_user_profile']);
});

Route::group(['prefix'=>'options'],function(){

    Route::get("getOptions/{limit}/{offset}",[OpcionController::class,'get_options']);
    Route::post("saveOption/{limit}/{offset}",[OpcionController::class,'save_option']);
    Route::delete("deleteOption/{codigo}/{limit}/{offset}",[OpcionController::class,'delete_option']);
    Route::get("getOptionsByProfile/{profile}",[OpcionController::class,'get_options_by_profile']);
    Route::get("getAllOptions",[OpcionController::class,'get_all_options']);

    Route::get("assignOption/{profile}/{option}",[OpcionController::class,'assign_option']);
    Route::delete("desassignOption/{profile}/{option}",[OpcionController::class,'desassign_option']);

});

Route::group(['prefix'=>'products'],function(){

    Route::get("getProducts/{limit}/{offset}",[ProductoController::class,'get_products']);
    Route::get("getProductsByName/{search}",[ProductoController::class,'get_product_by_name']);
    Route::post("saveProduct/{limit}/{offset}",[ProductoController::class,'save_product']);
    Route::delete("deleteProduct/{id}/{limit}/{offset}",[ProductoController::class,'delete_product']);
});

Route::group(['prefix'=>'factura'],function(){
    Route::post("newFactura",[FacturaController::class,'new_factura']);
    Route::get("idFactura",[FacturaController::class,'last_id_factura']);
    Route::get("getFacturas/{limit}/{offset}",[FacturaController::class,'get_facturas']);
    Route::get("getFactura/{id}",[FacturaController::class,'get_factura']);
});
