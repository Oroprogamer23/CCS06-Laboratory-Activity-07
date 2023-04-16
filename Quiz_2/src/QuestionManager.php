<?php

namespace App;

use App\Question;

class QuestionManager
{
    protected $question_bank;
    protected $answers;

    public function __construct()
    {
        $this->question_bank = [];
        $this->answers = [
            null,
            'c',
            'd',
            'a',
            'd',
            'c',
            'd',
            'c',
            'c',
            'c',
            'c'
        ];
    }

    public function initialize()
    {
        try {
            $questions_file = 'questions.json';
            $questions = file_get_contents($questions_file);
            $questions = json_decode($questions);

            foreach ($questions as $item) {
                $question = new Question(
                    $item->number,
                    $item->question,
                    $item->choices
                );
                array_push($this->question_bank, $question);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function retrieveQuestion($number)
    {
        if ($number > count($this->question_bank)) {
            return null;
        }

        if ($number < 0) {
            return null;
        }

        return $this->question_bank[$number - 1];
    }

    public function getQuestionSize()
    {
        return count($this->question_bank);
    }

    public function computeScore($answers)
    {
        $score = 0;

        foreach ($answers as $number => $answer) {
            if ($answer == $this->answers[$number]) {
                $score++;
            }
        }

        return $score;
    }
    public function Question($answers)
    {
        $z = 1;

        foreach ($answers as $number => $answer) {
            if ($answer == $this->answers[$number]) {               
                echo $z . "." . $answer . '<span style="color:blue"> (correct)</span>' . "<br>";
                $z++;
            } else {
                echo $z . "." . $answer . '<span style="color:red"> (incorrect)</span>'. "<br>";
                $z++;
            }
        }
    }
    public function downloadtestresult($answers){

        $result = fopen('result.txt' , 'w');
        $z = 1;
        
        fwrite($result, "Complete Name: " . $_SESSION['user_fullname']);
        fwrite($result, PHP_EOL);
        fwrite($result, "Email: " . $_SESSION['user_email']);
        fwrite($result, PHP_EOL);
        fwrite($result, "Birthdate: " . $_SESSION['user_birthdate']);
        fwrite($result, PHP_EOL);
        fwrite($result, "Score: " . $_SESSION['Score'] . "of" . $_SESSION['Qnumber']);
        fwrite($result, PHP_EOL);
        fwrite($result, "Answers:");
    
        foreach($_SESSION['answers'] as $number => $answer){
            if($answer == $this->answers[$number]){
                fwrite($result, $z . ". " . $answer . " (correct)");
                fwrite($result, PHP_EOL);
                $z++;
    
            }else{
                fwrite($result, $z . ". " . $answer . " (incorrect)");
                fwrite($result, PHP_EOL);
                $z++;
            }
        }
        }
}
