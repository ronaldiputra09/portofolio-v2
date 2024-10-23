<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->directory('profiles'),
                FileUpload::make('cover')
                    ->label('Cover')
                    ->imageEditor()
                    ->imageCropAspectRatio('16:9')
                    ->directory('profiles'),
                FileUpload::make('cv')
                    ->label('CV')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('profiles'),
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->placeholder('John Doe'),
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->placeholder('example@example.com'),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->required()
                    ->placeholder('081234567890'),
                Textarea::make('address')
                    ->label('Address')
                    ->required()
                    ->autosize()
                    ->rows(1)
                    ->placeholder('123 Main St, City, Country'),
                Select::make('gender')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->displayFormat('d F Y')
                    ->locale('id')
                    ->native(false)
                    ->required()
                    ->placeholder('dd/mm/yyyy'),
                TextInput::make('moto')
                    ->label('Moto')
                    ->required()
                    ->placeholder('Your moto here...'),
                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->placeholder('Tell us about yourself...'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->circular()
                    ->label('Photo'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
