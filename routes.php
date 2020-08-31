<?php

Route::post('/suresoftware/powerblog/quill', 'SureSoftware\PowerBlog\Controllers\QuillController@storeDelta');

Route::group(['prefix' => 'api'], function() {
    Route::get('/suresoftware/powerblog/get', 'SureSoftware\PowerBlog\Controllers\BlogController@getPublished');
});
