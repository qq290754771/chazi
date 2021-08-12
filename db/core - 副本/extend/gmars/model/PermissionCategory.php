<?php
/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-05-09 20:42:39
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-09 21:40:53
 */
/**
 * Created by WeiYongQiang.
 * User: weiyongqiang <hayixia606@163.com>
 * Date: 2019-04-17
 * Time: 22:50
 */

namespace gmars\model;


use think\Db;
use think\Exception;

class PermissionCategory extends Base
{

    /**
     * 编辑权限分组
     * @param $data
     * @return $this
     * @throws Exception
     */
    public function saveCategory($data = [])
    {
        if (!empty($data)) {
            $this->data($data);
        }
        $validate = new \gmars\validate\PermissionCategory();
        if (!$validate->check($this)) {
            throw new Exception($validate->getError());
        }
        $data = $this->getData();
        if (isset($data['id']) && !empty($data['id'])) {
            $this->isUpdate(true);
        }
        $this->save();
        return $this;
    }

    /**
     * 删除权限分组
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function delCategory($id)
    {
        $where = [];
        if (is_array($id)) {
            $where['id'] = ['IN', $id];
        } else {
            $id = (int)$id;
            if (is_numeric($id) && $id > 0) {
                $where['id'] = $id;
            } else {
                throw new Exception('删除条件错误');
            }
        }
        // dump($this);
        if ($this->where($where)->delete() === false) {
           throw new Exception('删除权限分组出错');
        }
        return true;
    }

    /**
     * 获取权限分组
     * @param $where
     * @return array|\PDOStatement|string|\think\Collection|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCategory($where)
    {
        $model = Db::name('permission_category');
        if (is_numeric($where)) {
            return $model->where('id', $where)->find();
        } else {
            return $model->where($where)->select();
        }
    }

}