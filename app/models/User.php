<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class User extends BaseModel{
    protected $tableName = 'users';
    public static $err = '';
    public $timestamps = false;
    // protected $fillable = ['email', 'password', 'role_id'];

    public function isValidData($arr){
        if (!filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) return $this->setErr('Sai định dạng email');
        if (strlen($arr['password'])<4) return $this->setErr('Mật khẩu phải lớn hơn 4 ký tự');

        return 1;
    }

    public function setErr($str){
        User::$err = $str;
    }

    public function login($arr){
        if (!$this->isValidData($arr)) return;

        $user = $this->select('*')->where(['email', '=', $arr['email']])->first();
        if (is_null($user)) return $this->setErr('Email không tồn tại');
        if (!password_verify($arr['password'], $user->password)) return $this->setErr('Sai mật khẩu');

        return $user;
    }
}
?>