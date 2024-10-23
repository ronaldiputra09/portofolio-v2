<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use App\Models\Skill;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

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
                    ->directory('experiences'),
                TextInput::make('company')
                    ->label('Company')
                    ->required()
                    ->placeholder('Company Name'),
                TextInput::make('title')
                    ->label('Position')
                    ->required()
                    ->placeholder('Position Title'),
                TextInput::make('location')
                    ->label('Location')
                    ->required()
                    ->placeholder('Location'),
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'fulltime' => 'Full Time',
                        'parttime' => 'Part Time',
                        'internship' => 'Internship',
                        'freelance' => 'Freelance',
                        'contract' => 'Contract',
                    ])
                    ->required()
                    ->placeholder('Select Type'),
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
                    ->disabled(fn(callable $get) => $get('is_current')),
                Toggle::make('is_current')
                    ->label('Current Now')
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('end_date', null))
                    ->columnSpanFull(),
                Select::make('skills')
                    ->label('Skills')
                    ->searchable()
                    ->options(
                        Skill::all()->pluck('name', 'id')->toArray()
                    )
                    ->multiple()
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Select Skills'),
                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->placeholder('Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Photo'),
                TextColumn::make('company')
                    ->label('Company'),
                TextColumn::make('title')
                    ->label('Position'),
                TextColumn::make('location')
                    ->label('Location'),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'fulltime' => 'Full Time',
                        'parttime' => 'Part Time',
                        'internship' => 'Internship',
                        'freelance' => 'Freelance',
                        'contract' => 'Contract',
                        default => 'Unknown',
                    }),
                TextColumn::make('start_date')
                    ->label('Start Date'),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->default('Current Now'),
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
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
