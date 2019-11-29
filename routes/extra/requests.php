<?php

use Illuminate\Support\Facades\Mail;

Route::get('requests-count.png', function () {
    header('Content-Type: image/png');
    date_default_timezone_set('America/New_York');

    $tinyfont = public_path('fonts/copy0855.ttf');
    $tinyboldfont = public_path('fonts/copy0866.ttf');
    $bigfont = public_path('fonts/din-black.otf');

    $context = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];

    $response = file_get_contents(
        asset('images/dynamic-images/bgs/pending-requests.jpg'),
        false,
        stream_context_create($context)
    );

    $im = imagecreatefromstring($response);
    $orange = imagecolorallocate($im, 255, 108, 0);
    $red = imagecolorallocate($im, 153, 26, 34);

    $requestsCount = \App\MemberRequest::pending()->pastGracePeriod()->count();
    $errors = \App\MemberRequest::errors()->count();

    // calculate X for number of requests
    $dimensionsRequests = imagettfbbox(20, 0, $bigfont, $requestsCount);
    $textWidthRequests = abs($dimensionsRequests[4] - $dimensionsRequests[0]);
    $xRequests = imagesx($im) - $textWidthRequests;

    imagettftext($im, 20, 0, $xRequests - 10, 25, $orange, $bigfont, $requestsCount);

    if ($errors > 0) {
        imagettftext($im, 6, 0, $x - 50, 20, $red, $tinyfont, "({$errors} ERR)");
    }

    imagepng($im);
    imagedestroy($im);
});

Route::get('tickets-count.png', function () {
    header('Content-Type: image/png');
    date_default_timezone_set('America/New_York');

    $tinyfont = public_path('fonts/copy0855.ttf');
    $tinyboldfont = public_path('fonts/copy0866.ttf');
    $bigfont = public_path('fonts/din-black.otf');

    $context = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];

    $response = file_get_contents(
        asset('images/dynamic-images/bgs/pending-tickets.jpg'),
        false,
        stream_context_create($context)
    );

    $im = imagecreatefromstring($response);
    $orange = imagecolorallocate($im, 255, 108, 0);

    $ticketsCount = \App\Ticket::open()->count();

    // calculate X for number of tickets
    $dimensionsTickets = imagettfbbox(20, 0, $bigfont, $ticketsCount);
    $textWidthTickets = abs($dimensionsTickets[4] - $dimensionsTickets[0]);
    $xTickets = imagesx($im) - $textWidthTickets;
    
    imagettftext($im, 20, 0, $xTickets - 10, 25, $orange, $bigfont, $ticketsCount);

    imagepng($im);
    imagedestroy($im);
});

/**
 * Vegas Attendee Opt-in
 */
Route::middleware('auth')->group(function () {
    Route::get('vegas2019', function () {
        $optedIn = DB::table('opt_in')
            ->where('member_id', auth()->user()->member->clan_id)
            ->whereOptedOut(null)
            ->exists();

        return view('pages.vegas-opt-in', compact('optedIn'));
    })->middleware('auth')->name('vegas-survey');

    Route::post('vegas2019/opt-in', function () {
        $user = auth()->user()->member;

        if ($attendee = \App\VegasAttendee::whereMemberId($user->clan_id)->first()) {
            $attendee->opted_out = null;
            $attendee->save();
        } else {
            Mail::to(auth()->user())->send(new \App\Mail\VegasNotify());
            VegasAttendee::optIn();
        }

        return redirect(route('vegas-survey'));
    })->middleware('auth');

    Route::delete('vegas2019/opt-out', function () {
        $user = auth()->user()->member;

        VegasAttendee::whereMemberId($user->clan_id)
            ->first()
            ->optOut();

        return redirect(route('vegas-survey'));
    });
});

Route::middleware(['auth', 'admin'])->get('/test-the-webhook', function () {
    $division = App\Division::active()->first();
    try {
        $division->notify(new \App\Notifications\TestingWebhook($division));

        return "Success!";
    } catch (Exception $exception) {
        return $exception;
    }
});
