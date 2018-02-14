<?php
//-------------------------------------------------------------------------
/* Start Module Routes */


Route::get('katana/modulo','ModuloController@index');
Route::get('katana/modulo/create','ModuloController@getCreate');
Route::get('katana/modulo/rebuild/{any}','ModuloController@getRebuild');
Route::get('katana/modulo/build/{any}','ModuloController@getBuild');

Route::get('katana/modulo/config/{any}','ModuloController@getConfig');
Route::get('katana/modulo/config/{any}','ModuloController@getConfig');
Route::get('katana/modulo/table/{any}','ModuloController@getTable');
Route::get('katana/modulo/sql/{any}','ModuloController@getSql');


Route::get('katana/config','ConfigController@getIndex');
Route::get('katana/config/email','ConfigController@getEmail');
Route::get('katana/config/security','ConfigController@getSecurity');
Route::get('katana/config/translation','ConfigController@getTranslation');
Route::get('katana/config/addtranslation','ConfigController@getAddtranslation');
Route::get('katana/modulo/conn/{any?}','ModuloController@getConn');
Route::get('katana/modulo/combotable','ModuloController@getCombotable');
Route::get('katana/modulo/combotablefield','ModuloController@getCombotablefield');
Route::get('katana/modulo/form/{any}','ModuloController@getForm');
Route::get('katana/modulo/subform/{any}','ModuloController@getSubform');
Route::get('katana/modulo/formdesign/{any}','ModuloController@getFormdesign');
Route::get('katana/modulo/permission/{any}','ModuloController@getPermission');
Route::get('katana/modulo/destroy/{any?}','ModuloController@getDestroy');
Route::get('katana/modulo/editform/{any?}','ModuloController@getEditform');
// POST METHOD
Route::post('katana/modulo/create','ModuloController@postCreate');
Route::post('katana/config/save','ConfigController@postSave');
Route::post('katana/modulo/saveconfig/{any}','ModuloController@postSaveconfig');
Route::post('katana/config/savetranslation','ConfigController@postSavetranslation');
Route::post('katana/modulo/savetable/{any}','ModuloController@postSavetable');
Route::post('katana/modulo/conn/{any?}','ModuloController@postConn');
Route::post('katana/modulo/savesql/{any}','ModuloController@postSavesql');
Route::post('katana/modulo/saveform/{any}','ModuloController@postSaveForm');
Route::post('katana/modulo/savepermission/{any}','ModuloController@postSavePermission');
Route::post('katana/modulo/formdesign/{any}','ModuloController@postFormdesign');
Route::post('katana/modulo/dobuild/{any}','ModuloController@postDobuild');
Route::post('katana/modulo/package','ModuloController@postPackage');
Route::post('katana/modulo/dopackage','ModuloController@postDopackage');
Route::post('katana/modulo/install','ModuloController@postInstall');
Route::post('katana/modulo/saveformfield/{any?}','ModuloController@postSaveformfield');

//-------------------------------------------------------------------------
/* Start  Menu Routes */
Route::get('katana/menu/','MenuController@getIndex');
Route::get('katana/menu/index/{any?}','MenuController@getIndex');
Route::get('katana/menu/destroy/{any?}','MenuController@getDestroy');
Route::get('katana/menu/icon','MenuController@getIcons');

Route::post('katana/menu/save','MenuController@postSave');
Route::post('katana/menu/saveorder','MenuController@postSaveorder');