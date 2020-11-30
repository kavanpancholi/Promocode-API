<?php

namespace App\Http\Controllers;

use App\Facades\Services\LocationService;
use App\Http\Requests\ApplyPromocodeRequest;
use App\Http\Requests\CreatePromocodeRequest;
use App\Http\Requests\UpdatePromocodeRequest;
use App\Models\Promocode;

class PromocodeController extends Controller
{
    /**
     * @return array|string[]
     */
    public function index()
    {
        try {
            $promocodes = Promocode::all();
            return ['status' => 'success', 'data' => $promocodes];
        } catch (\Exception $exception) {
            logger('Error while getting list of Promocodes', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
            return [
                'status' => 'error',
                'message' => 'Could not get the list of Promocodes. Please try again later.'
            ];
        }
    }

    /**
     * @return array|string[]
     */
    public function active()
    {
        try {
            $promocodes = Promocode::where('is_active', true)->get();
            return ['status' => 'success', 'data' => $promocodes];
        } catch (\Exception $exception) {
            logger('Error while getting list of Active Promocodes', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
            return [
                'status' => 'error',
                'message' => 'Could not get the list of active Promocodes. Please try again later.'
            ];
        }
    }

    /**
     * @param CreatePromocodeRequest $request
     * @return array|string[]
     */
    public function store(CreatePromocodeRequest $request)
    {
        try {
            $promocode = new Promocode();
            $promocode->fill($request->all());
            $promocode->save();

            return [
                'status' => 'success',
                'message' => 'Promocode has been created successfully',
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
                'message' => 'Promocode could not be added. Please try again later',
            ];
        }
    }

    /**
     * @param ApplyPromocodeRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function apply(ApplyPromocodeRequest $request)
    {
        $promoCode = Promocode::where('code', $request->get('code'))->where('is_active', true)->first();
        if ($promoCode) {
            if ($promoCode->isDistanceInRange([
                'latitude' => $request->get('origin_latitude'),
                'longitude' => $request->get('origin_longitude')
            ], [
                'latitude' => $request->get('destination_latitude'),
                'longitude' => $request->get('destination_longitude')
            ])) {
                try {
                    $directions = \GoogleMaps::load('directions')
                        ->setParam([
                            'origin' => $request->get('origin_latitude') . ',' . $request->get('origin_longitude'),
                            'destination' => $request->get('destination_latitude') . ',' . $request->get('destination_longitude'),
                        ])->get();
                    $route = json_decode($directions, true);
                    return [
                        'status' => 'success',
                        'data' => [
                            'promocode' => $promoCode,
                            'route' => $route['routes'],
                        ],
                        'message' => 'Promocode applied successfully',
                    ];
                } catch (\Exception $exception) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error while fetching polylines. Please check Google Map Configurations',
                    ], 500);
                }
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry. Your destination is not in the range.',
            ], 400);
        }
    }

    /**
     * @param UpdatePromocodeRequest $request
     * @param Promocode $promocode
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(UpdatePromocodeRequest $request, Promocode $promocode)
    {
        try {
            $promocode->fill($request->all());
            $promocode->save();

            return [
                'status' => 'success',
                'message' => 'Promocode has been updated successfully',
                'data' => $promocode
            ];
        } catch (\Exception $exception) {
            logger('Error while updating a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Promocode could not be updated. Please try again later',
            ], 500);
        }
    }

    /**
     * @param Promocode $promocode
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function activate(Promocode $promocode)
    {
        try {
            if ($promocode->is_active) {
                return [
                    'status' => 'success',
                    'message' => 'Promocode has already been activated',
                ];
            }
            $promocode->is_active = true;
            $promocode->save();

            return [
                'status' => 'success',
                'message' => 'Promocode has been activated successfully',
            ];
        } catch (\Exception $exception) {
            logger('Error while activating a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $promocode,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Promocode could not be activated. Please try again later',
            ], 500);
        }
    }

    /**
     * @param Promocode $promocode
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function deactivate(Promocode $promocode)
    {
        try {
            if (!$promocode->is_active) {
                return [
                    'status' => 'success',
                    'message' => 'Promocode has already been deactivated',
                ];
            }
            $promocode->is_active = false;
            $promocode->save();

            return [
                'status' => 'success',
                'message' => 'Promocode has been deactivated successfully',
            ];
        } catch (\Exception $exception) {
            logger('Error while deactivating a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $promocode,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Promocode could not be deactivated. Please try again later',
            ], 500);
        }
    }

    /**
     * @param Promocode $promocode
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function destroy(Promocode $promocode)
    {
        try {
            $promocode->delete();

            return [
                'status' => 'success',
                'message' => 'Promocode has been removed successfully'
            ];
        } catch (\Exception $exception) {
            logger('Error while removing a promocode', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'request' => $promocode,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Promocode could not be removed. Please try again later',
            ], 500);
        }
    }
}
