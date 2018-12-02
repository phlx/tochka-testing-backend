<?php

use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

router()->group(['prefix' => '/api/v1'], function () {
    router()->get('/regenerate[/{count}]',
        ApiController::class . '@regenerate');

    router()->get('/task/pages/{limit:[1-9]\d*}',
        ApiController::class . '@pages');

    router()->get('/task/limit/{limit:[1-9]\d*}/page/{page:[1-9]\d*}',
        ApiController::class . '@paginated');

    router()->get('/task',
        ApiController::class . '@all');

    router()->get('/task/{id}',
        ApiController::class . '@one');

    router()->get('/filter/{filter}',
        ApiController::class . '@filter');
});
