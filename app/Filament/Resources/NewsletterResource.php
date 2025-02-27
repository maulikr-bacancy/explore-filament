<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterResource\Pages;
use App\Filament\Resources\NewsletterResource\RelationManagers;
use App\Models\Newsletter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsletterResource extends Resource
{
    protected static ?string $model = Newsletter::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Newsletters';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('Name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('Type')
                    ->required()
                    ->maxLength(20)
                    ->default('Patient'),
                Forms\Components\TextInput::make('Framework')
                    ->required()
                    ->maxLength(40)
                    ->default('Generic'),
                Forms\Components\TextInput::make('PDF')
                    ->required()
                    ->maxLength(40)
                    ->default('Normal'),
                Forms\Components\TextInput::make('Quote')
                    ->maxLength(255),
                Forms\Components\TextInput::make('Preview')
                    ->maxLength(255),
                Forms\Components\Textarea::make('Summary')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('PictureURL')
                    ->maxLength(255),
                Forms\Components\TextInput::make('NumberSections')
                    ->required()
                    ->numeric()
                    ->default(3),
                Forms\Components\Textarea::make('Content')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('htmlTemplate')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('pdfTemplate')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('txtTemplate')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('listTemplate')
                    ->numeric(),
                Forms\Components\TextInput::make('broadcastfor')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('contentfile')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('broadcastsubject')
                    ->maxLength(100),
                Forms\Components\TextInput::make('month')
                    ->numeric(),
                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\TextInput::make('customertype')
                    ->maxLength(20)
                    ->default('PT'),
                Forms\Components\TextInput::make('showarchive')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('guid')
                    ->maxLength(200),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Name')
                    ->limit(10)
                    ->searchable(),
                Tables\Columns\TextColumn::make('Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Framework')
                    ->searchable(),
                Tables\Columns\TextColumn::make('PDF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Quote')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('Preview')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('PictureURL')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('NumberSections')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('htmlTemplate')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pdfTemplate')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('txtTemplate')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('listTemplate')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('broadcastfor')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contentfile')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('broadcastsubject')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('month')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('customertype'),
                Tables\Columns\ToggleColumn::make('showarchive')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guid')
                    ->searchable()
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
            'index' => Pages\ListNewsletters::route('/'),
            'create' => Pages\CreateNewsletter::route('/create'),
            'edit' => Pages\EditNewsletter::route('/{record}/edit'),
        ];
    }
}
