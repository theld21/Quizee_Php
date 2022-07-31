<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\StudentQuiz;
use App\Models\StudentQuizDetail;
use App\Models\Subject;

class QuizController extends BaseController{

    public function index($sbjid)
    {
        $subjectName = Subject::select('name')->where('id', $sbjid)->first()->name;

        return view('quiz.quizs',[
            "header"=>true,
            "subjectName" => $subjectName,
            "sbjid"=>$sbjid
        ]);
    }

    public function formAddQuiz($sbjid, $count)
    {
        $subjectName = Subject::select('name')->where('id', $sbjid)->first()->name;

        return view('quiz.editForm',[
            "header"=>true,
            "action"=>"add",
            "subjectName" => $subjectName,
            "sbjid" => $sbjid,
            "count" => $count
        ]);
    }

    public function formEditQuiz($sbjid, $qzid){
        $subjectName = Subject::select('name')->where('id', $sbjid)->first()->name;
        $quizName = Quiz::select('name')->where('id', $qzid)->first()->name;

        return view('quiz.editForm',[
            "header"=>true,
            "action"=>"edit",
            "sbjid"=>$sbjid,
            "qzid"=>$qzid,
            "subjectName" => $subjectName,
            "quizName" => $quizName,
        ]);
    }

    function quizResult($qzid){
        $sqz = StudentQuiz::select("id")->where('student_id', $_SESSION['user']['id'])->where('quiz_id', $qzid)->first();
        $sqzid = $sqz ? $sqz->id : -1;

        if ($sqzid>0 && !$this->isEndStudentQuiz($sqzid)){
            header('location: ' . BASE_URL . 'quizs/lam-bai/' . $qzid);
            die;
        }

        return view('quiz.result',[
            "header" => true,
            "showBtn" => $this->isAvailableDeadline($qzid) ? 1 : 0,
            "qzid" => $qzid
        ]);
    }

    function quizAnalytics($qzid){
        return view('quiz.analytics',[
            "header"=>true,
            "qzid"=>$qzid
        ]);
    }

    function startQuiz($qzid) {
        if ($this->isAvailableDeadline($qzid)<=0){
            header('location: ' . BASE_URL . 'mon-hoc');
            die;
        } 

        $curentTime = getCurentTime();

        $StudentQuiz = StudentQuiz::where('quiz_id', $qzid)->where('student_id', $_SESSION['user']['id'])->first();

        if (is_null($StudentQuiz)) {
            StudentQuiz::insert([
                'student_id' => $_SESSION['user']['id'],
                'quiz_id' => $qzid,
                'start_time' => $curentTime,
                'end_time' => $curentTime,
                'score' => '0',
                'is_end' => '0'
            ]);
        } else if ($this->isEndStudentQuiz($StudentQuiz->id)) {
            $StudentQuizDetail = StudentQuizDetail::where("student_quiz_id", $StudentQuiz->id)->get();
            if (!is_null($StudentQuizDetail))
                foreach ($StudentQuizDetail as $sqd){
                    $sqd->delete();
                }

            $reattemp = StudentQuiz::select('reattemp')->where('quiz_id', $qzid)->where('student_id', $_SESSION['user']['id'])->first()->reattemp;

            $model = StudentQuiz::find($StudentQuiz->id);
            $model->start_time = $curentTime;
            $model->end_time = $curentTime;
            $model->score = 0;
            $model->is_end = 0;
            $model->reattemp = $reattemp+1;
            $model->save();
        }
        $StudentQuiz = StudentQuiz::select('id')->where('quiz_id', $qzid)->where('student_id', $_SESSION['user']['id'])->first();

        return view('quiz.playQuiz',[
            "StudentQuizId" => $StudentQuiz->id,
            "qzid"=>$qzid
        ]);
    }

    // Other function

    function isAvailableDeadline($quizId){
        $curentTime = getCurentTime();
        $check = Quiz::select("id")->where(Quiz::raw("time_to_sec(timediff(DATE_FORMAT(end_time,'%Y-%m-%d %H:%i:%s') ,'$curentTime'))"), '>', 0)->where(Quiz::raw("time_to_sec(timediff('$curentTime', DATE_FORMAT(end_time,'%Y-%m-%d %H:%i:%s')))"), '<', 0)->where('id', $quizId)->first();
        return !is_null($check) ? 1 : 0;
    }

    function isEndStudentQuiz($sqzid) {
        $isEnd = StudentQuiz::where('id', $sqzid)->first();
        if (empty($isEnd)) {
            return true;
        } elseif ($isEnd->is_end == 0) {
            $curentTime = getCurentTime();
            $check = StudentQuiz::select(StudentQuiz::raw("quizs.duration_minutes*60 - time_to_sec(timediff('$curentTime', student_quizs.start_time)) as timeRemaining"))->join('quizs', 'student_quizs.quiz_id', '=', 'quizs.id')->where('student_quizs.id', $sqzid)->first()->timeRemaining;

            if ($check <= 0) {
                $model = StudentQuiz::find($sqzid);
                $model->is_end = 1;
                $model->save();
                return true;
            } else
                return false;
        } else
            return true;
    }

    function calcScore($student_quiz_id) {
        $countCorrect = Answer::join('student_quiz_detail', 'answers.id', '=', 'student_quiz_detail.answer_id')->where('student_quiz_detail.student_quiz_id', $student_quiz_id)->where('answers.is_correct', 1)->get()->count();
        $sumQuestion = Question::join('student_quizs', 'questions.quiz_id', '=', 'student_quizs.quiz_id')->where('student_quizs.id', $student_quiz_id)->get()->count();

        return $countCorrect/$sumQuestion;
    }


}
