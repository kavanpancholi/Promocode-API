<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyPromocodeRequest;
use App\Http\Requests\CreatePromocodeRequest;
use App\Http\Requests\UpdatePromocodeRequest;
use App\Models\Promocode;
use App\Repositories\PromocodeRepository;

class PromocodeController extends Controller
{
    protected $promocodeRepository;

    public function __construct(PromocodeRepository $promocodeRepository)
    {
        $this->promocodeRepository = $promocodeRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function index()
    {
        $promoCodes = $this->promocodeRepository->all();

        return response()->json(['status' => 'success', 'data' => $promoCodes]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function active()
    {
        $promoCodes = $this->promocodeRepository->active();

        return response()->json(['status' => 'success', 'data' => $promoCodes]);
    }

    /**
     * @param CreatePromocodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePromocodeRequest $request)
    {
        $promocode = $this->promocodeRepository->create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been created successfully',
            'data' => $promocode
        ]);
    }

    /**
     * @param ApplyPromocodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\PromocodeOutOfRangeException
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
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(UpdatePromocodeRequest $request, Promocode $promocode)
    {
        $promocode = $this->promocodeRepository->update($promocode->id, $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode has been updated successfully',
            'data' => $promocode
        ]);
    }

    /**
     * @param Promocode $promocode
     * @return \Illuminate\Http\JsonResponse|string[]
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
     * @return \Illuminate\Http\JsonResponse|string[]
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
     * @return \Illuminate\Http\JsonResponse|string[]
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
