<?php

namespace App\Http\Controllers;

use App\Http\Repositories\QuestionRepository;
use App\Http\Repositories\TestRepository;
use App\Models\Category;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestsController extends Controller
{
    protected TestRepository $testRepo;
    protected QuestionRepository $questionRepo;
    public function __construct(TestRepository $testRepo, QuestionRepository $questionRepo) {
        $this->testRepo = $testRepo;
        $this->questionRepo = $questionRepo;
    }

    /*
     * Sąrašo rodymo metodas
     */
    public function index()
    {
        $tests = $this->testRepo->getAvailableTestsForUser(Auth::id());
        return view('tests.index', compact('tests'));
    }

    /*
     * Sąrašo rodymo metodas
     */
    public function show()
    {
        $tests = Test::all();
        return view('tests.teacher.index', compact('tests'));
    }

    /*
     * Sąrašo rodymo metodas
     */
    public function done()
    {
        $tests = $this->testRepo->getUserTests(Auth::id());
        return view('tests.done', compact('tests'));
    }

    public function beginTest($id)
    {
        if ( $this->testRepo->isTestAlreadyDone(Auth::id(), $id) ) {
            return redirect(route('showTest', $id));
        }
        $questions = $this->questionRepo->getQuestions($id);
        return view('tests.test', compact('questions'));
    }

    public function showTest($id)
    {
        if ( !$this->testRepo->isTestAlreadyDone(Auth::id(), $id) ) {
            return redirect(route('beginTest', $id));
        }

        $questions = $this->questionRepo->getSelectedAnswers($id, Auth::id());
        return view('tests.show', compact('questions'));
    }

    public function endTest(Request $request, $id)
    {
        if ( $this->testRepo->isTestAlreadyDone(Auth::id(), $id) ) {
            return redirect(route('tests.done'));
        }
        $data = $request->toArray();
        foreach($data as $key => $value) {
            if ($key == "_token") continue;
            $questionId = (int)explode('-', $key)[1];
            $this->questionRepo->saveUserAnswers($questionId, $value, $id);
        }
        $this->testRepo->endUserTest(Auth::id(), $id);

        return redirect(route('tests.done'));
    }

    // Testų rezultatų view'as
    public function summary($id) {
        $tests = $this->testRepo->getAllTestTries($id);
        return view('tests.teacher.summary', ['tries' => $tests, 'test' => Test::find($id)]);
    }

    public function showUserTest($testId, $userId)
    {
        $questions = $this->questionRepo->getSelectedAnswers($testId, $userId);
        return view('tests.show', compact('questions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tests.teacher.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $test = new Test();
        $test->fill([
            'pavadinimas' => $request->get('pavadinimas'),
            'destytojas' => $request->get('destytojas'),
            'category' => implode(",", $request->get("category"))
        ]);
        $test->save();

        return json_encode($test);
    }

}
