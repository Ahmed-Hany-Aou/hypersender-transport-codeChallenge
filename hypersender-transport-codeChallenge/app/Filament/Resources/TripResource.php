<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Models\Trip; // 👈 Make sure Trip model is imported
use App\Rules\OverlapRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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

                Forms\Components\TextInput::make('origin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('destination')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DateTimePicker::make('start_time')
                    ->required()
                    ->live() // Make this field reactive
                    ->after('now'),
                Forms\Components\DateTimePicker::make('end_time')
                    ->required()
                    ->live() // Make this field reactive
                    ->after('start_time'),

                Forms\Components\Select::make('driver_id')
                    ->relationship('driver', 'name')
                    ->searchable()
                    ->required()
                    ->rules([
                        // 👇 CHANGE THE TYPE HINT HERE
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
                        // 👇 AND CHANGE THE TYPE HINT HERE
                        fn (Get $get, ?Trip $record): OverlapRule => new OverlapRule(
                            startTime: $get('start_time'),
                            endTime: $get('end_time'),
                            foreignKey: 'vehicle_id',
                            modelName: 'Vehicle',
                            recordId: $record?->id
                        ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('driver.name')->sortable(),
                Tables\Columns\TextColumn::make('vehicle.plate_number')->sortable(),
                Tables\Columns\TextColumn::make('start_time')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('end_time')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge(),
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

