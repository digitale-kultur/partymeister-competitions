<?php

namespace Partymeister\Competitions\Helpers;

use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Core\Models\Callback;

class CallbackHelper
{

    public static function competitionStarts(Competition $competition)
    {
        $hash = hash_hmac('sha256', $competition->id . 'competition_starts', 20);

        $callback = Callback::where('hash', '=', $hash)->first();

        if (is_null($callback)) {
            $callback = new Callback();
        }

        $callback->name        = 'Competition: ' . $competition->name . ' starts';
        $callback->action      = 'notification';
        $callback->title       = 'Competition';
        $callback->body        = $competition->name . ' competition is starting';
        $callback->hash        = $hash;
        $callback->destination = 'competitions';
        $callback->save();

        return $callback;
    }


    public static function livevoting(Entry $entry)
    {
        $hash = hash_hmac('sha256', $entry->id . 'livevoting_advance', 20);

        $callback = Callback::where('hash', '=', $hash)->first();

        if (is_null($callback)) {
            $callback = new Callback();
        }

        if ($entry->competition->competition_type->is_anonymous) {
            $name = $entry->title;
        } else {
            $name = $entry->title . ' by ' . $entry->author;
        }

        $callback->name        = 'Entry: ' . $name . ' is now playing';
        $callback->action      = 'live_with_notification';
        $callback->title       = 'Entry';
        $callback->payload     = json_encode([ 'competition_id' => $entry->competition->id, 'entry_id' => $entry->id ]);
        $callback->body        = $name . ' is now playing';
        $callback->hash        = $hash;
        $callback->destination = 'nowplaying';
        $callback->save();

        return $callback;
    }
}