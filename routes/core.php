<?php
/**
 * Created by PhpStorm.
 * User: Ricardo
 * Date: 02/02/2018
 * Time: 16:59
 */

//-------------------------------------------------------------------------
/* Start Users Routes */
// -- Get Method --
Route::resource('core/usuarios','UsersController');
Route::resource('core/grupos','GruposControlador');
