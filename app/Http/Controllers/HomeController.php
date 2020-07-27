<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function error(){
        return "You need to know the url questionnaire ... ";
    }

    public function testrun(Request $request){
        $data = json_decode($request->getContent(), true);
        return $this->answerStore($data);
    }

    public function listtestsandanswers(){

        $tests = Test::leftjoin('questions', 'tests.id', '=', 'questions.test_id')
            ->leftjoin('answers', 'tests.id', '=', 'answers.test_id')
            ->select('tests.name','questions.text_q','answers.answer','answers.id')
            ->get()->toArray();

        $ans = [];
        foreach ($tests as $item){
            $ans[$item['name']]['questions'][]=$item['text_q'];
            $ans[$item['name']]['questions'] = array_unique($ans[$item['name']]['questions']);
            $ans[$item['name']]['answers']['id:'.$item['id']]=unserialize($item['answer']);
        }

            return json_encode($ans);
    }

    public function stat1(){

        $testsAll = Test::all()->count();

        $testsAns = $tests = Test::join('answers', 'tests.id', '=', 'answers.test_id')
            ->select('tests.id')->get()->unique()->count();

        $ans = [];
        $ans['series']['type'] = 'pie';
        $ans['series']['name'] = 'Quotient tests ans to tests all';
        $ans['series']['data'] =
            [
                ['tests All', $testsAll],
                ['tests ans', $testsAns],
            ];

        return json_encode($ans);
    }

    public function stat2(){

        $tests = Test::leftjoin('answers', 'tests.id', '=', 'answers.test_id')
            ->select('tests.name','answers.answer','answers.id')
            ->get()->toArray();

        $ans = [];
        foreach ($tests as $item){
            if($item['id'])$ans[$item['name']]['answers']['id:'.$item['id']]=1;
             else $ans[$item['name']]['answers']=[];
        }

//        dd($ans);

        $response = ['title'=>"bar chart"];
        foreach ($ans as $key => $val){
            $response['data'][] = ['label'=>$key, 'value'=>count($val['answers'])];
        }
//        dd($response);

        return json_encode($response);
    }

    public function showtest($test_identifier){

        $tests = Test::join('questions', 'tests.id', '=', 'questions.test_id')
            ->select('tests.name','questions.text_q')->where('id_crypt',$test_identifier)
            ->get();

        if(!$tests->isEmpty()){
            $test = [];
            $test['Test_name'] = $tests[0]->name;

            $questions = [];
            foreach ($tests as $item){
                $questions[]=$item->text_q;
            }

            $test['Questions']=$questions;
            return json_encode($test);
        }
        else return "Test not found";
    }

    public function createtest(Request $request){
        $data = json_decode($request->getContent(), true);

        $test = new Test();

        if($data)  $test->name = $data['test_name'];
        else $test->name = 'test';
        $test->id_crypt='';
        $test->save();
        $id = $test->id;
        $t = Test::find($id);
        $t->id_crypt=str_replace("/","*",crypt($id,'7c'));
        $t->save();

        foreach ($data['questions'] as $item){
          $question = new Question;
          $question->test_id = $id;
          $question->text_q = $item;
          $question->save();
        }

      return 'Test created, test identifier: '.$t->id_crypt;
    }

    public function answerStore($data)
    {
        $validator = Validator::make($data, [
            'answer' => 'required',
        ]);

        if ($validator->passes()){
            $id_crypt = $data['link'];
            $ans =  $data['answer'];
            $test = Test::where('id_crypt',$id_crypt)->get();
            $answer = new Answer();
            $answer->test_id = $test[0]->id;
            $answer->answer = serialize($ans);
            $answer->save();
            return "Answers save and testing complete ... ";
        }
        return Response::json(['errors' => $validator->errors()]);
    }
}
