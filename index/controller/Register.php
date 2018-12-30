<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
 
class Register extends Controller
{
    public function index()
    {
    	return $this->fetch();
    } 
  public function register(){
        $param = input('post.');
    	if(empty($param['user_name'])){
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['user_pwd'])){
    		
    		$this->error('密码不能为空');
    	}
    	else{
    	$data=['user_name'=>$param['user_name'],'user_pwd'=>md5($param['user_pwd'])];
    	Db::table('users')->insert($data);
        }
    	
    	$this->redirect(url('login/index'));
    }

         

}