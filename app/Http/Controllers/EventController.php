<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'eventName' => 'required',
            'matter_id' => 'required|numeric',
            'event_date' => 'required_without:alt_matter_id'
        ]);
        if ($request->filled('event_date')) {
            $request->merge(['event_date' => Carbon::createFromLocaleIsoFormat('L', app()->getLocale(), $request->event_date)]);
        }
        $request->merge([ 'creator' => Auth::user()->login ]);
        return Event::create($request->except(['_token', '_method', 'eventName']));
    }

    public function show(Event $event)
    {
        //
    }

    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'alt_matter_id' => 'nullable|numeric',
            'event_date' => 'sometimes|required_without:alt_matter_id'
        ]);
        if ($request->filled('event_date')) {
            $request->merge(['event_date' => Carbon::createFromLocaleIsoFormat('L', app()->getLocale(), $request->event_date)]);
        }
        $request->merge([ 'updater' => Auth::user()->login ]);
        $event->update($request->except(['_token', '_method']));
        return $event;
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return $event;
    }
}
