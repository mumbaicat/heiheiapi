<?php
namespace app\index\controller;

use think\Controller;
use think\Validate;

use app\index\model\App as AppModel;

class App extends Controller{

    public function __construct(){
        parent::__construct();
        if(!user_checklogin()){
            $this->error('抱歉你尚未登录无法进行操作','index/index/login');
        }
    }

    public function app_insert(){
        $rule = [
            'name|应用名称' => 'require|max:20'
        ];
        $validate = new Validate($rule);
        $postData = input('post');
        if(!$validate->check($postData)){
            return makeReturnJson(400,$validate->getError());
        }
        $appModel = new AppModel();
        if($appModel->appCheckNameSame($postData['name'])){
            return makeReturnJson(400,'应用名称重复,请换一个吧');
        }
        $aid = $appModel->appInser($postData['name']);
        return makeReturnJson(400,'创建成功',['aid'=>$aid,'name'=>$postData['name']]);
    }

    public function app_delete(){
        $rule = [
            'aid|应用ID' => 'require|number'
        ];
        $validate = new Validate($rule);
        $postData = input('post.');
        if(!$validate->check($postData)){
            return makeReturnJson(400,$validate->getError());
        }
        $appModel = new AppModel();
        if(!$appModel->appCheckHave($postData['aid'])){
            return makeReturnJson(404,'应用不存在');
        }
        $appModel->appDelete($postData['aid']);
        return makeReturnJson(200,'删除成功');
    }

    public function app_update(){
        $rule = [
            'aid|应用id' => 'require|number',
            'name|应用名称' => 'require|max:120'
        ];
        $postData=input('post.');
        $postData['data']=htmlentities($_POST['data']);
        $validate= new Validate($rule);
        if(!$validate->check($postData)){
            return makeReturnJson(400,$validate->getError());
        }
        if(empty($postData['data']) or strlen($postData['data'])>2000){
            return makeReturnJson(400,'项目数据不能为空或超过2000字符');
        }
        $appModel = new AppModel();
        if($appModel->appUpdate($postData['aid'],$postData['name'],$postData['data'])){
            return makeReturnJson(200,'更新成功',['name'=>$postData['name'],'aid'=>$postData['aid']]);
        }else{
            return makeReturnJson(400,'未知错误',['name'=>$postData['name'],'aid'=>$postData['aid']]);
        }
    }

    public function app_one(){
        $rule=[
            'aid|应用ID' => 'require|number'
        ];
        $validate = new Validate($rule);
        $postData = input('post.');
        if(!$validate->check($postData)){
            return makeReturnJson(400,$validate->getError());
        }
        $appModel = new AppModel();
        $data = $appModel->appOneData($postData['aid']);
        return makeReturnJson(200,'获取成功',$data);
    }
    
    public function app_list(){
        $rule=[
            'uid|用户id' => 'require|number|number'
        ];
        $validate = new Validate($rule);
        $postData=input('post.');
        if(!$validate->check($postData)){
            return makeReturnJson(400,$validate->getError());
        }
        $appModel = new AppModel();
        $objectData = $appModel->appList($postData['uid']);
        return makeReturnJson(200,'获取成功',$objectData);
    }
}