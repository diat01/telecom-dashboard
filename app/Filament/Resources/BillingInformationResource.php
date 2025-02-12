<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillingInformationResource\Pages;
use App\Filament\Resources\BillingInformationResource\RelationManagers;
use App\Models\BillingInformation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillingInformationResource extends Resource
{
    protected static ?string $model = BillingInformation::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'first_name') // Relates to customers table
                    ->required(),
                Forms\Components\TextInput::make('payment_method')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('balance')
                    ->required()
                    ->numeric()  // Enforces numeric input
                    ->minValue(0)  // Ensures balance is not negative
                    ->step(0.01)  // Allows decimal values (up to 2 decimals)
                    ->placeholder('0.00'),
                Forms\Components\DatePicker::make('next_billing_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')->label('Customer Name'),
                Tables\Columns\TextColumn::make('payment_method')->label('Payment Method'),
                Tables\Columns\TextColumn::make('balance')->label('Balance'),
                Tables\Columns\TextColumn::make('next_billing_date')->label('Next Billing Date'),
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
            'index' => Pages\ListBillingInformation::route('/'),
            'create' => Pages\CreateBillingInformation::route('/create'),
            'edit' => Pages\EditBillingInformation::route('/{record}/edit'),
        ];
    }
}
