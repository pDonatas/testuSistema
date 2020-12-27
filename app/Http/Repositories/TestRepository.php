<?php declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\Test;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TestRepository
{
    /*
     * Funkcija, kuri grąžina vartotojo atsakytus testus
     */
    public function getUserTests(int $id): Collection
    {
        return DB::table('testai_vartotojai')
            ->join('testas', 'testai_vartotojai.test_id', '=', 'testas.id')
            ->where('testai_vartotojai.user_id', $id)
            ->select('testas.*', 'testai_vartotojai.atlikimoData')
            ->get();
    }
    /*
     * Funkcija, kuri grąžina vartotojui galimus atsakyti testus
     */
    public function getAvailableTestsForUser(int $id)
    {
        $done = $this->getUserTests($id)->map(function ($test) {
            return $test->id;
        });
        if (count($done) > 0) {
            return Test::all()->except($done->toArray());
        } else {
            return Test::all();
        }
    }

    /*
     * Funkcija, kuri grąžina vartotojo teisingai atskaytus klausimus
     */
    public function getCorrectAnswers(int $userId, int $testId)
    {
        return DB::table('klausimas')
            ->join('pasirinkimo_variantai', 'klausimas.id', '=', 'pasirinkimo_variantai.klausimas_id')
            ->join('teisingi_atsakymai', 'pasirinkimo_variantai.id', '=', 'teisingi_atsakymai.selection_id')
            ->join('studento_atsakymai', 'studento_atsakymai.selection_id', '=', 'teisingi_atsakymai.selection_id')
            ->join('testai_klausimai', 'testai_klausimai.question_id', '=', 'klausimas.id')
            ->where('studento_atsakymai.user_id', $userId)
            ->where('testai_klausimai.test_id', $testId)
            ->select('klausimas.balas')
            ->get();
    }

    public function endUserTest(?int $user, int $test)
    {
        DB::table('testai_vartotojai')
            ->insert([
                'user_id' => $user,
                'test_id' => $test,
                'atlikimoData' => date("Y-m-d H:i:s"),
                'atliktas' => true
            ]);
    }

    public function isTestAlreadyDone(?int $user, int $test)
    {
        return DB::table('testai_vartotojai')->where('user_id', $user)->where('test_id', $test)->exists();
    }

    public function getAllTestTries($id)
    {
        return DB::table('testai_vartotojai')->where('test_id', $id)->get();
    }
}
