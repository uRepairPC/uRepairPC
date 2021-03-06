<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Perm;
use Illuminate\Http\JsonResponse;
use App\Models\EquipmentManufacturer;
use App\Realtime\EquipmentManufacturers\EJoin;
use App\Realtime\EquipmentManufacturers\ECreate;
use App\Realtime\EquipmentManufacturers\EUpdate;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\EquipmentManufacturerRequest;

class EquipmentManufacturerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function permissions(): array
    {
        return [
            'index' => Perm::EQUIPMENTS_CONFIG_VIEW_ALL,
            'show' => Perm::EQUIPMENTS_CONFIG_VIEW_ALL,
            'store' => Perm::EQUIPMENTS_CONFIG_CREATE,
            'update' => [Perm::EQUIPMENTS_CONFIG_EDIT_OWN, Perm::EQUIPMENTS_CONFIG_EDIT_ALL],
            'destroy' => [Perm::EQUIPMENTS_CONFIG_DELETE_OWN, Perm::EQUIPMENTS_CONFIG_DELETE_ALL],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $list = EquipmentManufacturer::all();

        EJoin::dispatchAfterResponse(...$list);

        return response()->json($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EquipmentManufacturerRequest  $request
     * @return JsonResponse
     */
    public function store(EquipmentManufacturerRequest $request): JsonResponse
    {
        $manufacturer = new EquipmentManufacturer($request->validated());
        $manufacturer->user_id = auth()->id();
        $manufacturer->save();

        ECreate::dispatchAfterResponse($manufacturer);

        return response()->json([
            'message' => __('app.equipment_manufacturers.store'),
            'equipment_manufacturer' => $manufacturer,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  EquipmentManufacturer  $equipmentManufacturer
     * @return JsonResponse
     */
    public function show(EquipmentManufacturer $equipmentManufacturer): JsonResponse
    {
        EJoin::dispatchAfterResponse($equipmentManufacturer);

        return response()->json([
            'message' => __('app.equipment_manufacturers.show'),
            'equipment_manufacturer' => $equipmentManufacturer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EquipmentManufacturerRequest  $request
     * @param  EquipmentManufacturer  $equipmentManufacturer
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(EquipmentManufacturerRequest $request, EquipmentManufacturer $equipmentManufacturer): JsonResponse
    {
        $this->authorize('update', $equipmentManufacturer);

        $equipmentManufacturer->fill($request->validated());
        $equipmentManufacturer->save();

        EUpdate::dispatchAfterResponse($equipmentManufacturer->id, $equipmentManufacturer);

        return response()->json([
            'message' => __('app.equipment_manufacturers.update'),
            'equipment_manufacturer' => $equipmentManufacturer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EquipmentManufacturer  $equipmentManufacturer
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(EquipmentManufacturer $equipmentManufacturer): JsonResponse
    {
        $this->authorize('delete', $equipmentManufacturer);

        $equipmentManufacturer->delete();

        return response()->json([
            'message' => __('app.equipment_manufacturers.destroy'),
        ]);
    }
}
