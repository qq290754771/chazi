<?php
/*
 * @Title: 模型
 * @Descripttion: 模型
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-19 20:56:12
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-19 23:04:56
 */
namespace app\admin\controller\module;

use app\admin\controller\common\CommonAuth;
use think\Db;
use think\Request;

class Index extends CommonAuth
{
    protected $dao;
    public function _initialize()
    {
        parent::_initialize();
        $this->dao = db('module');
        $this->assign('action', $this->action);
    }

    public function index()
    {
        if (request()->isPost()) {
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $list = $this->dao->order('sort desc')
                ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                ->toArray();
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        } else {
            return $this->fetch();
        }
    }

    public function add()
    {
        if (request()->isPost()) {
            // 获取数据库所有表名
            $tables = Db::getTables();
            // 组装表名
            $prefix = config('database.prefix');
            $tablename = $prefix . input('post.name');
            // 判断表名是否已经存在
            if (in_array($tablename, $tables)) {
                $result['status'] = 0;
                $result['info'] = '该表已经存在！';
                return $result;
            }
            $data = input('post.');
            $data['type'] = 1;
            $data['setup'] = '';
            $moduleid = $this->dao->insertGetId($data);
            if (empty($moduleid)) {
                $result['code'] = 0;
                $result['msg'] = '添加模型失败！';
                return $result;
            }
            // 建表
            $emptytable = input('post.emptytable');
            if ($emptytable == '0') {
                $this->createModuleTable($tablename, $prefix, $moduleid, $emptytable);
            } else {
                $this->createModuleTable($tablename, $prefix, $moduleid, $emptytable);
            }
            if ($moduleid !== false) {
                $result['code'] = 1;
                $result['msg'] = '添加模型成功！';
                $result['url'] = url('index');
                return $result;
            }
        } else {
            $this->assign('title', lang('add') . lang('module'));
            $this->assign('info', 'null');
            return $this->fetch('form');
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            if ($this->dao->update($data) !== false) {
                return array('code' => 1, 'url' => url('index'), 'msg' => '修改成功!');
            } else {
                return array('code' => 0, 'url' => url('index'), 'msg' => '修改失败!');
            }
        } else {
            $map['id'] = input('param.id');
            $info = $this->dao->field('id,title,name,description,listfields')->where($map)->find();
            $this->assign('title', lang('edit') . lang('module'));
            $this->assign('info', json_encode($info, true));
            return $this->fetch('form');
        }
    }

    public function del()
    {
        $id = input('param.id');
        $r = db('module')->find($id);
        if (!empty($r)) {
            $tablename = config('database.prefix') . $r['name'];

            $m = db('module')->delete($id);
            if ($m) {
                Db::execute('DROP TABLE IF EXISTS `' . $tablename . '`');
                db('Field')->where(array('moduleid' => $id))->delete();
            }
        }
        return ['code' => 1, 'msg' => '删除成功！'];
    }

    private function createModuleTable($tablename, $prefix, $moduleid, $type)
    {
        if ($type == '0') {
            // 建表
            Db::execute('CREATE TABLE `' . $tablename . "` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `p_id` smallint(5) unsigned NOT NULL DEFAULT '0',
                `userid` int(8) unsigned NOT NULL DEFAULT '0',
                `username` varchar(40) NOT NULL DEFAULT '',
                `title` varchar(120) NOT NULL DEFAULT '',
                `title_style` varchar(225) NOT NULL DEFAULT '',
                `thumb` varchar(225) NOT NULL DEFAULT '',
                `keywords` varchar(120) NOT NULL DEFAULT '',
                `description` mediumtext NOT NULL,
                `content` mediumtext NOT NULL,
                `posid` tinyint(2) unsigned NOT NULL DEFAULT '0',
                `sort` int(10) unsigned NOT NULL DEFAULT '0',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `hits` int(11) unsigned NOT NULL DEFAULT '0',
                `createtime` int(11) unsigned NOT NULL DEFAULT '0',
                `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `status` (`id`,`status`,`sort`),
                KEY `p_id` (`id`,`p_id`,`status`),
                KEY `sort` (`id`,`p_id`,`status`,`sort`)
                ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8");
                
                // 添加栏目
                Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'catid', '栏目', '', '1', '1', '6', '', '必须选择一个栏目', '', 'p_id', '','1','', '1', '1', '1', '1', '1', '0')");

                // 添加标题
                Db::execute("INSERT INTO `" . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'title', '标题', '', '1', '1', '80', '', '标题必须为1-80个字符', '', 'title', 'array (\n  \'thumb\' => \'1\',\n  \'style\' => \'1\',\n  \'size\' => \'55\',\n)','1','', '2', '1', '1', '1', '1', '0')");

                // 添加SEO关键词
                Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'keywords', 'SEO关键词', '', '0', '0', '80', '', '', '', 'text', 'array (\n  \'size\' => \'55\',\n  \'default\' => \'\',\n  \'ispassword\' => \'0\',\n  \'fieldtype\' => \'varchar\',\n)','1','',  '3', '1', '1', '0', '0', '0')");

                // 添加排序
                Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'sort', '排序', '', '0', '0', '80', '', '', '', 'text', 'array (\n  \'size\' => \'55\',\n  \'default\' => \'\',\n  \'ispassword\' => \'0\',\n  \'fieldtype\' => \'varchar\',\n)','1','',  '3', '1', '1', '0', '0', '0')");

                // 添加SEO描述
                Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'description', 'SEO描述', '', '0', '0', '0', '', '', '', 'textarea', 'array (\n  \'fieldtype\' => \'mediumtext\',\n  \'rows\' => \'4\',\n  \'cols\' => \'55\',\n  \'default\' => \'\',\n)','1','',  '4', '1', '1', '0', '0', '0')");

                // 添加内容
                Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'content', '内容', '', '0', '0', '0', '', '', '', 'editor', 'array (\n  \'edittype\' => \'layedit\',\n)','1','',  '5', '1', '1', '0', '0', '0')");
                
                // 添加发布时间
                Db::execute("INSERT INTO `" . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'createtime', '发布时间', '', '1', '0', '0', 'date', '', '', 'datetime', '','1','','97', '1', '1', '1', '1', '0')");

                // 添加状态
                Db::execute("INSERT INTO `" . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'status', '状态', '', '0', '0', '0', '', '', '', 'radio', 'array (\n  \'options\' => \'发布|1\r\保存|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'numbertype\' => \'1\',\n  \'labelwidth\' => \'75\',\n  \'default\' => \'1\',\n)','1','', '98', '1', '1', '0', '0', '0')");

                // 添加推荐位
                Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'posid', '推荐位', '', '0', '0', '0', '', '', '', 'posid', '','1','', '12', '1', '1', '0', '0', '0')");

        } else {
            // 建表
            Db::execute('CREATE TABLE `' . $tablename . "` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `p_id` smallint(5) unsigned NOT NULL DEFAULT '0',
                `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `userid` int(8) unsigned NOT NULL DEFAULT '0',
                `sort` int(10) unsigned NOT NULL DEFAULT '0',
                `username` varchar(40) NOT NULL DEFAULT '',
                `createtime` int(11) unsigned NOT NULL DEFAULT '0',
                `updatetime` int(11) unsigned NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `status` (`id`,`status`,`sort`),
                KEY `p_id` (`id`,`p_id`,`status`),
                KEY `sort` (`id`,`p_id`,`status`,`sort`)
                ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8");

            // 添加栏目
            Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'p_id', '栏目', '', '1', '1', '6', '', '必须选择一个栏目', '', 'p_id', '','1','', '1', '1', '1', '1', '1', '0')");

            // 添加排序
            Db::execute('INSERT INTO `' . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'sort', '排序', '', '0', '0', '80', '', '', '', 'text', 'array (\n  \'size\' => \'55\',\n  \'default\' => \'\',\n  \'ispassword\' => \'0\',\n  \'fieldtype\' => \'varchar\',\n)','1','',  '3', '1', '1', '0', '0', '0')");

            // 添加发布时间
            Db::execute("INSERT INTO `" . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'createtime', '发布时间', '', '1', '0', '0', 'date', '', '', 'datetime', '','1','','97', '1', '1', '1', '1', '0')");

            // 添加状态
            Db::execute("INSERT INTO `" . $prefix . "field` VALUES (NULL, '" . $moduleid . "', 'status', '状态', '', '0', '0', '0', '', '', '', 'radio', 'array (\n  \'options\' => \'发布|1\r\保存|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'numbertype\' => \'1\',\n  \'labelwidth\' => \'75\',\n  \'default\' => \'1\',\n)','1','', '98', '1', '1', '0', '0', '0')");
        }
    }
}
