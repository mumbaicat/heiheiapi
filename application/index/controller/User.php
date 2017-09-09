<?php
namespace app\index\controller;

use think\Controller;
use think\Validate;

use app\index\model\User as UserModel;

class User extends Controller {
	public function user_login() {
        if(userCheckLogin()){
            $this->error('你已登陆了','index/index/index');
        }
        $rule=[
            'username|用户名' => 'require|max:20',
            'password|密码' => 'require|max:20'
        ];
        $validate = new Validate($rule);
        $postData = input('post.');
        if(!$validate->check($postData)){
            return makeReturnJson(400,$validate->getError());
        }
        $userModel = new UserModel();
        if(!$userModel->userCheckPassword($postData['password'])){
            return makeReturnJson(400,'密码错误');
        }
        $userInfo=[
            'uid'=>1,
            'password'=>'666'
        ]; 
        cookie('userInfo',base64_encode((json_encode($userInfo)),3600*24*7);
        return makeReturnJson(200,'登陆成功');
	}

	public function user_logout() {
        cookie('userInfo',null); 
        return makeReturnJson(200,'注销成功');
	}

	public function user_insert() {
        if(userCheckLogin()){
            $this->error('你已登陆了','index/index/index');
        }
        if(cookie('registerLock')==true){
            return makeReturnJson(400, '你已经注册过了请不要重复注册');
        }
		$rule = [
			'name|用户名' => 'require|max:20',
			'password|密码' => 'require|max:20',
			'againpassword|再次输入密码' => 'require|max:20',
			'email|电子邮箱' => 'require|email|max:20',
		];
		$validate = new Validate($rule);
		$postData = input('post.');
		if (!$validate->check($postData)) {
			return makeReturnJson(400, $validate->getError());
		}
		if ($postData['password'] != $postData['againpassword']) {
			return makeReturnJson(400, '两次密码不相同');
		}
        if(!$userModel->userCheckRepeat()){
            return makeReturnJson(400,$userModel->getError());
        }
		$userModel = new UserModel();
		$uid = $userModel->userInsert($postData['name'], $postData['password'], $postData['email']);
        cookie('registerLock',true);
		return makeReturnJson(200, '注册成功', ['uid' => $uid]);
	}
}