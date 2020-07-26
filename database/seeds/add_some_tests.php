<?php

use App\Question;
use Illuminate\Database\Seeder;
use App\Test;

class add_some_tests extends Seeder
{



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataTests =[
            [
                'id' => 1,
                'id_crypt' => crypt(1,'7c'),
                'name' => 'Опитування - 1'
            ],
            [
                'id' => 2,
                'id_crypt' => crypt(2,'7c'),
                'name' => 'Опитування - 2'
            ],
            [
                'id' => 3,
                'id_crypt' => crypt(3,'7c'),
                'name' => 'Опитування - 3'
            ],
        ];

        foreach ($dataTests as $item) {
            Test::insert([
                'id' => $item['id'],
                'id_crypt' => $item['id_crypt'],
                'name' => $item['name'],
            ]);
        }

        $dataQuestions =[

            //Питання тесту - 1
            [
                'test_id' => '1',
                'text_q' => 'Питання 1',
            ],
            [
                'test_id' => '1',
                'text_q' => 'Питання 2',
            ],
            [
                'test_id' => '1',
                'text_q' => 'Питання 3',
            ],

            //Питання тесту - 2
            [
                'test_id' => '2',
                'text_q' => 'Питання 1',
            ],
            [
                'test_id' => '2',
                'text_q' => 'Питання 2',
            ],
            [
                'test_id' => '2',
                'text_q' => 'Питання 3',
            ],

            //Питання тесту - 3
            [
                'test_id' => '3',
                'text_q' => 'Питання 1',
            ],
            [
                'test_id' => '3',
                'text_q' => 'Питання 2',
            ],
            [
                'test_id' => '3',
                'text_q' => 'Питання 3',
            ],
        ];

        foreach ($dataQuestions as $item) {
            Question::insert([
                'test_id' => $item['test_id'],
                'text_q' => $item['text_q'],
            ]);
        }

    }


}
