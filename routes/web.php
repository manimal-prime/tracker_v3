<?php

use Illuminate\Support\Facades\Auth;

//Auth::onceUsingId(4);

Auth::routes();

Route::get('/home', 'AppController@index')->name('home');
Route::get('/', 'AppController@index')->name('index');

Route::get('search/members/{name}', 'MemberController@search')->name('memberSearch');
Route::post('search-leader/', 'MemberController@searchAutoComplete')->name('memberSearchAjax');
Route::post('search-platoon', 'RecruitingController@searchPlatoonForSquads')->name('getPlatoonSquads');
Route::post('search-division-threads', 'RecruitingController@doThreadCheck')->name('divisionThreadCheck');
Route::post('search-division-threads', 'RecruitingController@doThreadCheck')->name('divisionThreadCheck');


// Members endpoints
Route::group(['prefix' => 'members'], function () {
    Route::get('{member}', 'MemberController@show')->name('member');
    Route::get('{member}/edit', 'MemberController@edit')->name('editMember');
    Route::post('search/{name}', 'MemberController@search');
    Route::delete('{member}', 'MemberController@destroy')->name('deleteMember');

    // member notes
    Route::group(['prefix' => '{member}/notes'], function () {
        Route::post('', 'NoteController@store')->name('storeNote');
        Route::get('{note}/edit', 'NoteController@edit')->name('editNote');
        Route::post('{note}', 'NoteController@update')->name('updateNote');
        Route::patch('{note}', 'NoteController@update');
        Route::delete('{note}', 'NoteController@delete')->name('deleteNote');
    });
});

Route::group(['prefix' => 'help'], function () {
    Route::get('/', 'HelpController@index')->name('help');
});

Route::group(['prefix' => 'statistics'], function () {
    Route::get('/', 'ClanStatisticsController@show')->name('statistics');
});

// initial recruiting screen
Route::get('recruit', 'RecruitingController@index')->name('recruiting.initial');

/**
 * Division endpoints
 */
Route::group(['prefix' => 'divisions/'], function () {

    /**
     * divisions
     */
    Route::get('{division}', 'DivisionController@show')->name('division');
    Route::get('{division}/edit', 'DivisionController@edit')->name('editDivision');
    Route::get('{division}/census', 'DivisionController@census')->name('division.census');

    Route::post('', 'DivisionController@store')->name('storeDivision');
    Route::put('{division}', 'DivisionController@update')->name('updateDivision');
    Route::patch('{division}', 'DivisionController@update');
    Route::delete('{division}', 'DivisionController@destroy')->name('deleteDivision');

    /**
     * Recruiting Process
     */
    Route::group(['prefix' => '{division}/recruit'], function () {
        Route::get('step-one', 'RecruitingController@stepOne')->name('recruiting.stepOne');
        Route::post('step-two', 'RecruitingController@stepTwo')->name('recruiting.stepTwo');
        Route::post('step-three', 'RecruitingController@stepThree')->name('recruiting.stepThree');
        Route::post('step-four', 'RecruitingController@stepFour')->name('recruiting.stepFour');
        Route::get('step-five', 'RecruitingController@stepFive')->name('recruiting.stepFive');
    });


    /**
     * platoons
     */
    Route::group(['prefix' => '{division}/platoons/'], function () {

        Route::get('/create', 'PlatoonController@create')->name('createPlatoon');
        Route::get('{platoon}', 'PlatoonController@show')->name('platoon');
        Route::get('{platoon}/edit', 'PlatoonController@edit')->name('editPlatoon');
        Route::get('{platoon}/squads', 'PlatoonController@squads')->name('platoonSquads');

        Route::post('', 'PlatoonController@store')->name('savePlatoon');
        Route::put('{platoon}', 'PlatoonController@update')->name('updatePlatoon');
        Route::patch('{platoon}', 'PlatoonController@update');
        Route::delete('{platoon}', 'PlatoonController@destroy')->name('deletePlatoon');


        /**
         * squads
         */
        Route::group(['prefix' => '{platoon}/squads/'], function () {
            Route::get('/create', 'SquadController@create')->name('createSquad');
            Route::get('{squad}/edit', 'SquadController@edit')->name('editSquad');

            Route::post('', 'SquadController@store')->name('storeSquad');
            Route::put('{squad}', 'SquadController@update')->name('updateSquad');
            Route::patch('{squad}', 'SquadController@update');
            Route::delete('{squad}', 'SquadController@destroy')->name('deleteSquad');
        });

    });


    /**
     * Misc Routes
     */
    Route::get('{division}/activity', 'ActivitiesController@byDivision')->name('divisionActivity');
    Route::get('{division}/part-timers', 'DivisionController@partTime')->name('partTimers');
    Route::get('{division}/statistics', 'DivisionController@statistics')->name('divisionStats');
});


// logging activity
Route::get('users/{username}/activity', 'ActivitiesController@byUser');
Route::get('developers', 'DeveloperController@index')->name('developer');


/**
 * Slack handler
 */
Route::post('slack', [
    'as' => 'slack.commands',
    'uses' => 'SlackController@index',
])->middleware('slack');


/**
 * Admin Routes
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin');

    Route::group(['prefix' => 'divisions'], function () {
        Route::post('', 'Admin\DivisionController@store')->name('adminStoreDivision');
        Route::get('{division}/edit', 'Admin\DivisionController@edit')->name('adminEditDivision');
        Route::get('create', 'Admin\DivisionController@create')->name('adminCreateDivision');
        Route::put('{division}', 'Admin\DivisionController@update')->name('adminUpdateDivision');
        Route::patch('{division}', 'Admin\DivisionController@update');
        Route::delete('{division}', 'Admin\DivisionController@destroy')->name('adminDeleteDivision');
    });

    // edit handle
    Route::get('handles/{handle}/edit', 'Admin\HandleController@edit')->name('adminEditHandle');
    Route::put('handles/{handle}', 'Admin\HandleController@update')->name('adminUpdateHandle');
    Route::patch('handles/{handle}', 'Admin\HandleController@update');
});

/*
Route::get('all', function() {
    $division = \App\Division::find(4);
    $members = $division->activeMembers;
    $csv = Writer::createFromFileObject(new \SplTempFileObject());

    foreach ($members as $person) {
        $csv->insertOne([$person->name, $person->last_forum_login->format('Y-m-d')]);
    }

    $csv->output('all.csv');
});
*/

/**
 * AOD Forum sync endpoint
 */
/*
Route::group(['prefix' => 'AOD', 'middleware' => 'throttle:15'], function () {
    Route::get('/division-data/{division_name}', function ($division_name) {
        $info = new \App\AOD\MemberSync\GetDivisionInfo($division_name);

        return response()->json($info);
    });
});
*/
