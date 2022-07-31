<?php
namespace App\API;
use App\Controllers\QuizController;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\StudentQuiz;
use App\Models\StudentQuizDetail;

class QuizAPI extends QuizController{

    public function remove($id){
        Quiz::destroy($id);
        echoJson(['status'=>'ok'],true);
        die;
    }

    public function saveAdd($sbjid){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With");

        Quiz::insert([
            'name' => $_POST['name'],
            'subject_id' => $sbjid,
            'duration_minutes' => $_POST['duration'],
            'start_time' => $_POST['startTime'],
            'end_time' => $_POST['endTime'],
            'status' => isset($_POST['status']) ? '1':'0',
            'is_shuffle' => '0'
        ]);
        $qzid = Quiz::select('id')->orderByRaw('id DESC')->first()->id;
        $this->insertQuestions($qzid);
        echo json_encode(['status'=>'ok']);
    }

    public function saveEdit($qzid){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With");

        $quiz = Quiz::find($qzid);
        if (isset($_POST['name'])) $quiz->name = $_POST['name'];
        $quiz->duration_minutes = $_POST['duration'];
        $quiz->start_time = $_POST['startTime'];
        $quiz->end_time = $_POST['endTime'];
        $quiz->status = isset($_POST['status']) ? '1':'0';
        $quiz->is_shuffle = 0;
        $quiz->save();

        if (isset($_POST['name'])) {
            $listQuestion = Question::where("quiz_id", $qzid)->get();
            foreach ($listQuestion as $q) {
                $q->delete();
            }
        }
        $this->insertQuestions($qzid);
        echo json_encode(['status'=>'ok']);
    }

    function insertQuestions($qzid)
    {
        $questionIndex = 1;
        while (isset($_POST['questionContent' . $questionIndex])) {
            $data = [
                'content' => $_POST['questionContent' . $questionIndex],
                'quiz_id' => $qzid
            ];
            Question::insert($data);
            $questionId = Question::select('id')->orderByRaw('id DESC')->first()->id;

            $answerIndex = 0;
            while (isset($_POST['answerContent' . $answerIndex . 'Q' . $questionIndex])) {
                $data = [
                    'content' => $_POST['answerContent' . $answerIndex . 'Q' . $questionIndex],
                    'question_id' => $questionId,
                    'is_correct' => ($_POST['correctQ' . $questionIndex] == $answerIndex ? '1' : '0')
                ];
                Answer::insert($data);
                $answerIndex += 1;
            }

            $questionIndex += 1;
        }
    }

    //MAIN
    function getListQuiz($sbjid){
        if ($this->isAdmin())
            $quizs = Quiz::where('subject_id', $sbjid)->get();
        else
            $quizs = Quiz::where('subject_id', $sbjid)->where('status', 1)->get();
        
        foreach ($quizs as $quiz){
            $quiz->countQuestions = Question::where('quiz_id',  $quiz->id)->get()->count();
        }
        echoJson($quizs, true);
        die;
    }

    function getResult($qzid){
        $result = Quiz::select('*')->where('id', $qzid)->first();
        $result->countQuestions = Question::select( Question::raw('count(id) as c'))->where('quiz_id',$qzid)->first()->c;
        $result->subjectName = Subject::select('name')->where('id', $result->subject_id)->first()->name;

        $history = StudentQuiz::select(StudentQuiz::raw('score, time_to_sec(timediff(end_time, start_time)) count_time, reattemp'))->where('quiz_id', $qzid)->where('student_id', $_SESSION['user']['id'])->first();

        if (is_null($history)){
            $result->status = "Chưa làm";
            $result->score = 0;
            $result->count_time = 0;
            $result->reattemp = 0;
        } else {
            $result->status = "Đã làm";
            $result->score = $history->score;
            $result->count_time = $history->count_time;
            $result->reattemp = $history->reattemp;
        }
        $result->isOk =  $result->score >=0.5? "Đạt" : 'Chưa đạt';

        echoJson($result, true);
    }

    function getAnalytics($qzid){
        $data = StudentQuiz::select('users.name', 'users.email', 'student_quizs.score', 'student_quizs.reattemp')->join('users', 'student_quizs.student_id', '=', 'users.id')->where('quiz_id', $qzid)->get();
        echoJson($data, true);
    }

    // EDIT 

    function getListQuestionEdit($qzid){
        $questions = Question::where('quiz_id', $qzid)->get();
        foreach ($questions as $x) {
            $x->answers;
        }
        echoJson($questions);
    }

    // PLAY QUIZ

    function getListQuestion($qzid,$sqzid) {
        $questionDetails = Question::select('id', 'content')->where('quiz_id', $qzid)->get();

        foreach ($questionDetails as $i => $question) {
            $answer = Answer::select('id', 'content')->where('question_id',  $question->id)->get();
            $questionDetails[$i]->listAnswer = $answer;

            $answerChecked = StudentQuizDetail::select('answer_id')->where('question_id', $question->id)->where('student_quiz_id', $sqzid)->first();
                $questionDetails[$i]->answerChecked = !is_null($answerChecked) ? $answerChecked->answer_id : null;
        }

        echoJson($questionDetails, true);
    }

    function getQuizDetails($qzid){
        $quiz = Quiz::where('id', $qzid)->get();
        echoJson($quiz, true);
    }
    
    function checkTime($sqzid) {
        !isStudent() ? die : 0;

        $curentTime = getCurentTime();

        $student_quiz_id = $sqzid;

        if ($this->isEndStudentQuiz($student_quiz_id)) {
            (['timeRemaining'=>0]);
            die;
        }

        else {
            $model = StudentQuiz::find($student_quiz_id);
            $model->end_time = $curentTime;
            $model->save();

            $timeRemaining = StudentQuiz::select(StudentQuiz::raw("quizs.duration_minutes*60 - time_to_sec(timediff(student_quizs.end_time, student_quizs.start_time)) as timeRemaining"))
                                            ->join('quizs', 'student_quizs.quiz_id', '=', 'quizs.id')
                                            ->where('student_quizs.id', $student_quiz_id)
                                            ->first();
            is_null($timeRemaining) ? die : 0;
            
            if ($timeRemaining->timeRemaining <= 0) {
            
            }
        
            echoJson($timeRemaining);
            die;
        }
    }

    function submitAnswer($sqzid, $qstid, $ansid) {
        !isStudent() ? die : 0;

        if ($this->isEndStudentQuiz($sqzid)) {
            echoJson(['err' => 'The quiz is over, data is not update']);
            die;
        }

        $isSelected = StudentQuizDetail::where("student_quiz_id", $sqzid)->where('answer_id', $ansid)->first();
        if ($isSelected) {
            echoJson(['status' => 'not change']);
            die;
        }

        $selectedAnotherAnswer = StudentQuizDetail::where("student_quiz_id", $sqzid)->where('question_id', $qstid)->first();

        if ($selectedAnotherAnswer) {
            $model = StudentQuizDetail::find($selectedAnotherAnswer->id);
            $model->answer_id = $ansid;
            $model->save();
        } else {
            StudentQuizDetail::insert([
                "student_quiz_id" => $sqzid,
                "question_id" => $qstid,
                "answer_id" => $ansid
            ]);
        }
        $score = $this->calcScore($sqzid);
        $model = StudentQuiz::find($sqzid);
        $model->score = $score;
        $model->save();

        echoJson(['status' => 'update answer ok']);
        die;
    }

    function finishQuiz($sqzid){
        !isStudent() ? die : 0;

        if ($this->isEndStudentQuiz($sqzid)) {
            echoJson(['status'=> 'the quiz is over']);
            die;
        }

        $model = StudentQuiz::find($sqzid);
        $model->is_end = 1;
        $model->save();
        echoJson(['status'=> 'ok']);
        die;
    }
}
?>