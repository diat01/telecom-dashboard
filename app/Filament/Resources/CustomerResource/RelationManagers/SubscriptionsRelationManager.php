<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';


    protected static ?string $title = 'Tölegler';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('subscription_plan_id')
                    ->label('Nyrhnama')
                    ->relationship('plan', 'name')
                    ->required(),

                Forms\Components\Select::make('payment_method')
                    ->label('Töleg usuly')
                    ->options([
                        'Nagt'   => 'Nagt',
                        "Kart"   => "Kart",
                        'Onlayn' => 'Onlaýn',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make("end_date")
                    ->label("Tamamlanýan senesi")
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payment_method')
            ->columns([
                Tables\Columns\TextColumn::make('plan.service.name')
                    ->label('Hyzmat'),

                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Nyrhnama'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Töleg usuly'),
                Tables\Columns\TextColumn::make("end_date")
                    ->label("Tamamlanýan senesi")
                    ->date("d.m.Y"),

                Tables\Columns\IconColumn::make('status')
                    ->label('Ýagdaýy')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->toggleable(false)
                    ->getStateUsing(function ($record) {
                        return $record->end_date && $record->end_date->isFuture();
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort("end_date", "desc");
    }
}
