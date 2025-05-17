<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizQuestionResource\Pages;
use App\Filament\Resources\QuizQuestionResource\RelationManagers;
use App\Models\QuizQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use App\Models\Dance;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Validation\ValidationException;


class QuizQuestionResource extends Resource
{
    protected static ?string $model = QuizQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getPluralModelLabel(): string
    {
        return 'Bank Soal';
    }

    public static function getLabel(): string
    {
        return 'Bank Soal';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('dance_id')
                    ->label('Tarian')
                    ->relationship('dance', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('question_text')
                    ->label('Pertanyaan')
                    ->required(),

                TextInput::make('correct_answer')
                    ->label('Jawaban Benar')
                    ->required(),

                TextInput::make('points')
                    ->label('Poin')
                    ->numeric()
                    ->required(),

                Select::make('difficulty')
                    ->label('Tingkat Kesulitan')
                    ->options([
                        1 => 'Mudah',
                        2 => 'Sedang',
                        3 => 'Sulit',
                    ])
                    ->required(),

                Select::make('type')
                    ->label('Tipe Soal')
                    ->options([
                        1 => 'Tanpa Gambar',
                        2 => 'Dengan Gambar',
                    ])
                    ->required()
                    ->reactive(),

                FileUpload::make('attachment1')
                    ->label('Lampiran Gambar')
                    ->directory('quiz-question/attachments')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(2048),

                Repeater::make('options')
                    ->relationship()
                    ->label('Opsi Jawaban')
                    ->schema([
                        TextInput::make('option_text')
                            ->label('Jawaban')
                            ->required(),

                        Toggle::make('is_correct')
                            ->label('Benar?'),

                        FileUpload::make('attachment1')
                            ->label('Lampiran Gambar')
                            ->image()
                            ->required()
                            ->directory('quiz-question-option/attachments')
                            ->maxSize(2048)
                            ->visible(fn(callable $get) => $get('../../type') == 2), // Mengakses parent state "type"
                    ])
                    ->defaultItems(2)
                    ->minItems(2)
                    ->maxItems(5)
                    ->addActionLabel('Tambah Opsi')
                    ->columnSpan('full')
                    ->afterStateUpdated(function ($state) {
                        $count = collect($state)->where('is_correct', true)->count();

                        if ($count > 1) {
                            throw ValidationException::withMessages([
                                'options' => 'Hanya satu opsi jawaban yang boleh benar.',
                            ]);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dance.title')
                    ->label('Tarian')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('question_text')
                    ->label('Pertanyaan')
                    ->limit(50)
                    ->wrap()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('correct_answer')
                    ->label('Jawaban')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('points')
                    ->label('Poin')
                    ->sortable(),

                TextColumn::make('difficulty')
                    ->label('Kesulitan')
                    ->sortable()
                    ->getStateUsing(fn($record) => self::getDifficultyLabel($record->difficulty)),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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

    private static function getDifficultyLabel($difficulty)
    {
        $difficultyOptions = [
            1 => 'Mudah',
            2 => 'Sedang',
            3 => 'Sulit',
        ];

        return $difficultyOptions[$difficulty] ?? 'Unknown';
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
            'index' => Pages\ListQuizQuestions::route('/'),
            'create' => Pages\CreateQuizQuestion::route('/create'),
            'edit' => Pages\EditQuizQuestion::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Kuis';
    }
}
