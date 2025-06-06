<?php

namespace App\Filament\Resources\QuizResultResource\Pages;

use App\Filament\Resources\QuizResultResource;
use App\Models\QuizQuestion;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuizResult extends CreateRecord
{
    protected static string $resource = QuizResultResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil semua pertanyaan sekaligus dengan eager loading
        $questionIds = collect($data['answers'])->pluck('quiz_question_id')->unique();
        $questions = QuizQuestion::whereIn('id', $questionIds)->get()->keyBy('id');

        // Hitung statistik
        $data['total_correct'] = collect($data['answers'])
            ->filter(fn($answer) => $answer['is_correct'] ?? false)
            ->count();

        $data['total_questions'] = count($data['answers']);
        $data['total_time'] = collect($data['answers'])->sum('time_taken');

        // Hitung total poin dari jawaban benar
        $data['total_point'] = collect($data['answers'])
            ->filter(fn($answer) => $answer['is_correct'] ?? false)
            ->sum(function ($answer) use ($questions) {
                return $questions[$answer['quiz_question_id']]->points ?? 0;
            });

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $questionIds = collect($this->form->getState()['answers'])->pluck('quiz_question_id')->unique();
        $questions = QuizQuestion::whereIn('id', $questionIds)->get()->keyBy('id');
        $name = $this->form->getState()['name'];

        foreach ($this->form->getState()['answers'] as $answer) {
            $record->answers()->create([
                'user_name' => $name,
                'quiz_question_id' => $answer['quiz_question_id'],
                'quiz_option_id' => $answer['quiz_option_id'],
                'is_correct' => $answer['is_correct'],
                'time_taken' => $answer['time_taken'],
                'point_earned' => $answer['is_correct']
                    ? ($questions[$answer['quiz_question_id']]->points ?? 0)
                    : 0,
            ]);
        }
    }
}
