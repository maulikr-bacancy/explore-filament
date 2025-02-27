<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PracticeResource\Pages;
use App\Filament\Resources\PracticeResource\RelationManagers;
use App\Models\Practice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PracticeResource extends Resource
{
    protected static ?string $model = Practice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\DateTimePicker::make('dateAdded'),
                Forms\Components\TextInput::make('colorScheme')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('color_head')
                    ->required()
                    ->maxLength(6)
                    ->default(666666),
                Forms\Components\TextInput::make('color_framing')
                    ->required()
                    ->maxLength(6)
                    ->default('ffffcc'),
                Forms\Components\TextInput::make('color_section')
                    ->required()
                    ->maxLength(6)
                    ->default(000066),
                Forms\Components\TextInput::make('color_line')
                    ->required()
                    ->maxLength(6)
                    ->default(000066),
                Forms\Components\TextInput::make('color_text')
                    ->required()
                    ->maxLength(6)
                    ->default(000000),
                Forms\Components\TextInput::make('color_bkgrd')
                    ->required()
                    ->maxLength(6)
                    ->default('cccccc'),
                Forms\Components\TextInput::make('color_input')
                    ->maxLength(6)
                    ->default('eeeeee'),
                Forms\Components\TextInput::make('color_listtext')
                    ->maxLength(6)
                    ->default(000000),
                Forms\Components\TextInput::make('short_name')
                    ->required()
                    ->maxLength(12),
                Forms\Components\TextInput::make('sitehide')
                    ->required()
                    ->maxLength(12),
                Forms\Components\TextInput::make('website')
                    ->maxLength(150),
                Forms\Components\Textarea::make('topRightText')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bottomRightText')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('newsletterReady')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('newsletter')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(20)
                    ->default('inactive'),
                Forms\Components\TextInput::make('number_locations')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('signature')
                    ->maxLength(200),
                Forms\Components\TextInput::make('signature_email')
                    ->email()
                    ->maxLength(200),
                Forms\Components\TextInput::make('signature_phone')
                    ->tel()
                    ->maxLength(100),
                Forms\Components\TextInput::make('prompt_level')
                    ->required()
                    ->maxLength(20)
                    ->default('plus'),
                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->maxLength(200),
                Forms\Components\TextInput::make('contact_phone')
                    ->tel()
                    ->maxLength(100),
                Forms\Components\TextInput::make('contact_cell_phone')
                    ->tel()
                    ->maxLength(100),
                Forms\Components\TextInput::make('found_code')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('contact_name')
                    ->maxLength(200),
                Forms\Components\TextInput::make('need_setup')
                    ->maxLength(5)
                    ->default('false'),
                Forms\Components\TextInput::make('use_referral')
                    ->maxLength(5)
                    ->default('false'),
                Forms\Components\TextInput::make('patient_list')
                    ->maxLength(30)
                    ->default('Patient'),
                Forms\Components\TextInput::make('md_list')
                    ->maxLength(30)
                    ->default('MD'),
                Forms\Components\TextInput::make('year')
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('phase')
                    ->maxLength(20),
                Forms\Components\TextInput::make('blocking_cust')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('blocking_us')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('in_count')
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('googleKey')
                    ->maxLength(255),
                Forms\Components\TextInput::make('wsonly')
                    ->maxLength(5),
                Forms\Components\TextInput::make('tempsite')
                    ->maxLength(150),
                Forms\Components\TextInput::make('enhanced')
                    ->maxLength(5)
                    ->default('true'),
                Forms\Components\DatePicker::make('arb'),
                Forms\Components\TextInput::make('selfedit')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('x3')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('seotesturl')
                    ->maxLength(200),
                Forms\Components\TextInput::make('searchenabled')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('clicky')
                    ->maxLength(100)
                    ->default(0),
                Forms\Components\TextInput::make('clickykey')
                    ->maxLength(30)
                    ->default(0),
                Forms\Components\TextInput::make('nlonly')
                    ->maxLength(5),
                Forms\Components\TextInput::make('newlook')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('x3nl')
                    ->maxLength(30)
                    ->default('phasenotactive'),
                Forms\Components\DatePicker::make('datequit'),
                Forms\Components\TextInput::make('quitreason')
                    ->maxLength(100),
                Forms\Components\TextInput::make('responsible')
                    ->maxLength(30)
                    ->default(0),
                Forms\Components\TextInput::make('facebookid')
                    ->maxLength(100),
                Forms\Components\TextInput::make('facebookurl')
                    ->maxLength(200),
                Forms\Components\TextInput::make('facebookfeed')
                    ->maxLength(20)
                    ->default('RSSGraffiti'),
                Forms\Components\TextInput::make('facebook_locations')
                    ->maxLength(20)
                    ->default('no'),
                Forms\Components\TextInput::make('havestore')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('priority')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('servicelevel')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('wordpress')
                    ->maxLength(20),
                Forms\Components\TextInput::make('wpblogid')
                    ->numeric(),
                Forms\Components\TextInput::make('freshbooks')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('mobilephase')
                    ->maxLength(40)
                    ->default('Not Set'),
                Forms\Components\TextInput::make('rms')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('bom')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('bomadmin')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('in_helpscout')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('fid')
                    ->numeric(),
                Forms\Components\Textarea::make('wmt')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lrs')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('gplus_account')
                    ->maxLength(40)
                    ->default('Unknown'),
                Forms\Components\TextInput::make('intercom_id')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('ws_local_optimized'),
                Forms\Components\TextInput::make('g5')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('g5theme')
                    ->maxLength(20),
                Forms\Components\TextInput::make('g5builder')
                    ->maxLength(30),
                Forms\Components\TextInput::make('mssphase')
                    ->maxLength(20)
                    ->default('Not'),
                Forms\Components\TextInput::make('mssreviewmonth')
                    ->numeric()
                    ->default(10),
                Forms\Components\TextInput::make('ncphase')
                    ->maxLength(20)
                    ->default('None'),
                Forms\Components\TextInput::make('oldwpblogid')
                    ->numeric(),
                Forms\Components\TextInput::make('oldlinknumber')
                    ->numeric(),
                Forms\Components\TextInput::make('bptm')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('placeholder')
                    ->maxLength(100),
                Forms\Components\TextInput::make('prs')
                    ->maxLength(20)
                    ->default('false'),
                Forms\Components\TextInput::make('moderation')
                    ->maxLength(20)
                    ->default('them'),
                Forms\Components\TextInput::make('review_email')
                    ->email()
                    ->maxLength(200),
                Forms\Components\TextInput::make('alertemail')
                    ->email()
                    ->maxLength(50)
                    ->default('arcemail'),
                Forms\Components\TextInput::make('alertemailapp')
                    ->email()
                    ->maxLength(50)
                    ->default('arcemail'),
                Forms\Components\TextInput::make('domain_owner')
                    ->maxLength(20)
                    ->default('them'),
                Forms\Components\TextInput::make('videos_per_month')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('images_per_month')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('no_third_party_msg')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('ssl_active')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('timezone')
                    ->maxLength(5)
                    ->default('EST'),
                Forms\Components\TextInput::make('txt180')
                    ->maxLength(50),
                Forms\Components\TextInput::make('prs_notification')
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('review_notification')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('review_notification_receiver')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('mssStartDate')
                    ->maxLength(40),
                Forms\Components\TextInput::make('mssLastDate')
                    ->maxLength(40),
                Forms\Components\TextInput::make('google_reviews_ws')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('chatbot')
                    ->maxLength(10)
                    ->default('false'),
                Forms\Components\TextInput::make('server')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('blog_id_new')
                    ->numeric()
                    ->default(0),
                Forms\Components\DateTimePicker::make('data_cached_at'),
                Forms\Components\TextInput::make('groundhogg_id')
                    ->numeric(),
                Forms\Components\TextInput::make('bugherd_id')
                    ->numeric(),
                Forms\Components\TextInput::make('overseasteam')
                    ->required()
                    ->maxLength(40)
                    ->default('unknown'),
                Forms\Components\TextInput::make('bugherd_api')
                    ->maxLength(40),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dateAdded')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('colorScheme')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_head')
                    ->getStateUsing(fn ($record) => '#' . $record->color_head)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_framing')
                    ->getStateUsing(fn ($record) => '#' . $record->color_framing)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_section')
                    ->getStateUsing(fn ($record) => '#' . $record->color_section)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_line')
                    ->getStateUsing(fn ($record) => '#' . $record->color_line)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_text')
                    ->getStateUsing(fn ($record) => '#' . $record->color_text)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_bkgrd')
                    ->getStateUsing(fn ($record) => '#' . $record->color_bkgrd)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_input')
                    ->getStateUsing(fn ($record) => '#' . $record->color_input)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color_listtext')
                    ->getStateUsing(fn ($record) => '#' . $record->color_listtext)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('short_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sitehide')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('website')
                    ->url(fn ($record) => (str_starts_with($record->website, 'http') ? $record->website : 'https://' . $record->website), true)
                    ->color('primary'),
                Tables\Columns\ToggleColumn::make('newsletterReady')
//                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('newsletter')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('number_locations')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('signature')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('signature_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('signature_phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('prompt_level')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_cell_phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('found_code')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('need_setup')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('use_referral')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('patient_list')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('md_list')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phase')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('blocking_cust')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('blocking_us')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('in_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('googleKey')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('wsonly')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tempsite')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('enhanced')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('arb')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('selfedit')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('x3')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('seotesturl')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('searchenabled')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('clicky')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('clickykey')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nlonly')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('newlook')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('x3nl')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('datequit')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('quitreason')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('responsible')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('facebookid')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('facebookurl')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('facebookfeed')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('facebook_locations')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('havestore')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('priority')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('servicelevel')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('wordpress')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('wpblogid')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('freshbooks')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mobilephase')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rms')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bom')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bomadmin')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('in_helpscout')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fid')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lrs')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('gplus_account')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('intercom_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ws_local_optimized')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('g5')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('g5theme')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('g5builder')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mssphase')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mssreviewmonth')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ncphase')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('oldwpblogid')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('oldlinknumber')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bptm')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('placeholder')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('prs')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('moderation')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('review_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('alertemail')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('alertemailapp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('domain_owner')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('videos_per_month')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('images_per_month')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('no_third_party_msg')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ssl_active')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('timezone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('txt180')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('prs_notification')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('review_notification')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('review_notification_receiver')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mssStartDate')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mssLastDate')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('google_reviews_ws')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('chatbot')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('server')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('blog_id_new')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('data_cached_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('groundhogg_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bugherd_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('overseasteam')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bugherd_api')
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
            'index' => Pages\ListPractices::route('/'),
            'create' => Pages\CreatePractice::route('/create'),
            'edit' => Pages\EditPractice::route('/{record}/edit'),
        ];
    }
}
