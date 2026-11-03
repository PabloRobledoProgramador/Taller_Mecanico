@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12">
            <x-dashboard.summary-metrics
                :customer-count="$customerCount"
                :repair-count="$repairCount"
            />
        </div>

        <div class="col-span-12 xl:col-span-7">
            <x-dashboard.monthly-repair-value :monthly-income="$monthlyIncome" />
        </div>

        <div class="col-span-12 xl:col-span-5">
            <x-ecommerce.monthly-target
                :monthlyTarget="$monthlyTarget"
                :completedThisMonth="$completedThisMonth"
                :completedToday="$completedToday"
                :monthlyProgress="$monthlyProgress"
            />
        </div>

        <div class="col-span-12">
            <x-ecommerce.statistics-chart :monthlyRepairCounts="$monthlyRepairCounts" />
        </div>
        
        <div class="col-span-12">
            <x-dashboard.recent-repairs :repairs="$recentRepairs" />
        </div>
    </div>
@endsection
