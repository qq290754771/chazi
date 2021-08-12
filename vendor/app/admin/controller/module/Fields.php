<?php
/*
 * @Title: 模型
 * @Descripttion: 模型
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-19 20:56:12
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-19 23:08:34
 */
namespace app\admin\controller\module;

use app\admin\controller\common\CommonAuth;
use think\Db;
use think\Cache;


class Fields extends CommonAuth
{
    protected $dao;
    public function _initialize()
    {
        parent::_initialize();
        $this->dao = db('module');
        $field_pattern = [
            ['name' => 'defaul', 'title' => '默认'],
            ['name' => 'email', 'title' => '电子邮件'],
            ['name' => 'url', 'title' => '网址'],
            ['name' => 'date', 'title' => '日期'],
            ['name' => 'number', 'title' => '有效的数值'],
            ['name' => 'digits', 'title' => '数字'],
            ['name' => 'creditcard', 'title' => '信用卡号码'],
            ['name' => 'equalTo', 'title' => '再次输入相同的值'],
            ['name' => 'ip4', 'title' => 'IP'],
            ['name' => 'mobile', 'title' => '手机号码'],
            ['name' => 'zipcode', 'title' => '邮编'],
            ['name' => 'qq', 'title' => 'QQ'],
            ['name' => 'idcard', 'title' => '身份证号'],
            ['name' => 'chinese', 'title' => '中文字符'],
            ['name' => 'cn_username', 'title' => '中文英文数字和下划线'],
            ['name' => 'tel', 'title' => '电话号码'],
            ['name' => 'english', 'title' => '英文'],
            ['name' => 'en_num', 'title' => '英文数字和下划线'],
        ];
        $this->assign('pattern', json_encode($field_pattern, true));
        $this->assign('action', $this->action);
    }

    public function index()
    {
        if (request()->isPost()) {
            $nodostatus = array('p_id', 'title', 'status', 'createtime');
            $sysfield = array('p_id', 'userid', 'username', 'title', 'thumb', 'keywords', 'description', 'posid', 'status', 'createtime', 'url', 'template');

            $list = db('field')->where('moduleid=' . input('param.id'))->order('sort asc,id asc')->select();

            foreach ($list as $k => $v) {
                if ($v['status'] == 1) {
                    if (in_array($v['field'], $nodostatus)) {
                        $list[$k]['disable'] = 2;
                    } else {
                        $list[$k]['disable'] = 0;
                    }
                } else {
                    $list[$k]['disable'] = 1;
                }

                if (in_array($v['field'], $sysfield)) {
                    $list[$k]['delStatus'] = 1;
                } else {
                    $list[$k]['delStatus'] = 0;
                }
            }
            $this->assign('list', $list);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'rel' => 1];
        } else {
            return $this->fetch();
        }
    }

    public function add()
    {
        if (request()->isPost()) {
            if (input('isajax')) {
                $this->assign(input('get.'));
                $this->assign(input('post.'));
                $name = db('module')->where(array('id' => input('moduleid')))->value('name');
                if (input('name')) {
                    $files = Db::getTableInfo(config('database.prefix') . $name);
                    $fieldtype = $files['type'][input('name')];
                    $this->assign('fieldtype', $fieldtype);
                    if (input('type') == 'classify') {
                        $classify = db('classify')->where('lv', 0)->where('status', 1)->select();
                        $this->assign('classify', $classify);
                    }
                    return view('type');
                } else {
                    if (input('type') == 'classify') {
                        $classify = db('classify')->where('lv', 0)->where('status', 1)->select();
                        $this->assign('classify', $classify);
                    }
                    return view('addType');
                }
            } else {
                $data = input('post.');
                $fieldName = $data['field'];
                $prefix = config('database.prefix');

                $name = db('module')->where(array('id' => $data['moduleid']))->value('name');
                $tablename = $prefix . $name;
                $Fields = Db::getFields($tablename);
                foreach ($Fields as $key => $r) {
                    if ($key == $fieldName) {
                        $ishave = 1;
                    }
                }
                if ($ishave) {
                    $result['msg'] = '字段名已近存在！';
                    $result['code'] = 0;
                    return $result;
                }
                $addfieldsql = $this->get_tablesql($data, 'add');
                if ($data['setup']) {
                    $data['setup'] = array2string($data['setup']);
                } else {
                    $data['setup'] = '';
                }
                $data['status'] = 1;
                if ($data['pattern'] == '?') {
                    $data['pattern'] = 'defaul';
                } else {
                    $pattern = explode(':', $data['pattern']);
                    $data['pattern'] = $pattern[1];
                }
                if (empty($data['class'])) {
                    $data['class'] = $data['field'];
                }
                $model = db('field');
                // dump($addfieldsql);exit;
                if ($model->insert($data) !== false) {
                    if (is_array($addfieldsql)) {
                        foreach ($addfieldsql as $sql) {
                            $model->execute($sql);
                        }
                    } else {
                        $model->execute($addfieldsql);
                    }
                    $result['msg'] = '添加成功！';
                    $result['code'] = 1;
                    $result['url'] = url('field', array('id' => input('post.moduleid')));
                    return $result;
                } else {
                    $result['msg'] = '添加失败！';
                    $result['code'] = 0;
                    return $result;
                }
            }
        } else {
            $moduleid = input('moduleid');
            $this->assign('moduleid', $moduleid);
            $this->assign('title', lang('add') . lang('field'));
            $this->assign('info', 'null');
            return $this->fetch('form');
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            // dump( $data );
            // exit;
            $oldfield = $data['oldfield'];
            $fieldName = $data['field'];
            $name = db('module')->where(array('id' => $data['moduleid']))->value('name');
            if ($this->_iset_field($name, $fieldName) && $oldfield != $fieldName) {
                $result['msg'] = '字段名重复！';
                $result['code'] = 0;
                return $result;
            }
            $editfieldsql = $this->get_tablesql($data, 'edit');
            if ($data['setup']) {
                $data['setup'] = array2string($data['setup']);
            }
            if (!empty($data['unpostgroup'])) {
                $data['setup'] = implode(',', $data['unpostgroup']);
            }
            if ($data['pattern'] == '?') {
                $data['pattern'] = 'defaul';
            } else {
                $pattern = explode(':', $data['pattern']);
                $data['pattern'] = $pattern[1];
            }
            if (empty($data['class'])) {
                $data['class'] = $data['field'];
            }
            // dump($data);exit;
            $model = db('field');
            if (false !== $model->update($data)) {
                if (is_array($editfieldsql)) {
                    foreach ($editfieldsql as $sql) {
                        $model->execute($sql);
                    }
                } else {
                    $model->execute($editfieldsql);
                }
                $result['msg'] = '修改成功！';
                $result['code'] = 1;
                $result['url'] = url('field', array('id' => input('post.moduleid')));
                return $result;
            } else {
                $result['msg'] = '修改失败！';
                $result['code'] = 0;
                return $result;
            }
        } else {
            $model = db('field');
            $id = input('param.id');
            if (empty($id)) {
                $result['msg'] = '缺少必要的参数！';
                $result['code'] = 0;
                return $result;
            }
            $fieldInfo = $model->where(array('id' => $id))->find();
            if ($fieldInfo['setup']) {
                $fieldInfo['setup'] = string2array($fieldInfo['setup']);
            }

            $this->assign('info', json_encode($fieldInfo, true));
            $this->assign('title', lang('edit') . lang('field'));
            $this->assign('moduleid', input('param.moduleid'));
            return $this->fetch('form');
        }
    }

    public function del()
    {
        $id = input('id');
        $r = db('field')->find($id);
        db('field')->delete($id);

        $moduleid = $r['moduleid'];

        $field = $r['field'];

        $prefix = config('database.prefix');
        $name = db('module')->where(array('id' => $moduleid))->value('name');
        $tablename = $prefix . $name;

        db('field')->execute("ALTER TABLE `$tablename` DROP `$field`");

        return ['code' => 1, 'msg' => '删除成功！'];
    }

    public function status()
    {
        $map['id'] = input('post.id');
        //判断当前状态情况
        $field = db('field');
        $status = $field->where($map)->value('status');
        if ($status == 1) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }
        $field->where($map)->setField($data);
        return $data;
    }

    public function sort()
    {
        $model = db('field');
        $data = input('post.');
        if ($model->update($data) !== false) {
            Cache::clear();
            return $result = ['msg' => '操作成功！', 'url' => url('field', array('id' => input('post.moduleid'))), 'code' => 1];
        } else {
            return $result = ['code' => 0, 'msg' => '操作失败！'];
        }
    }

    private function get_tablesql($info, $do)
    {
        $fieldtype = $info['type'];
        if ($info['setup']['fieldtype']) {
            $fieldtype = $info['setup']['fieldtype'];
        }
        $moduleid = $info['moduleid'];
        $default = $info['setup']['default'];
        $field = $info['field'];
        $prefix = config('database.prefix');
        $name = db('module')->where(array('id' => $moduleid))->value('name');
        $tablename = $prefix . $name;
        $maxlength = intval($info['maxlength']);
        $numbertype = $info['setup']['numbertype'];
        $oldfield = $info['oldfield'];
        if ($do == 'add') {
            $do = ' ADD ';
        } else {
            $do = ' CHANGE `' . $oldfield . '` ';
        }
        switch ($fieldtype) {
            case 'varchar':
                if (!$maxlength) {
                    $maxlength = 255;
                }
                $maxlength = min($maxlength, 255);
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( $maxlength ) NOT NULL DEFAULT '$default'";
                break;

            case 'title':
                $thumb = $info['setup']['thumb'];
                $style = $info['setup']['style'];
                if (!$maxlength) {
                    $maxlength = 255;
                }
                $maxlength = min($maxlength, 255);
                $sql[] = "ALTER TABLE `$tablename` $do `$field` VARCHAR( $maxlength ) NOT NULL DEFAULT '$default'";

                if (!$this->_iset_field($name, 'thumb')) {
                    if ($thumb == 1) {
                        $sql[] = "ALTER TABLE `$tablename` ADD `thumb` VARCHAR( 100 ) NOT NULL DEFAULT ''";
                    }
                } else {
                    if ($thumb == 0) {
                        $sql[] = "ALTER TABLE `$tablename` drop column `thumb`";
                    }
                }

                if (!$this->_iset_field($name, 'title_style')) {
                    if ($style == 1) {
                        $sql[] = "ALTER TABLE `$tablename` ADD `title_style` VARCHAR( 100 ) NOT NULL DEFAULT ''";
                    }
                } else {
                    if ($style == 0) {
                        $sql[] = "ALTER TABLE `$tablename` drop column `title_style`";
                    }
                }
                break;
            case 'catid':
                $sql = "ALTER TABLE `$tablename` $do `$field` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0'";
                break;

            case 'number':
                $decimaldigits = $info['setup']['decimaldigits'];
                $default = $decimaldigits == 0 ? intval($default) : floatval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` " . ($decimaldigits == 0 ? 'INT' : 'decimal( 10,' . $decimaldigits . ' )') . ' ' . ($numbertype == 1 ? 'UNSIGNED' : '') . "  NOT NULL DEFAULT '$default'";
                break;

            case 'tinyint':
                if (!$maxlength) {
                    $maxlength = 3;
                }

                $maxlength = min($maxlength, 3);
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` TINYINT( $maxlength ) " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT '$default'";
                break;

            case 'smallint':
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` SMALLINT " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT '$default'";
                break;

            case 'int':
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` INT " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT '$default'";
                break;

            case 'mediumint':
                $default = intval($default);
                $sql = "ALTER TABLE `$tablename` $do `$field` INT " . ($numbertype == 1 ? 'UNSIGNED' : '') . " NOT NULL DEFAULT '$default'";
                break;

            case 'mediumtext':
                $sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL";
                break;

            case 'text':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
                break;

            case 'posid':
                $sql = "ALTER TABLE `$tablename` $do `$field` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0'";
                break;

            case 'classify':
                $sql = "ALTER TABLE `$tablename` $do `$field` INT(11) NOT NULL DEFAULT '0'";
                break;

            case 'datetime':
                $sql = "ALTER TABLE `$tablename` $do `$field` INT(11) UNSIGNED NOT NULL DEFAULT '0'";
                break;

            case 'editor':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
                break;

            case 'image':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT ''";
                break;

            case 'images':
                $sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL";
                break;

            case 'file':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT ''";
                break;

            case 'files':
                $sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL";
                break;
            case 'template':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 80 ) NOT NULL DEFAULT ''";
                break;
            case 'addbox':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
                break;
            case 'multicolumn':
                $sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 255 ) NOT NULL DEFAULT ''";
                break;
            case 'video':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
                break;
            case 'linkage':
                $sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
                break;
            case 'position':
                $sql[] = "ALTER TABLE `$tablename` $do `$field".'_lng'."` TEXT NOT NULL";
                $sql[] = "ALTER TABLE `$tablename` $do `$field".'_lat'."` TEXT NOT NULL";
                $sql[] = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
                break;
        }
        return $sql;
    }
    private function _iset_field($table, $field)
    {
        $fields = db($table)->getTableFields();
        return array_search($field, $fields);
    }

}
