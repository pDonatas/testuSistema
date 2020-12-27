<?php declare(strict_types=1);

namespace App\Http;

use App\Http\Repositories\TestRepository;

class Helpers {
    protected TestRepository $testRepo;
    public function __construct(TestRepository $testRepository) {
        $this->testRepo = $testRepository;
    }

    public static function countTestScore($id, $user_id)
    {
        return 0;
    }

    public function countTestResult(int $userId, int $testId): int
    {
        $correctAnswers = $this->testRepo->getCorrectAnswers($userId, $testId);
        return count($correctAnswers);
    }
}
