<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $events = Event::query()
            ->join('calendars', 'events.calendar_id', '=', 'calendars.id')
            ->where('calendars.user_id', '=', Auth::id())
            ->with('calendar')
            ->get();

        return response()->json($events);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json(Event::with('calendar')->find($id));
    }

    public function create(Request $request)
    {
        $event = new Event();

        return $this->_saveEvent($request, $event);
    }

    public function save(Request $request)
    {
        $event = Event::find($request->id);

        return $this->_saveEvent($request, $event);
    }

    public function destroy(Request $request)
    {
        $event = Event::find($request->id);

        if ($event->delete()) {
            return response()->json($event);
        } else {
            return response()->json(['error', 'Delete Error']);
        }
    }

    /**
     * @param Request $request
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function _saveEvent(Request $request, $event): \Illuminate\Http\JsonResponse
    {
        $event->name = $request->input('name');
        $event->start = new Carbon($request->input('start')); // JSからのデータを日時形式に変換
        $event->end = new Carbon($request->input('end')); // JSからのデータを日時形式に変換
        $event->timed = $request->input('timed');
        $event->calendar_id = $request->input('calendar_id');
        $event->description = $request->input('description');
        $event->color = $request->input('color');

        if ($event->save()) {
            return response()->json(Event::with('calendar')->find($event->id));
        } else {
            return response()->json(['error' => 'Save Error']);
        }
    }
}
