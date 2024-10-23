<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Models\Education;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Name University'),
                TextInput::make('degree')
                    ->label('Degree')
                    ->required()
                    ->placeholder('Bachelor of Science'),
                TextInput::make('faculty')
                    ->label('Faculty')
                    ->required()
                    ->placeholder('Faculty of Computer Science'),
                TextInput::make('gpa')
                    ->label('GPA')
                    ->required()
                    ->placeholder('3.5'),
                DatePicker::make('start_date')
                    ->displayFormat('mm Y')
                    ->locale('id')
                    ->native(false)
                    ->required()
                    ->placeholder('dd/mm/yyyy'),
                DatePicker::make('end_date')
                    ->displayFormat('mm Y')
                    ->locale('id')
                    ->native(false)
                    ->required()
                    ->placeholder('dd/mm/yyyy'),
                FileUpload::make('photo')
                    ->label('Photo')
                    ->avatar()
                    ->imageEditor()
                    ->imageCropAspectRatio(1)
                    ->circleCropper()
                    ->columnSpanFull()
                    ->directory('education'),
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
                TextColumn::make('degree')
                    ->label('Degree'),
                TextColumn::make('faculty')
                    ->label('Faculty'),
                TextColumn::make('gpa')
                    ->label('GPA'),
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
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
