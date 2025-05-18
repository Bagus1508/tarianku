<?php

namespace App\Filament\Widgets;

use App\Models\QuizAnswer;
use App\Models\QuizResult;
use App\Models\QuizQuestion;
use Filament\Widgets\Widget;

class QuizActivityOverview extends Widget
{
    protected static string $view = 'filament.widgets.quiz-activity-overview';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalParticipation = QuizResult::distinct('name')->count('name');

        $averageScore = QuizAnswer::selectRaw('AVG(is_correct) as avg_score')->value('avg_score') * 100;

        $mostIncorrectQuestion = QuizAnswer::where('is_correct', false)
            ->selectRaw('quiz_question_id, COUNT(*) as total_wrong')
            ->groupBy('quiz_question_id')
            ->orderByDesc('total_wrong')
            ->first();

        $mostIncorrectQuestionText = $mostIncorrectQuestion
            ? QuizQuestion::find($mostIncorrectQuestion->quiz_question_id)?->question_text
            : '-';

        return [
            'totalParticipation' => $totalParticipation,
            'averageScore' => number_format($averageScore, 2),
            'mostIncorrectQuestion' => $mostIncorrectQuestionText,
        ];
    }
}
