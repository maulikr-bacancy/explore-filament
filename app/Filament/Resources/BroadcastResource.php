<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BroadcastResource\Pages;
use App\Filament\Resources\BroadcastResource\RelationManagers;
use App\Models\Broadcast;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BroadcastResource extends Resource
{
    protected static ?string $model = Broadcast::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    protected static ?string $navigationGroup = 'Newsletters';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('practice_id')
                    ->numeric(),
                Forms\Components\TextInput::make('Name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('Type')
                    ->required()
                    ->maxLength(20)
                    ->default('Broadcast')->readOnly(),
                Forms\Components\Textarea::make('Content')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('htmlTemplate')
                    ->required()
                    ->numeric()
                    ->default(887),
                Forms\Components\TextInput::make('txtTemplate')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('subject')
                    ->maxLength(100),
                Forms\Components\TextInput::make('month')
                    ->numeric(),
                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\TextInput::make('customertype')
                    ->maxLength(20)
                    ->default('PT')->readOnly(),
                Forms\Components\DateTimePicker::make('broadcastdate'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Broadcast::IgnoreTypes(['Monthly']);
            })
            ->columns([
                Tables\Columns\TextColumn::make('practice_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TagsColumn::make('sendstatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBroadcasts::route('/'),
            'create' => Pages\CreateBroadcast::route('/create'),
            'edit' => Pages\EditBroadcast::route('/{record}/edit'),
        ];
    }
}
