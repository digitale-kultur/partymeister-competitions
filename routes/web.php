<?php

Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Partymeister\Competitions\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation',
    ],
], function () {
    Route::group(['middleware' => ['permission']], function () {
        Route::resource('option_groups', 'OptionGroupsController');
        Route::resource('competition_types', 'CompetitionTypesController');
        Route::get('competitions/{competition}/playlist', 'Competitions\PlaylistsController@index')
             ->name('competitions.playlist.index');
        Route::post('competitions/{competition}/playlist', 'Competitions\PlaylistsController@store')
             ->name('competitions.playlist.store');
        Route::resource('competitions', 'CompetitionsController');
        Route::resource('vote_categories', 'VoteCategoriesController');
        Route::resource('entries', 'EntriesController');
        Route::get('entries/comments/{entry}', 'Entries\CommentsController@index')
             ->name('entries.comments.index');
        Route::post('entries/comments/{entry}', 'Entries\CommentsController@store')
             ->name('entries.comments.store');
        Route::get('access_keys/export_csv', 'AccessKeys\ExportController@csv')
             ->name('access_keys.export.csv');
        Route::get('access_keys/export_pdf', 'AccessKeys\ExportController@pdf')
             ->name('access_keys.export.pdf');
        Route::resource('access_keys', 'AccessKeysController');
        Route::get('competition_prizes/export_receipt', 'CompetitionPrizes\ExportController@receipt')
             ->name('competition_prizes.export.receipt');
        Route::get('competition_prizes/export_prizesheet', 'CompetitionPrizes\ExportController@prizesheet')
             ->name('competition_prizes.export.prizesheet');
	    Route::get('competition_prizes/export_ascii', 'CompetitionPrizes\ExportController@ascii')->name('competition_prizes.export.ascii');
        Route::get('votes/export/csv', 'Votes\ExportController@csv')
             ->name('votes.export.csv');
        Route::resource('competition_prizes', 'CompetitionPrizesController');
        Route::get('votes/playlist', 'Votes\PlaylistsController@index')
             ->name('votes.playlist.index');
        Route::post('votes/playlist', 'Votes\PlaylistsController@store')
             ->name('votes.playlist.store');
        Route::resource('votes', 'VotesController');
    });
});

// FIXME: build this with an actual controller so this doesn't break route caching
//Route::get('results', function () {
//    $results = \Partymeister\Competitions\Services\VoteService::getAllVotesByRank();
//
//    foreach ($results as $competition) {
//        echo $competition['name'] . "\r\n";
//        foreach ($competition['entries'] as $entry) {
//            echo $entry['points'] . "\t" . $entry['title'] . "\t" . $entry['author'] . "\r\n";
//        }
//        echo "\r\n";
//    }
//});
//
//Route::get('results-special', function () {
//    $results = \Partymeister\Competitions\Services\VoteService::getAllSpecialVotesByRank();
//
//    foreach ($results as $entry) {
//        echo $entry['special_votes'] . "\t" . $entry['title'] . "\t" . $entry['author'] . "\r\n";
//    }
//});

// Only add the route group if you don't already have one for the given namespace
Route::group([
    'as'         => 'component.',
    'prefix'     => 'component',
    'namespace'  => 'Partymeister\Competitions\Http\Controllers\Backend\Component',
    'middleware' => [
        'web',
    ],
], function () {
    // You only need this part if you already have a component group for the given namespace
    Route::get('votings', 'ComponentVotingsController@create')
         ->name('votings.create');
    Route::post('votings', 'ComponentVotingsController@store')
         ->name('votings.store');
    Route::get('votings/{component_voting}', 'ComponentVotingsController@edit')
         ->name('votings.edit');
    Route::patch('votings/{component_voting}', 'ComponentVotingsController@update')
         ->name('votings.update');

    Route::get('entries', 'ComponentEntriesController@create')
         ->name('entries.create');
    Route::post('entries', 'ComponentEntriesController@store')
         ->name('entries.store');
    Route::get('entries/{component_entry}', 'ComponentEntriesController@edit')
         ->name('entries.edit');
    Route::patch('entries/{component_entry}', 'ComponentEntriesController@update')
         ->name('entries.update');

    Route::get('entry-screenshots', 'ComponentEntryScreenshotsController@create')
         ->name('entry-screenshots.create');
    Route::post('entry-screenshots', 'ComponentEntryScreenshotsController@store')
         ->name('entry-screenshots.store');
    Route::get('entry-screenshots/{component_entry_screenshot}', 'ComponentEntryScreenshotsController@edit')
         ->name('entry-screenshots.edit');
    Route::patch('entry-screenshots/{component_entry_screenshot}', 'ComponentEntryScreenshotsController@update')
         ->name('entry-screenshots.update');

    Route::get('entry-uploads', 'ComponentEntryUploadsController@create')
         ->name('entry-uploads.create');
    Route::post('entry-uploads', 'ComponentEntryUploadsController@store')
         ->name('entry-uploads.store');
    Route::get('entry-uploads/{component_entry_upload}', 'ComponentEntryUploadsController@edit')
         ->name('entry-uploads.edit');
    Route::patch('entry-uploads/{component_entry_upload}', 'ComponentEntryUploadsController@update')
         ->name('entry-uploads.update');
});
