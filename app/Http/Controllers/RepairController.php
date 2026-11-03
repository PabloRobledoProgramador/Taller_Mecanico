<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RepairController extends Controller
{
    private const STATUSES = [
        'en_taller' => 'En taller',
        'en_proceso' => 'En proceso',
        'completada' => 'Completada',
        'cancelada' => 'Cancelada',
    ];

    public function index()
    {
        $repairs = Repair::with(['vehicle.customer', 'mechanic'])
            ->orderByDesc('date')
            ->paginate(10);

        return view('pages.repairs.index', [
            'repairs' => $repairs,
            'statusOptions' => self::STATUSES,
        ]);
    }

    public function create()
    {
        return view('pages.repairs.create', [
            'repair' => new Repair(),
            'vehicles' => Vehicle::with('customer')->orderBy('license_plate')->get(),
            'mechanics' => User::orderBy('name')->get(),
            'statusOptions' => self::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'mechanic_id' => ['nullable', 'integer', 'exists:users,id'],
            'date' => ['required', 'date'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'job_description' => ['required', 'string'],
            'total_cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);

        Repair::create($data);

        return redirect()
            ->route('repairs.index')
            ->with('success', 'Reparación registrada.');
    }

    public function edit(Repair $repair)
    {
        return view('pages.repairs.edit', [
            'repair' => $repair,
            'vehicles' => Vehicle::with('customer')->orderBy('license_plate')->get(),
            'mechanics' => User::orderBy('name')->get(),
            'statusOptions' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Repair $repair)
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'mechanic_id' => ['nullable', 'integer', 'exists:users,id'],
            'date' => ['required', 'date'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'job_description' => ['required', 'string'],
            'total_cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);

        $repair->update($data);

        return redirect()
            ->route('repairs.index')
            ->with('success', 'Reparación actualizada.');
    }

    public function destroy(Repair $repair)
    {
        $repair->delete();

        return redirect()
            ->route('repairs.index')
            ->with('success', 'Reparación eliminada.');
    }
}