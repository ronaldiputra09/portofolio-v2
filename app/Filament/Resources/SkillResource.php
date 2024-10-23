<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Models\Skill;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('icon')
                    ->label('Icon')
                    ->avatar()
                    ->imageEditor()
                    ->imageCropAspectRatio(1)
                    ->circleCropper()
                    ->columnSpanFull()
                    ->directory('skills'),
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Name Skill'),
                Select::make('level')
                    ->label('Level')
                    ->options([
                        0 => 'Beginner',
                        1 => 'Intermediate',
                        2 => 'Advanced',
                    ])
                    ->default(0)
                    ->required()
                    ->placeholder('Select Level'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')
                    ->label('Icon'),
                TextColumn::make('name')
                    ->label('Name'),
                SelectColumn::make('level')
                    ->label('Level')
                    ->options([
                        0 => 'Beginner',
                        1 => 'Intermediate',
                        2 => 'Advanced',
                    ]),
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
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
