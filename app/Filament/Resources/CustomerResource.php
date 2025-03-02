<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers\SubscriptionsRelationManager;
use App\Models\Customer;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModelLabel(): string
    {
        return "Müşderi";
    }

    public static function getPluralModelLabel(): string
    {
        return "Müşderiler";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label("Ady")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label("Familiýasy")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label("Salgy")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label("Şäher")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label("E-poçtasy")
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label("Telefon belgisi")
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('city'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label("Ady")->searchable()->sortable(),
                Tables\Columns\TextColumn::make('last_name')->label("Familiýasy")->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label("E-poçtasy")->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label("Telefon belgi")->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->label("Salgy")->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->label("Şäher")->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->delete()),
                    Tables\Actions\BulkAction::make('forceDelete')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->forceDelete()),
                ]),
            ])
            ->selectable();
    }

    public static function getRelations(): array
    {
        return [
            SubscriptionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit'   => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
