<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriberResource\Pages;
use App\Filament\Resources\SubscriberResource\RelationManagers;
use App\Models\Subscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Newsletters';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(70),
                Forms\Components\TextInput::make('last_name')
                    ->maxLength(70),
                Forms\Components\TextInput::make('name')
                    ->maxLength(200),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('last_message')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('date_added')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('full_date_added'),
                Forms\Components\TextInput::make('date_stopped')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('full_date_stopped'),
                Forms\Components\TextInput::make('not_sub_reason')
                    ->maxLength(20),
                Forms\Components\TextInput::make('is_sub')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('ip_address')
                    ->maxLength(20),
                Forms\Components\TextInput::make('web_form_url')
                    ->maxLength(200),
                Forms\Components\TextInput::make('is_html')
                    ->numeric(),
                Forms\Components\TextInput::make('clinic')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('practice_id')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(100)
                    ->default('Patient'),
                Forms\Components\TextInput::make('acp')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(200)
                    ->default(0),
                Forms\Components\TextInput::make('firstLetter')
                    ->required()
                    ->numeric()
                    ->default(13),
                Forms\Components\TextInput::make('date_last')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('email_validated')
                    ->email()
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('bouncetype')
                    ->maxLength(250),
                Forms\Components\TextInput::make('bouncecount')
                    ->numeric(),
                Forms\Components\TextInput::make('kickbox')
                    ->maxLength(250),
                Forms\Components\TextInput::make('survey_sent')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('date_discharged')
                    ->numeric(),
                Forms\Components\TextInput::make('addbyid')
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('payload')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kickbox_reason')
                    ->maxLength(100),
                Forms\Components\TextInput::make('kickbox_date')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_message')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_added')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('full_date_added')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_stopped')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('full_date_stopped')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('not_sub_reason')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_sub')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('web_form_url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_html')
                    ->sortable(),
                Tables\Columns\TextColumn::make('clinic')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('practice_id')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TagsColumn::make('type')
                    ->searchable()
                ->sortable(),
                Tables\Columns\ToggleColumn::make('acp')
                    ->disabled()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('firstLetter')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_last')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email_validated')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bouncetype')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bouncecount')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kickbox')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('survey_sent')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_discharged')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('addbyid')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kickbox_reason')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kickbox_date')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSubscribers::route('/'),
            'create' => Pages\CreateSubscriber::route('/create'),
            'edit' => Pages\EditSubscriber::route('/{record}/edit'),
        ];
    }
}
