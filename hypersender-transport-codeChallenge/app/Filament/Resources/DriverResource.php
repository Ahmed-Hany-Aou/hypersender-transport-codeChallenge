<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

  //  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
protected static ?string $navigationIcon = 'heroicon-o-user-group';
protected static ?string $navigationLabel = 'Drivers';
protected static ?int $navigationSort = 3;
// Change icon/label/sort for each one


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Select::make('company_id')
                ->label('Company')
                ->relationship('company', 'name')
                ->required()
                ->searchable(),

            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('license_number')
                ->required()
                ->maxLength(50)
                ->unique(ignoreRecord: true), // Ensure no duplicate licenses
            Forms\Components\TextInput::make('phone')
                ->maxLength(30)
                ->tel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('company.name')->label('Company')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('license_number')->searchable(),
            Tables\Columns\TextColumn::make('phone'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
