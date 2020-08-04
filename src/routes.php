<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('av-panel/', 'Avart\Forms\FieldsController@index')->name('forms.index');
    Route::get('get-index/{table}', 'Avart\Forms\FieldsController@getIndex')->name('forms.get_index');
    Route::get('av-panel/create', 'Avart\Forms\FieldsController@create')->name('forms.create');
    Route::post('av-panel/store', 'Avart\Forms\FieldsController@store')->name('forms.store');
    Route::get('av-panel/{route}/edit', 'Avart\Forms\FieldsController@edit')->name('forms.edit');
    Route::put('av-panel/{route}/update', 'Avart\Forms\FieldsController@update')->name('forms.update');
});


