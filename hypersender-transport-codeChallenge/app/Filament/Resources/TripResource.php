<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\TripResource\RelationManagers;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                ->label('Company')
                ->relationship('company', 'name')
                ->required(),

            Forms\Components\Select::make('driver_id')
                ->label('Driver')
                ->relationship('driver', 'name')
                ->required()
                ->searchable(),

            Forms\Components\Select::make('vehicle_id')
                ->label('Vehicle')
                ->relationship('vehicle', 'plate_number')
                ->required()
                ->searchable(),

            Forms\Components\TextInput::make('origin')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('destination')
                ->required()
                ->maxLength(255),

            Forms\Components\DateTimePicker::make('start_time')->required()->rules(['after_or_equal:today']),
            Forms\Components\DateTimePicker::make('end_time')->required()->rules(['after:start_time']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('company.name')->label('Company'),
            Tables\Columns\TextColumn::make('driver.name')->label('Driver'),
            Tables\Columns\TextColumn::make('vehicle.plate_number')->label('Vehicle'),
            Tables\Columns\TextColumn::make('origin'),
            Tables\Columns\TextColumn::make('destination'),
            Tables\Columns\TextColumn::make('start_time')->dateTime(),
            Tables\Columns\TextColumn::make('end_time')->dateTime(),
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
