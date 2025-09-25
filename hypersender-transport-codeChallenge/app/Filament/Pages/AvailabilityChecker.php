<?php

namespace App\Filament\Pages;

use App\Models\Driver;
use App\Models\Vehicle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityChecker extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static string $view = 'filament.pages.availability-checker';

    // This is the property that holds the form's state.
    public ?array $data = [];

    // These properties are still useful for holding the results of our queries.
    public Collection $availableDrivers;
    public Collection $availableVehicles;


    public function mount(): void
    {
        // Initialize properties with empty ELOQUENT collections to match the type hint
        $this->availableDrivers = new Collection();
        $this->availableVehicles = new Collection();

        // Set default times and load initial data
        $this->form->fill([
            'startTime' => now()->startOfHour(),
            'endTime' => now()->startOfHour()->addHours(4),
        ]);

        // Trigger the initial data load
        $this->loadAvailableResources();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    DateTimePicker::make('startTime')
                        ->label('Start of Period')
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn () => $this->loadAvailableResources()),

                    DateTimePicker::make('endTime')
                        ->label('End of Period')
                        ->required()
                        ->live()
                        ->after('startTime')
                        ->afterStateUpdated(fn () => $this->loadAvailableResources()),
                ]),
            ])
            ->statePath('data');
    }

    /**
     * This is the new central method to run the queries.
     */
    public function loadAvailableResources(): void
    {
        $data = $this->form->getState();
        $startTime = $data['startTime'] ?? null;
        $endTime = $data['endTime'] ?? null;

        if (!$startTime || !$endTime) {
            $this->availableDrivers = new Collection();
            $this->availableVehicles = new Collection();
            return;
        }

        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        $this->availableDrivers = $this->getAvailable('driver', $start, $end);
        $this->availableVehicles = $this->getAvailable('vehicle', $start, $end);
    }

    /**
     * This private helper function contains the duplicated query logic.
     */
    private function getAvailable(string $type, Carbon $start, Carbon $end): Collection
    {
        $query = $type === 'driver'
            ? Driver::where('status', 'available')
            // For vehicles, the "available" status is called "active"
            : Vehicle::where('status', 'active');

        return $query->whereDoesntHave('trips', function ($query) use ($start, $end) {
            $query
                ->where('start_time', '<', $end)
                ->where('end_time', '>', $start);
        })->get();
    }

    // The methods called by the view now just return the properties
    public function getAvailableDrivers(): Collection
    {
        return $this->availableDrivers;
    }

    public function getAvailableVehicles(): Collection
    {
        return $this->availableVehicles;
    }
}

