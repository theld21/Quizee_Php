<?php
namespace App\API;
use App\Controllers\SubjectController;
use App\Models\Subject;
use App\Models\Quiz;

class SubjectAPI extends SubjectController{

    function getListSubject() {
        $subjects = Subject::all();
        foreach ($subjects as $subject){
            $subject->countQuizs = Quiz::select(Quiz::raw('COUNT(id) as count'))->where('subject_id',  $subject->id)->first()->count;
        }
        echoJson($subjects, true);
        die;
    }

    public function saveAdd(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With");

        $data = json_decode(file_get_contents("php://input"));
        Subject::insert([
            'name' =>$data->name,
            'author_id' => 1 //$_SESSION['user']['id']
        ]);
        echo json_encode(["status"=>'ok']);
        die;
    }

    public function saveEdit($id){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With");

        $data = json_decode(file_get_contents("php://input"));
        $model = Subject::find($id);
        $model->name = $data->name;
        $model->save();
        echo json_encode(["status"=>'ok']);
        die;
    }

    public function saveImage($id)
{
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With");

        if(isset($_FILES['file']['name'])){
            $extension = explode(".",$_FILES['file']['name']);
            $name = $id.".".end($extension);

            $location = "./public/img/subject/".$name;
            
            $imageFileType = strtolower(pathinfo($location,PATHINFO_EXTENSION));
         
            $valid_extensions = array("jpg","jpeg","png");
         
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                    $sbj = Subject::find($id);
                    $sbj->img = $name;
                    $sbj->save();
                    echo json_encode([
                        "status"=>"ok",
                        "name"=>$name
                    ]);
                    die;
                }
            }
            echo json_encode([
                "status"=>"err"
            ]);
            exit;
        }

        echo json_encode(["status"=>'ok']);
         
         echo 0;
    }

    public function remove($id){
        $sbj = Subject::find($id);
        if ($sbj->img!="default.jpg") {
            unlink("./public/img/subject/".$sbj->img);
        }
        $sbj->delete();
        echoJson(['status'=>'ok'],true);
        die;
    }
}
?>