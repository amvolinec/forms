<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('av-panel/', 'Avart\Forms\Controllers\FieldsController@index')->name('forms.index');
    Route::get('get-index/{table}', 'Avart\Forms\Controllers\FieldsController@getIndex')->name('forms.get_index');
    Route::get('av-panel/create', 'Avart\Forms\Controllers\FieldsController@create')->name('forms.create');
    Route::post('av-panel/store', 'Avart\Forms\Controllers\FieldsController@store')->name('forms.store');
    Route::get('av-panel/{route}/edit', 'Avart\Forms\Controllers\FieldsController@edit')->name('forms.edit');
    Route::put('av-panel/{route}/update', 'Avart\Forms\Controllers\FieldsController@update')->name('forms.update');
    Route::post('av-panel/get-plural', 'Avart\Forms\Controllers\FieldsController@get')->name('forms.get');
});


