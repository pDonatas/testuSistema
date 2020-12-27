<?php declare(strict_types=1);

namespace App\Http;

use App\Http\Repositories\TestRepository;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class Helpers {
    public static function countTestScore($id, $user_id)
    {
        $testAnswers = DB::table('testai_klausimai')->where('test_id', $id)->get();
        $score = 0;
        foreach($testAnswers as $ids) {
            $answers = DB::table('studento_atsakymai')
                ->where('user_id', $user_id)
                ->where('test_id', $id)
                ->where('question_id', $ids->question_id)
                ->get();
            $cAnswers = DB::table('teisingi_atsakymai')
                ->where('question_id', $ids->question_id)
                ->get();
            $correctAnswers = [];
            $studentAnswers = [];

            foreach ($answers as $answer) {
                $ans = Answer::find($answer->selection_id);
                if ($ans == null || !$ans) {
                    $ans = $answer->custom_answer;
                }
                array_push($studentAnswers, $ans);
            }

            foreach ($cAnswers as $answer) {
                $ans = Answer::find($answer->selection_id);
                if ($ans == null || !$ans) {
                    $ans = $answer->custom_answer;
                }
                array_push($correctAnswers, $ans);
            }

            $score += self::countQuestionScore($studentAnswers, $correctAnswers, Question::find($ids->question_id));
        }

        return $score;
    }

    public static function countQuestionScore(array $studentAnswers, array $correctAnswers, $question)
    {
        if (!empty($studentAnswers) && $correctAnswers == $studentAnswers) { // Viskas sutampa zjbs
            return $question->balas;
        } else {
            $correct = 0;
            foreach($studentAnswers as $sAnswer) {
                foreach ($correctAnswers as $cAnswer) {
                    if ($question->atsakymoTipas != 3) {
                        if ($sAnswer == $cAnswer) {
                            $correct++;
                        }
                    } else {
                        if (self::countSameWords($sAnswer, $cAnswer) >= 3) {
                            $correct++;
                        }
                    }
                }
            }
            if ($correct != 0 && $correct == count($correctAnswers)) {
                return $question->balas;
            }
        }

        return 0;
    }

    public static function countSameWords(string $sAnswer, string $cAnswer)
    {
        $sAnswer = strtolower($sAnswer);
        $cAnswer = strtolower($cAnswer);

        $studentWords = explode(' ', $sAnswer);
        $correctWords = explode(' ', $cAnswer);

        $match = 0;

        foreach($studentWords as $studentWord) {
            foreach($correctWords as $correctWord) {
                if ($studentWord == $correctWord) $match++;
            }
        }

        return $match;
    }

    public static function countQuestionsInCategory($id)
    {
        return Question::where('kategorija', $id)->count();
    }
}
