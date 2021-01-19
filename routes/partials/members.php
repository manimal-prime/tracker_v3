<?php

Route::group(['prefix' => 'members'], function () {

    Route::post('assign-squad', 'SquadController@assignMember');
    Route::post('search/{name}', 'MemberController@search');

    Route::group(['prefix' => '{member}/'], function () {
        Route::get('confirm-reset', 'MemberController@confirmUnassign')->name('member.confirm-reset');
        Route::post('unassign', 'MemberController@unassignMember')->name('member.unassign');
        Route::post('assign-platoon', 'MemberController@assignPlatoon')->name('member.assign-platoon');

        Route::get('recruits','MemberController@recruitingHistory')->name('member.recruits');

        Route::get('remove-member', 'MemberController@remove')->name('removeMember');
        Route::get('edit-part-time', 'MemberController@editPartTime')->name('member.edit-part-time');
        Route::get('edit-handles', 'MemberController@editHandles')->name('member.edit-handles');
        Route::delete('', 'MemberController@destroy')->name('deleteMember');

        // ajax member updates
        Route::post('rank', 'MemberRankController@update')->name('member.rank.update');
        Route::post('position', 'MemberPositionController@update')->name('member.position.update');
        Route::post('division', 'MemberDivisionController@update')->name('member.division.update');

        // member leave
        Route::get('leave/{leave}/edit', 'LeaveController@edit')->name('leave.edit');
        Route::put('leave', 'LeaveController@update')->name('leave.update');
        Route::patch('leave', 'LeaveController@update');
        Route::delete('leave/{leave}', 'LeaveController@delete')->name('leave.delete');
    });


    // member notes
    Route::group(['prefix' => '{member}/notes'], function () {
        Route::post('', 'NoteController@store')->name('storeNote');
        Route::get('{note}/edit', 'NoteController@edit')->name('editNote');
        Route::post('{note}', 'NoteController@update')->name('updateNote');
        Route::patch('{note}', 'NoteController@update');
        Route::delete('{note}', 'NoteController@delete')->name('deleteNote');
    });

    Route::get('{member}-{slug?}', 'MemberController@show')->name('member');
});


Route::group(['prefix' => 'inactive-members'], function () {
    Route::get('{member}/flag-inactive', 'InactiveMemberController@create')->name('member.flag-inactive');
    Route::get('{member}/unflag-inactive', 'InactiveMemberController@destroy')->name('member.unflag-inactive');
    Route::delete('{member}', 'InactiveMemberController@removeMember')->name('member.drop-for-inactivity');
});

// initial recruiting screen
