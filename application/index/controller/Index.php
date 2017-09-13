<?php
namespace app\index\controller;

use app\index\model\App as AppModel;

use think\Controller;
use think\Validate;
use think\Db;

class Index extends Controller {

	public function __construct() {
		parent::__construct();
		$whiteList = ['index', 'login', 'register', 'app_one'];
		if (!in_array($this->request->action(), $whiteList)) {
			if (!userCheckLogin()) {
				$this->error('抱歉你尚未登录无法进行操作', 'index/index/login');
			}
			$uid = userUID();
			$user['uid']=$uid;
			$data = Db::name('user')->where(['uid'=>$uid])->find();
			$user['name']=$data['name'];
			$this->assign('user',$user);
		}
	}

	public function index() {
		
		if(userCheckLogin()){
			$this->redirect('index/index/app_home');
		}else{
			return $this->fetch();
		}
	}

	public function login() {
		return $this->fetch();
	}

	public function register() {
		return $this->fetch();
	}

	public function app_home() {
		if(!$this->request->isPjax()){
			$this->view->engine->layout('index/layout');
		}
		return $this->fetch();
	}

	public function app_list() {

		$uid = userUID();

		$appModel = new AppModel();
		$data = $appModel->appList($uid);

		if(!$this->request->isPjax()){
			$this->view->engine->layout('index/layout');
		}
		$this->assign('data', $data);
		return $this->fetch();
	}

	public function app_insert() {
		if(!$this->request->isPjax()){
			$this->view->engine->layout('index/layout');
		}
		return $this->fetch();
	}

	public function app_update() {
		$aid = input('aid/d');
		if (!$aid or $aid <= 0) {
			$this->error('aid异常');
		}
		$appModel = new AppModel();
		$data = $appModel->appOneData($aid);
		if(!$this->request->isPjax()){
			$this->view->engine->layout('index/layout');
		}
		$this->assign('data', $data);
		return $this->fetch();
	}

	public function app_one() {
		$rule = [
			'appkey|秘钥' => 'require|max:16',
			'aid|应用ID' => 'require|number',
		];
		$validate = new Validate($rule);
		$postData = $this->request->param();
		if (!$validate->check($postData)) {
			return makeReturnJson(400, $validate->getError());
		}
		$appModel = new AppModel();
		if (!$appModel->appCheckReally($postData['aid'], $postData['appkey'])) {
			return makeReturnJson(400, '应用ID或者秘钥不具有真实性');
		}
		$data = $appModel->appOneData($postData['aid']);
		if (input('post.all')) {
			return makeReturnJson(200, '获取成功', $data['data']);
		} else {
			return $data['data'];
		}
	}
}
