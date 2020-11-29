<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * @return array|string[]
     */
    public function index()
    {
        try {
            $events = Event::all();
            return ['status' => 'success', 'data' => $events];
        } catch (\Exception $exception) {
            logger('Error while getting list of Events', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
            return [
                'status' => 'error',
                'message' => 'Could not get the list of Events. Please try again later.'
            ];
        }
    }

    /**
     * @param EventRequest $request
     * @return array|string[]
     */
    public function store(EventRequest $request)
    {
        try {
            $promocode = new Event();
            $promocode->fill($request);
            $promocode->save();

            return [
                'status' => 'success',
                'message' => 'Event has been created successfully',
                'data' => $promocode
            ];
        } catch (\Exception $exception) {
            logger('Error while creating a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $request->all(),
            ]);
            return [
                'status' => 'error',
                'message' => 'Event could not be added. Please try again later',
            ];
        }
    }

    /**
     * @param EventRequest $request
     * @param Event $promocode
     * @return array|string[]
     */
    public function update(EventRequest $request, Event $promocode)
    {
        try {
            $promocode->fill($request->validated());
            $promocode->save();

            return [
                'status' => 'success',
                'message' => 'Event has been updated successfully',
                'data' => $promocode
            ];
        } catch (\Exception $exception) {
            logger('Error while updating a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $request->all(),
            ]);
            return [
                'status' => 'error',
                'message' => 'Event could not be updated. Please try again later',
            ];
        }
    }

    /**
     * @param Event $promocode
     * @return string[]
     */
    public function destroy(Event $promocode)
    {
        try {
            $promocode->delete();

            return [
                'status' => 'success',
                'message' => 'Event has been removed successfully'
            ];
        } catch (\Exception $exception) {
            logger('Error while removing a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $promocode,
            ]);
            return [
                'status' => 'error',
                'message' => 'Event could not be removed. Please try again later',
            ];
        }
    }
}
