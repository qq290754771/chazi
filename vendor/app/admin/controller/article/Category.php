<?php

namespace app\admin\controller\article;

use app\admin\controller\common\CommonAuth;
use app\admin\model\Permission;
use cool\Leftnav;
use think\Cache;

class Category extends CommonAuth
{

    public function index()
    {
        if (request()->isPost()) {
            $category_id = 'authRuleList' . input('category_id');
            $nav = new Leftnav();
            // dump($this->category);
            $data = $nav->authRule($this->category, '42');
            foreach ($data as $k => $v) {
                $data[$k]['module'] = db('module')->where('id', $v['moduleid'])->value('title');
            }
            // dump($data);
            return json(['data' => $data, 'code' => 1, 'message' => '操作完成']);
        } else {
            return view();
        }

    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if ($data['moduleid']) {
                $data['module'] = db('module')->where('id', $data['moduleid'])->value('name');
            }else{
                return $result = ['code' => 0, 'msg' => '请选择模型!'];
            }
            try {
                // 添加权限
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => 1,
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $data['pid'],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/index',
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[0] = $permission->id;

                $permission = $this->rbac->createPermission([
                    'name' => $data['name'].'-添加',
                    'description' => '添加',
                    'status' => 0,
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $id[0],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/add',
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[] = $permission->id;
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'].'-修改',
                    'description' => '修改',
                    'status' => 0,
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $id[0],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/edit',
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[] = $permission->id;
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'].'-删除',
                    'description' => '删除',
                    'status' => 0,
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $id[0],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/del',
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[] = $permission->id;
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'].'-排序',
                    'description' => '排序',
                    'status' => 0,
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $id[0],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/ruleOrder',
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[] = $permission->id;
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'].'-更改状态',
                    'description' => '更改状态',
                    'status' => 0,
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $id[0],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/state',
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[] = $permission->id;
                // 更新管理员权限
                $role = db('role')->find(1);
                $authList = [];
                $authList = db('role_permission')->where('role_id', 1)->select();
                $authList = array_column($authList, 'permission_id');
                sort($authList);
                if($id){
                    $permission_id = implode(',',$id);
                }
                $authList = implode(',', $authList) . ',' . $permission_id;
                $this->rbac->createRole([
                    'id' => $role['id'],
                    'name' => $role['name'],
                    'description' => $role['description'],
                    'status' => 1,
                ], $authList);
                // 添加栏目其他信息
                db('category')->insertGetId([
                    'p_id' => $id[0],
                    'catdir' => $data['path'],
                    'seo_title' => $data['seo_title'],
                    'seo_keywords' => $data['seo_keywords'],
                    'seo_description' => $data['seo_description'],
                    'image' => $data['image'],
                    'ismenu' => $data['ismenu'],
                    'pagesize' => $data['pagesize'],
                    'template_list' => $data['template_list'],
                    'template_show' => $data['template_show'],
                ]);


                Cache::clear('sys');
                return $result = ['code' => 1, 'msg' => '栏目添加成功!', 'url' => url('adminRule')];
            } catch (\Exception $e) {
                return $result = ['code' => 0, 'msg' => '栏目添加失败!'];
                // die();
                // 终止异常
            }
        } else {
            $nav = new Leftnav();
            $admin_rule = cache('admin_rule_category');
            if (!$admin_rule) {
                $admin_rule = $nav->menu($this->category, '|—', 42);
                cache('admin_rule_category', $admin_rule, 0, 'sys');
            }
            $admin_category = cache('Category');
            if (!$admin_category) {
                $where['status'] = 1;
                $where['id'] = 9;
                $admin_category = $this->rbac->getPermissionCategory($where);
                cache('Category', $admin_category, 0, 'sys');
            }
            $module = db('module')->where('status', 1)->field('id,title,name')->select();
            $this->assign('modulelist', $module);
            $templates = template_file();
            $this->assign('templates', $templates);
            $this->assign('admin_rule', $admin_rule);
            $this->assign('admin_category', $admin_category);
            return $this->fetch();
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            try {
                $this->rbac->editPermission([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'type' => 1,
                    'category_id' => 9,
                    'pid' => $data['pid'],
                    'icon' => $data['icon'],
                    'path' => $data['path'].'/index',
                ]);

                Cache::clear( 'sys' );
                // 修改栏目其他信息
                db('category')->where('p_id', $data['id'])->update([
                    'catdir' => $data['path'],
                    'seo_title' => $data['seo_title'],
                    'seo_keywords' => $data['seo_keywords'],
                    'seo_description' => $data['seo_description'],
                    'image' => $data['image'],
                    'ismenu' => $data['ismenu'],
                    'pagesize' => $data['pagesize'],
                    'template_list' => $data['template_list'],
                    'template_show' => $data['template_show'],
                ]);
                return $result = ['code' => 1, 'msg' => '修改成功!', 'url' => url('adminRule')];
            } catch (\Exception $e) {
                return $result = ['code' => 0, 'msg' => '修改失败!'];
                die();
            }
        } else {
            $admin_rule = $this->rbac->getPermission(input('id'));
            $info = db('category')->where('p_id', input('id'))->field('id', true)->find();
            $admin_rule = array_merge($admin_rule, $info);
            $module = db('permission')->where('id', input('id'))->find();
            $templates = template_file();
            $this->assign('module', $module);
            $this->assign('templates', $templates);
            $this->assign('rule', $admin_rule);
            return $this->fetch();
        }
    }

    public function ruleOrder()
    {
        $menu = db('menu');
        $data = input('post.');
        if (false !== Permission::update($data)) {
            Cache::clear();
            return $result = ['code' => 1, 'msg' => '排序更新成功!', 'url' => url('adminRule')];
        } else {
            return $result = ['code' => 0, 'msg' => '排序更新失败!'];
        }
    }

    public function del()
    {

        try {
            // dump(input('param.id'));exit;
            $id = intval(input('param.id'));
            // 删栏目表 删权限表 删子集
            $res = db('category')->where('p_id', $id)->delete();
            if($res > 0){
                $this->rbac->delPermission($id);
                Cache::clear();
                return $result = ['code' => 1, 'msg' => '删除成功!', 'url' => url('adminRule')];
            }
        } catch (\Exception $e) {
            return $result = ['code' => 0, 'msg' => '删除失败!'];
            // die(); // 终止异常
        }

    }
    public function state()
    {
        $id = input('post.id');
        $statusone = db('permission')->where(array('id' => $id))->value('status'); //判断当前状态情况
        cache('menu', null);
        cache('menu', null);
        if (1 == $statusone) {
            $statedata = array('status' => 0);
            db('permission')->where(array('id' => $id))->setField($statedata);
            $result['status'] = 1;
        } else {
            $statedata = array('status' => 1);
            db('permission')->where(array('id' => $id))->setField($statedata);
            $result['status'] = 1;
        }

        return $result;
    }

}
