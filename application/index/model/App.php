<?php

namespace app\index\model;

use think\Model;

class App extends Model {
	protected $autoWriteTimestamp = true;
	protected $insert = ['appkey'];

	protected function setAppkeyAttr($value) {
		return randomKeys(16);
	}

	/**
	 * 添加一个应用
	 * @param  string $name 应用名称
	 * @return int
	 */
	public function appInsert($name) {
		$data = ['name' => $name];
		$this->save($data);
		return $this->aid;
	}

    /**
     * 更新应用信息
     * @param  int $aid  应用aid
     * @param  string $name 应用名称
     * @param  string $data 应用数据
     * @return bool
     */
    public function appUpdate($aid,$name,$data){
        $data = [
            'name' => $name,
            'data' => $data
        ];
        if($this->where(['aid'=>$aid])->update($data)){
            return true;
        }else{
            return false;
        }
    }

	/**
	 * 删除一个应用
	 * @param  int $aid 应用ID
	 * @return bool
	 */
	public function appDelete($aid) {
		if ($this->where(['aid' => $aid])->delete()) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * 获取某一条应用数据
     * @param  int $aid 应用ID
     * @return object
     */
    public function appOneData($aid){
        $data = $this->where(['aid'=>$aid])->find();
        return $data;
    }

    /**
     * 列出某用户的所有应用信息
     * @param  int $uid 用户uid
     * @return object      结果对象集
     */
    public function appList($uid){
        $data = $this->where(['uid'=>$uid])->select();
        return $data;
    }

	/**
	 * 检测某个应用是否存在
	 * @param  int $aid 应用ID
	 * @return bool
	 */
	public function appCheckHave($aid) {
		$data = $this->where(['aid' => $aid])->find();
		if ($data) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * 检测应用名字是否重复
     * @param  string $name 应用名称
     * @return bool       重复返回true,不重复返回false
     */
    public function appCheckNameSame($name){
        $data = $this->where(['name'=>$name])->find();
        if($data){
            return true;
        }else{
            return false;
        }
    }
}
