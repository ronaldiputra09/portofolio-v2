<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LicenseResource\Pages;
use App\Models\License;
use App\Models\Skill;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LicenseResource extends Resource
{
    protected static ?string $model = License::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')
                    ->label('Photo')
                    ->avatar()
                    ->imageEditor()
                    ->imageCropAspectRatio(1)
                    ->circleCropper()
                    ->columnSpanFull()
                    ->directory('licenses'),
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Name License'),
                TextInput::make('link')
                    ->label('URL')
                    ->required()
                    ->placeholder('https://example.com'),
                TextInput::make('credential')
                    ->label('Credential ID')
                    ->required()
                    ->placeholder('H3LLOW0RLD'),
                Select::make('skills')
                    ->label('Skills')
                    ->searchable()
                    ->options(
                        Skill::all()->pluck('name', 'id')->toArray()
                    )
                    ->multiple()
                    ->required()
                    ->placeholder('Select Skills'),
                DatePicker::make('start_date')
                    ->displayFormat('mm Y')
                    ->locale('id')
                    ->native(false)
                    ->required()
                    ->placeholder('mm/yyyy'),
                DatePicker::make('end_date')
                    ->displayFormat('mm Y')
                    ->locale('id')
                    ->native(false)
                    ->placeholder('mm/yyyy')
                    ->disabled(fn(callable $get) => $get('is_lifetime')),
                Toggle::make('is_lifetime')
                    ->label('Lifetime')
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('end_date', null))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Photo'),
                TextColumn::make('name')
                    ->label('Name'),
                TextColumn::make('link')
                    ->label('URL'),
                TextColumn::make('credential')
                    ->label('Credential ID'),
                TextColumn::make('start_date')
                    ->label('Start Date'),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->default('Lifetime'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLicenses::route('/'),
            'create' => Pages\CreateLicense::route('/create'),
            'edit' => Pages\EditLicense::route('/{record}/edit'),
        ];
    }
}
