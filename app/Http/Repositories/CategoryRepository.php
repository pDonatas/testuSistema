<?php declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\Question;

class CategoryRepository
{
    public function remove($id)
    {
        Question::where('kategorija', $id)->update([
            'kategorija' => 0
        ]);
    }
}
