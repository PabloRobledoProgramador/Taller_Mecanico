<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('customer')
            ->latest()
            ->paginate(10);

        return view('pages.vehicles.index', [
            'vehicles' => $vehicles,
        ]);
    }

    public function create()
    {
        return view('pages.vehicles.create', [
            'vehicle' => new Vehicle(),
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'license_plate' => ['required', 'string', 'max:255', 'unique:vehicles,license_plate'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1886', 'max:' . (now()->year + 1)],
        ]);

        Vehicle::create($data);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo registrado.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load([
            'customer',
            'repairs' => fn ($query) => $query->orderByDesc('date'),
        ]);

        return view('pages.vehicles.show', [
            'vehicle' => $vehicle,
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        return view('pages.vehicles.edit', [
            'vehicle' => $vehicle,
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'license_plate' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id),
            ],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1886', 'max:' . (now()->year + 1)],
        ]);

        $vehicle->update($data);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo actualizado.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->repairs()->exists()) {
            return redirect()
                ->route('vehicles.index')
                ->with('error', 'No se puede eliminar este vehículo porque tiene reparaciones asociadas.');
        }

        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo eliminado.');
    }
}