<?php


namespace App\Repositories;


use App\Exceptions\GoogleMapDirectionAPIException;
use App\Exceptions\PromocodeOutOfRangeException;
use App\Models\Promocode;
use App\Http\Resources\Promocode as PromocodeResource;


class PromocodeRepository extends BaseRepository
{
    protected $model = Promocode::class;

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function active()
    {
        return $this->all(['is_active' => true]);
    }

    /**
     * @param array $request
     * @return array
     * @throws GoogleMapDirectionAPIException
     * @throws PromocodeOutOfRangeException
     */
    public function apply(array $request)
    {
        // Get Promo Code from Database
        $promoCode = Promocode::where('code', $request['code'])->where('is_active', true)->first();
        $originLatLong = [
            'latitude' => $request['origin_latitude'],
            'longitude' => $request['origin_longitude']
        ];
        $destinationLatLong = [
            'latitude' => $request['destination_latitude'],
            'longitude' => $request['destination_longitude']
        ];
        // Check if origin and destination range is in specified range else throw exception
        $this->validateRange($promoCode, $originLatLong, $destinationLatLong);
        // Get Route from Google Map Direction API
        $route = $this->getRoute($originLatLong, $destinationLatLong);
        return [
            'routes' => $route['routes'],
            'promocode' => new PromocodeResource($promoCode),
        ];
    }

    /**
     * @param Promocode $promoCode
     * @param array $originLatLong
     * @param array $destinationLatLong
     * @throws PromocodeOutOfRangeException
     */
    private function validateRange(Promocode $promoCode, array $originLatLong, array $destinationLatLong)
    {
        if (!$promoCode->isDistanceInRange($originLatLong, $destinationLatLong)) {
            throw new PromocodeOutOfRangeException();
        }
    }

    /**
     * @param array $originLatLong
     * @param array $destinationLatLong
     * @return mixed
     * @throws GoogleMapDirectionAPIException
     */
    private function getRoute(array $originLatLong, array $destinationLatLong)
    {
        try {
            $directions = \GoogleMaps::load('directions')
                ->setParam([
                    'origin' => $originLatLong['latitude'] . ',' . $originLatLong['longitude'],
                    'destination' => $destinationLatLong['latitude'] . ',' . $destinationLatLong['longitude'],
                ])->get();
            return json_decode($directions, true);
        } catch (\Exception $exception) {
            throw new GoogleMapDirectionAPIException();
        }
    }

    /**
     * @param int $promocodeId
     * @return mixed
     * @throws \ReflectionException
     */
    public function activate(int $promocodeId)
    {
        return $this->update($promocodeId, ['is_active' => true]);
    }

    /**
     * @param int $promocodeId
     * @return mixed
     * @throws \ReflectionException
     */
    public function deactivate(int $promocodeId)
    {
        return $this->update($promocodeId, ['is_active' => false]);
    }
}
