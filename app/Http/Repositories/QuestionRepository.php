<?php declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class QuestionRepository
{
    /*
     * Funkcija, kuri grąžina klausimus išdėliotus atsitiktine tvarka
     */
    public function getQuestions(int $id): array
    {
        $data = [];
        $test = Test::find($id);
        $teacher = User::find($test->destytojas);
        array_push($data, $test);
        array_push($data, $teacher);
        $questions = [];
        if ($test->category == null) {
            $testAnswers = DB::table('testai_klausimai')->where('test_id', $id)->get();
            foreach ($testAnswers as $ids) {
                $question = [
                    'question' => Question::find($ids->question_id),
                    'answers' => Answer::where('klausimas_id', $ids->question_id)->get()
                ];
                array_push($questions, $question);
            }
            array_push($data, [
                'questions' => $questions
            ]);
        } else {
            $categories = explode(",", $test->category);
            foreach ($categories as $category) {
                $q = Question::where('kategorija', $category)->get();
                foreach($q as $quest) {
                    $question = [
                        'question' => $quest,
                        'answers' => Answer::where('klausimas_id', $quest->id)->get()
                    ];
                    array_push($questions, $question);
                }
            }
            array_push($data, [
                'questions' => $questions
            ]);
        }

        return $data;
    }

    public function saveUserAnswers(int $questionId, array $answers, int $test)
    {
        $question = Question::find($questionId);
        if ($answers[0] != null) {
            $answers = explode(",", $answers[0]);
            foreach ($answers as $answer) {
                if ($question->atsakymoTipas == 3) {
                    DB::table('studento_atsakymai')->insert([
                        'user_id' => Auth::id(),
                        'question_id' => $questionId,
                        'custom_answer' => $answer,
                        'test_id' => $test
                    ]);
                } else {
                    DB::table('studento_atsakymai')->insert([
                        'user_id' => Auth::id(),
                        'question_id' => $questionId,
                        'selection_id' => $answer,
                        'test_id' => $test
                    ]);
                }
            }
        }
    }

    public function getSelectedAnswers($id, $user)
    {
        $data = [];
        $test = Test::find($id);
        $teacher = User::find($test->destytojas);
        $student = User::find($user);
        array_push($data, $test);
        array_push($data, $teacher);
        array_push($data, $student);
        $questions = [];
        if ($test->category == null) {
            $testAnswers = DB::table('testai_klausimai')->where('test_id', $id)->get();
        } else {
            $testAnswers = explode(",", $test->category);
        }
        foreach ($testAnswers as $ids) {
            if ($test->category != null) {
                $questionId = $ids;
            } else {
                $questionId = $ids->question_id;
            }
            $answers = DB::table('studento_atsakymai')
                ->where('user_id', $user)
                ->where('test_id', $id)
                ->where('question_id', $questionId)
                ->get();
            $cAnswers = DB::table('teisingi_atsakymai')
                ->where('question_id', $questionId)
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

            $question = [
                'question' => Question::find($questionId),
                'answers' => $studentAnswers,
                'correctAnswers' => $correctAnswers,
                'score' => $this->countQuestionScore($studentAnswers, $correctAnswers, Question::find($questionId))
            ];
            array_push($questions, $question);
        }
        array_push($data, [
            'questions' => $questions
        ]);

        return $data;
    }

    public function countQuestionScore(array $studentAnswers, array $correctAnswers, $question)
    {
        if (!empty($studentAnswers) && $correctAnswers == $studentAnswers) { // Viskas sutampa zjbs
            return $question->balas;
        } else {
            $correct = 0;
            foreach ($studentAnswers as $sAnswer) {
                foreach ($correctAnswers as $cAnswer) {
                    if ($question->atsakymoTipas != 3) {
                        if ($sAnswer == $cAnswer) {
                            $correct++;
                        }
                    } else {
                        if ($this->countSameWords($sAnswer, $cAnswer) >= 3 || $this->countSameWords($sAnswer, $cAnswer) == count(explode(' ', $sAnswer))) {
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

    private function countSameWords(string $sAnswer, string $cAnswer)
    {
        $sAnswer = strtolower($sAnswer);
        $cAnswer = strtolower($cAnswer);

        $studentWords = explode(' ', $sAnswer);
        $correctWords = explode(' ', $cAnswer);

        $match = 0;

        foreach ($studentWords as $studentWord) {
            foreach ($correctWords as $correctWord) {
                if ($studentWord == $correctWord) $match++;
            }
        }

        return $match;
    }

    public function removeCategories($id)
    {

    }

    public function setAnswers(Question $question, $answers, $correct)
    {
        $now = date("Y-m-d H:i:s");
        if ($answers !== null) {
            $answers = explode(';', $answers);
            foreach ($answers as $answer) {
                DB::table('pasirinkimo_variantai')->insert([
                    'pavadinimas' => $answer,
                    'klausimas_id' => $question->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }
        $correct = explode(';', $correct);

        foreach ($correct as $answer) {
            if ($question->atsakymoTipas != 3) {
                $id = DB::table('pasirinkimo_variantai')->where([
                    'pavadinimas' => $answer,
                    'klausimas_id' => $question->id
                ])->select('id')->first();
                if ($id != null) {
                    DB::table('teisingi_atsakymai')->insert([
                        'selection_id' => $id->id,
                        'question_id' => $question->id,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            } else {
                DB::table('teisingi_atsakymai')->insert([
                    'custom_answer' => $answer,
                    'question_id' => $question->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }
    }

}
