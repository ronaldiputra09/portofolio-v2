<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Faker\Core\File;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Name Project'),
                TextInput::make('link')
                    ->label('Link')
                    ->placeholder('https://example.com'),
                RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Description Project'),
                Select::make('experience_id')
                    ->label('Experience')
                    ->options(
                        Experience::all()->pluck('company', 'id')->toArray()
                    )
                    ->required()
                    ->placeholder('Select Skills'),
                Select::make('skills')
                    ->label('Skills')
                    ->searchable()
                    ->options(
                        Skill::all()->pluck('name', 'id')->toArray()
                    )
                    ->multiple()
                    ->required()
                    ->placeholder('Select Skills'),
                FileUpload::make('header')
                    ->label('Logo')
                    ->avatar()
                    ->imageEditor()
                    ->imageCropAspectRatio(1)
                    ->circleCropper()
                    ->directory('projects'),
                FileUpload::make('images')
                    ->label('Images')
                    ->multiple()
                    ->directory('projects'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('header')
                    ->label('Logo')
                    ->circular(),
                ImageColumn::make('images')
                    ->label('Images')
                    ->circular()
                    ->stacked(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('link')
                    ->label('Link'),
                TextColumn::make('experiences.company')
                    ->label('Experience'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
