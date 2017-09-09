<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 生成随机字符串
 * @param  integer $length 长度
 * @return string          生成的结果
 */
function randomKeys($length = 16) {
	$pattern = '0123456789abcdefghijklmnABCDEFGHIJKLMN';
	$return = '';
	for ($i = 0; $i < $length; $i++) {
		$return .= $pattern[rand(0, strlen($pattern) - 1)];
	}
	return $return;
}

/**
 * 生成返回Json
 * @param  int $code 用HTTP状态码
 * @param  string $msg  提示信息
 * @param  array  $data [description]
 * @return string
 */
function makeReturnJson($code, $msg, $data = []) {
	$return = [];
	$return['code'] = $code;
	$return['msg'] = $msg;
	$return['data'] = $data;
	return json_encode($return);
}

/**
 * 检测当前是否已登陆
 * @return bool 	已登陆返回true,否则返回false
 */
function userCheckLogin() {
	$originData = cookie('userInfo');
	if (!$originData) {
		return false;
	}
	$data = base64_decode($originData);
	$data = json_decode($data, true);
	if (empty($data['uid']) or empty($data['password'])) {
		return false;
	}
	if (!userCheckReally($data)) {
		return false;
	}
	return true;
}

/**
 * 检测密码是否正确
 * @param  array $data 在userCheckLogin函数中的userInfo
 * @return bool
 */
function userCheckReally($data) {
	$res = db('user')->where(['uid' => $uid])->find();
	if ($res['password'] != $data['password']) {
		cookie('userInfo', null);
		return false;
	}
	return true;
}