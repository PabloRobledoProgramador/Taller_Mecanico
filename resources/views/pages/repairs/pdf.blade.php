<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reparación {{ $repair->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        h1 { color: #1d4ed8; margin-bottom: 4px; }
        .muted { color: #6b7280; }
        .section { margin-top: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 9px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { width: 32%; color: #4b5563; }
        .total { margin-top: 20px; text-align: right; font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Reporte de reparación</h1>
    <p class="muted">Reparación #{{ $repair->id }}</p>

    <div class="section">
        <table>
            <tr><th>Cliente</th><td>{{ $repair->vehicle?->customer?->name ?? 'No disponible' }}</td></tr>
            <tr><th>Vehículo</th><td>{{ $repair->vehicle?->brand }} {{ $repair->vehicle?->model }}</td></tr>
            <tr><th>Placa</th><td>{{ $repair->vehicle?->license_plate ?? 'No disponible' }}</td></tr>
            <tr><th>Mecánico</th><td>{{ $repair->mechanic?->name ?? 'Sin asignar' }}</td></tr>
            <tr><th>Estado</th><td>{{ str_replace('_', ' ', ucfirst($repair->status)) }}</td></tr>
            <tr><th>Inicio</th><td>{{ $repair->starts_at?->format('d/m/Y H:i') ?? 'No registrado' }}</td></tr>
            <tr><th>Fin</th><td>{{ $repair->ends_at?->format('d/m/Y H:i') ?? 'No registrado' }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Trabajo realizado / solicitado</h2>
        <p>{{ $repair->job_description }}</p>
    </div>

    <p class="total">Costo: ${{ number_format((float) $repair->total_cost, 2, ',', '.') }}</p>
</body>
</html>