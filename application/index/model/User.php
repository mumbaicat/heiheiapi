<?php

namespace app\index\model;

use think\Model;

class User extends Model {

	protected $autoWriteTimestamp = true;
	protected $updatetime = false;
	protected $inert = ['status' => 1];

	protected $errorMsg;

	protected encryptPassword($password){
		return md5(hash($password));
	}

	public function getError(){
		return $this->errorMsg();
	}

	/**
	 * 添加一个用户
	 * @param  string $name     用户名唯一
	 * @param  srting $password 密码
	 * @param  string $email    电子邮箱唯一
	 * @return int              用户UID
	 */
	public function userInsert($name, $password, $email) {
		$data = [
			'name' => $name,
			'password'=> '',
			'email' => $email
		];
		$data['password'] = $this->encryptPassword($password);

		$uid = $this->save($daat);
		return $this->uid;
	}

	/**
	 * 检测用户是否存在
	 * @param  int $uid 用户的UID
	 * @return bool
	 */
	public function userCheckHave($uid){
		$data = $this->where(['uid'=>$uid])->find();
		if($data){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 检测用户名或电子邮箱是否可用
	 * @param  string $name  用户名
	 * @param  string $email 电子邮箱
	 * @return bool          可用返回true,重复返回false
	 */
	public function userCheckRepeat($name,$email){
		$data = $this->where(['name'=>$name])->find();
		if($data){
			$this->errorMsg = '用户名重复';
			return false;
		}
		$data = $this->where(['email'=>$email])->find();
		if($data){
			$this->errorMsg = '邮箱重复';
			return false;
		}
		return true;
	}

	/**
	 * 检测用户密码是否正确
	 * @param  int $uid      用户UID
	 * @param  string $password 用户密码明文
	 * @return bool
	 */
	public function userCheckPassword($uid,$password){
		$user = $this->where(['uid'=>$uid])->find();
		$encryptPassword = $this->encryptPassword($password)
		if($user['password']!=$encryptPassword){
			return false;
		}else{
			return true;
		}
	}
}
