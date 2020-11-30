<?php

namespace App\Http\Controllers;

use App\Exceptions\GoogleMapDirectionAPIException;
use App\Exceptions\PromocodeOutOfRangeException;
use App\Http\Requests\ApplyPromocodeRequest;
use App\Http\Requests\CreatePromocodeRequest;
use App\Http\Requests\UpdatePromocodeRequest;
use App\Http\Resources\PromocodeCollection;
use App\Http\Resources\Promocode as PromocodeResource;
use App\Models\Promocode;
use App\Repositories\PromocodeRepository;
use Illuminate\Http\JsonResponse;

class PromocodeController extends Controller
{
    protected $promocodeRepository;

    public function __construct(PromocodeRepository $promocodeRepository)
    {
        $this->promocodeRepository = $promocodeRepository;
    }

    /**
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function index()
    {
        $promoCodes = $this->promocodeRepository->all();

        return response()->json(['status' => 'success', 'data' => new PromocodeCollection($promoCodes)]);
    }

    /**
     * @return JsonResponse
     */
    public function active()
    {
        $promoCodes = $this->promocodeRepository->active();

        return response()->json(['status' => 'success', 'data' => new PromocodeCollection($promoCodes)]);
    }

    /**
     * @param CreatePromocodeRequest $request
     * @return JsonResponse
     */
    public function store(CreatePromocodeRequest $request)
    {
        $promocode = $this->promocodeRepository->create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been created successfully',
            'data' => new PromocodeResource($promocode)
        ]);
    }

    /**
     * @param ApplyPromocodeRequest $request
     * @return JsonResponse
     * @throws GoogleMapDirectionAPIException
     * @throws PromocodeOutOfRangeException
     */
    public function apply(ApplyPromocodeRequest $request)
    {
        $data = $this->promocodeRepository->apply($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been created successfully',
            'data' => $data
        ]);
    }

    /**
     * @param UpdatePromocodeRequest $request
     * @param Promocode $promocode
     * @return array|JsonResponse
     */
    public function update(UpdatePromocodeRequest $request, Promocode $promocode)
    {
        $promocode = $this->promocodeRepository->update($promocode->id, $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been updated successfully',
            'data' => new PromocodeResource($promocode)
        ]);
    }

    /**
     * @param Promocode $promocode
     * @return JsonResponse|string[]
     */
    public function activate(Promocode $promocode)
    {
        $promocode = $this->promocodeRepository->activate($promocode->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been activated successfully',
        ]);
    }

    /**
     * @param Promocode $promocode
     * @return JsonResponse|string[]
     */
    public function deactivate(Promocode $promocode)
    {
        $promocode = $this->promocodeRepository->deactivate($promocode->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been deactivated successfully',
        ]);
    }

    /**
     * @param Promocode $promocode
     * @return JsonResponse|string[]
     */
    public function destroy(Promocode $promocode)
    {
        $promocode = $this->promocodeRepository->destroy($promocode->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been removed successfully',
        ]);
    }
}
