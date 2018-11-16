<?php

// relate two resources
Route::get('relate/{parent_type}/{parent_guid}/{child_type}/{child_guid}', 'RelatableController@store');

// unrelate two resources
Route::delete('relate/{parent_guid}/{child_guid}', 'RelatableController@destroy');