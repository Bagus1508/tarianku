<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResultResource\Pages;
use App\Filament\Resources\QuizResultResource\RelationManagers;
use App\Models\QuizResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

use App\Models\Question;

class QuizResultResource extends Resource
{
    protected static ?string $model = QuizResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function getPluralModelLabel(): string
    {
        return 'Hasil Kuis';
    }

    public static function getLabel(): string
    {
        return 'Hasil Kuis';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama')
                    ->required(),

                Select::make('quiz_question_id')
                    ->label('Pertanyaan')
                    ->relationship('quiz_question', 'question_text')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live(),

                Select::make('selected_option')
                    ->label('Jawaban Dipilih')
                    ->required()
                    ->options(function (callable $get) {
                        $questionId = $get('quiz_question_id');
                        if (!$questionId) return [];

                        return \App\Models\QuizQuestionOption::where('quiz_question_id', $questionId)
                            ->pluck('option_text', 'id')
                            ->toArray();
                    })
                    ->reactive()  // Penting: bikin langsung update state setelah berubah
                    ->afterStateUpdated(function ($state, callable $set) {
                        $option = \App\Models\QuizQuestionOption::find($state);
                        $set('is_correct', $option?->is_correct ?? false);
                    }),

                Toggle::make('is_correct')
                    ->label('Benar?')
                    ->reactive()
                    ->disabled(fn() => true),  // User tidak bisa ubah manual

                TextInput::make('time_taken')
                    ->label('Waktu (detik)')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('selectedOption.option_text')
                    ->label('Jawaban Dipilih')
                    ->sortable(),

                IconColumn::make('is_correct')
                    ->label('Benar?')
                    ->boolean(),

                TextColumn::make('time_taken')
                    ->label('Waktu (detik)')
                    ->sortable(),
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
            'index' => Pages\ListQuizResults::route('/'),
            'create' => Pages\CreateQuizResult::route('/create'),
            'edit' => Pages\EditQuizResult::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Kuis';
    }
}
