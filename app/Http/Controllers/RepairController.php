<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

/*Para el calendario*/
use Illuminate\Http\JsonResponse;

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
            ->get();

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
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'job_description' => ['required', 'string'],
            'total_cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);

        $data['date'] = Carbon::parse($data['starts_at'])->toDateString();

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
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'job_description' => ['required', 'string'],
            'total_cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);

        $data['date'] = Carbon::parse($data['starts_at'])->toDateString();

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

    /*Para el Calendario*/
    public function calendarEvents(): JsonResponse
    {
        $repairs = Repair::with(['vehicle.customer', 'mechanic'])
            ->whereNotNull('starts_at')
            ->whereNotNull('ends_at')
            ->get()
            ->map(fn (Repair $repair) => [
                'id' => $repair->id,
                'title' => trim(
                    ($repair->vehicle?->license_plate ?? 'Vehículo') . ' — ' .
                    ($repair->vehicle?->customer?->name ?? 'Cliente sin nombre')
                ),
                'start' => $repair->starts_at->toIso8601String(),
                'end' => $repair->ends_at->toIso8601String(),
                'url' => route('repairs.edit', $repair),
                'extendedProps' => [
                    'status' => $repair->status,
                    'description' => $repair->job_description,
                    'mechanic' => $repair->mechanic?->name,
                ],
            ]);

        return response()->json($repairs);
    }

    public function downloadPdf(Repair $repair)
    {
        $repair->load(['vehicle.customer', 'mechanic']);

        return Pdf::loadView('pages.repairs.pdf', [
            'repair' => $repair,
        ])
            ->setPaper('a4', 'portrait')
            ->download('reparacion-' . $repair->id . '.pdf');
    }
}