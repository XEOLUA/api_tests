<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function relshipTestsQuestions()
    {
        return $this->hasMany('App\Question', 'test_id', 'id');
    }

    public function relshipTestsAnswers()
    {
        return $this->hasMany('App\Answer', 'test_id', 'id');
    }
}
