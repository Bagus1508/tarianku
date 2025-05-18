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
use App\Models\QuizQuestion;
use App\Models\QuizQuestionOption;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;

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
        $isCreating = $form->getOperation() === 'create';
        $questions = QuizQuestion::with('options')->get();

        return $form->schema([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->columnSpanFull(),

            $isCreating
                ? Repeater::make('answers')
                ->schema([
                    TextInput::make('question_text')
                        ->label('Pertanyaan')
                        ->disabled()
                        ->dehydrated(false)
                        ->columnSpanFull(),

                    Hidden::make('quiz_question_id')->required(),

                    Select::make('quiz_option_id')
                        ->label('Jawaban')
                        ->options(function ($get) {
                            return \App\Models\QuizQuestionOption::where('quiz_question_id', $get('quiz_question_id'))
                                ->pluck('option_text', 'id');
                        })
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, $set) {
                            $option = \App\Models\QuizQuestionOption::find($state);
                            $set('is_correct', $option?->is_correct ?? false);
                        })
                        ->columnSpanFull(),

                    Toggle::make('is_correct')
                        ->label('Benar?')
                        ->disabled()
                        ->dehydrated()
                        ->columnSpanFull(),

                    TextInput::make('time_taken')
                        ->label('Waktu (detik)')
                        ->numeric()
                        ->required()
                        ->columnSpanFull(),
                ])
                ->default(function () {
                    return \App\Models\QuizQuestion::all()->map(function ($q) {
                        return [
                            'quiz_question_id' => $q->id,
                            'question_text' => $q->question_text,
                            'quiz_option_id' => null,
                            'is_correct' => false,
                            'time_taken' => 0,
                        ];
                    })->toArray();
                })
                ->columns(1)
                ->columnSpanFull()
                ->disableItemCreation()
                ->disableLabel()
                : Repeater::make('answers')
                ->relationship('answers')
                ->schema([
                    Placeholder::make('question_text')
                        ->label('Pertanyaan')
                        ->content(function ($record) {
                            return $record?->question?->question_text ?? '-';
                        })
                        ->columnSpanFull(),

                    Hidden::make('quiz_question_id')->required(),

                    Select::make('quiz_option_id')
                        ->label('Jawaban')
                        ->options(function ($get) {
                            return \App\Models\QuizQuestionOption::where('quiz_question_id', $get('quiz_question_id'))
                                ->pluck('option_text', 'id');
                        })
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, $set) {
                            $option = \App\Models\QuizQuestionOption::find($state);
                            $set('is_correct', $option?->is_correct ?? false);
                        })
                        ->columnSpanFull(),

                    Toggle::make('is_correct')
                        ->label('Benar?')
                        ->disabled()
                        ->dehydrated()
                        ->columnSpanFull(),

                    TextInput::make('time_taken')
                        ->label('Waktu (detik)')
                        ->numeric()
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(1)
                ->columnSpanFull()
                ->disableItemCreation()
                ->disableLabel(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_correct')
                    ->label('Benar'),

                TextColumn::make('total_questions')
                    ->label('Total Soal'),

                TextColumn::make('total_time')
                    ->label('Waktu (detik)')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
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

    public static function eagerLoadRelations(): array
    {
        return ['answers'];
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
