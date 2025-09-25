<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Rules\OverlapRule;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->required()
                    ->live()
                    ->after('now'),
                Forms\Components\DateTimePicker::make('end_time')
                    ->required()
                    ->live()
                    ->after('start_time'),
                Forms\Components\Select::make('driver_id')
                    ->relationship('driver', 'name')
                    ->searchable()
                    ->required()
                    ->rules([
                        fn (Get $get, ?Trip $record): OverlapRule => new OverlapRule(
                            startTime: $get('start_time'),
                            endTime: $get('end_time'),
                            foreignKey: 'driver_id',
                            modelName: 'Driver',
                            recordId: $record?->id
                        ),
                    ]),
                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'plate_number')
                    ->searchable()
                    ->required()
                    ->rules([
                        fn (Get $get, ?Trip $record): OverlapRule => new OverlapRule(
                            startTime: $get('start_time'),
                            endTime: $get('end_time'),
                            foreignKey: 'vehicle_id',
                            modelName: 'Vehicle',
                            recordId: $record?->id
                        ),
                    ]),
                Forms\Components\TextInput::make('origin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('destination')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label('Driver')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.plate_number')
                    ->label('Vehicle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                // START: CORRECTED STATUS COLUMN
                Tables\Columns\TextColumn::make('status')
                    
                    ->formatStateUsing(fn (string $state): string => Str::title($state))
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'completed' => 'success',
                        'active' => 'primary',
                        'scheduled' => 'gray',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                    
                // END: CORRECTED STATUS COLUMN

                Tables\Columns\TextColumn::make('start_time')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('end_time')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['company', 'driver', 'vehicle']);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}

