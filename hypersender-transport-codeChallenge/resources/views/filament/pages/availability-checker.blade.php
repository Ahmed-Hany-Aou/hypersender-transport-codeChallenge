<x-filament-panels::page>

    {{-- The form with the date pickers --}}
    <form wire:submit.prevent>
        {{ $this->form }}
    </form>

    {{-- Results Section --}}
    <div class="mt-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

            {{-- Available Drivers Table --}}
            <div class="space-y-4">
                <h2 class="text-lg font-medium text-gray-950 dark:text-white">
                    Available Drivers ({{ $this->getAvailableDrivers()->count() }})
                </h2>
                <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <table class="fi-table w-full">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Name</th>
                                <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">License Number</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                            @forelse ($this->getAvailableDrivers() as $driver)
                                <tr>
                                    <td class="fi-table-cell px-3 py-4 sm:px-6">{{ $driver->name }}</td>
                                    <td class="fi-table-cell px-3 py-4 sm:px-6">{{ $driver->license_number }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="fi-table-cell px-3 py-4 text-center sm:px-6">
                                        No drivers are available in this time range.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Available Vehicles Table --}}
            <div class="space-y-4">
                <h2 class="text-lg font-medium text-gray-950 dark:text-white">
                    Available Vehicles ({{ $this->getAvailableVehicles()->count() }})
                </h2>
                <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <table class="fi-table w-full">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Model</th>
                                <th class="fi-table-header-cell px-3 py-3.5 sm:px-6">Plate Number</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                            @forelse ($this->getAvailableVehicles() as $vehicle)
                                <tr>
                                    <td class="fi-table-cell px-3 py-4 sm:px-6">{{ $vehicle->model }}</td>
                                    <td class="fi-table-cell px-3 py-4 sm:px-6">{{ $vehicle->plate_number }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="fi-table-cell px-3 py-4 text-center sm:px-6">
                                        No vehicles are available in this time range.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-filament-panels::page>
