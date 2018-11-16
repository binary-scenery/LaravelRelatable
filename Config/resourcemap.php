<?php

/**
 *
 * This file sets the related data/model files.
 * Setting this map allows us to decouple many-to-many database relationships from the app file structure
 *
 * More information on custom polymorphic types here:
 * https://laravel.com/docs/5.7/eloquent-relationships#many-to-many
 *
 * see : App\Services\AppServiceProvider
 * see : App\Http\Controllers\Authorised\Relatable
 */

return [

    // Register the config in the AppServiceProvider:
    //Relation::morphMap(config('resourcemap'));

    // replace with your models and paths:
    'assets'    => 'App\Models\Asset',
    'posts'     => 'App\Models\Post',
    'tags'      => 'App\Models\Tag',

];