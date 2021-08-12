<?php
namespace app\admin\controller;

use app\admin\controller\common\Common;
use cool\Leftnav;
use think\Cache;
use think\Db;

class Index extends Common
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        return $this->fetch();
    }

    /**
     * 首页主体展示
     */

    public function main()
    {
        $version = Db::query('SELECT VERSION() AS ver');
        $config = [
            'url' => $_SERVER['HTTP_HOST'],
            'document_root' => $_SERVER['DOCUMENT_ROOT'],
            'server_os' => PHP_OS,
            'server_port' => $_SERVER['SERVER_PORT'],
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'server_soft' => $_SERVER['SERVER_SOFTWARE'],
            'php_version' => PHP_VERSION,
            'mysql_version' => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize'),
        ];
        $disk = round(100 - disk_free_space($_SERVER['DOCUMENT_ROOT']) / disk_total_space($_SERVER['DOCUMENT_ROOT']) * 100, 2);
        $this->assign('disk', $disk);
        $this->assign('config', $config);
        // // 一周内到期人数
        // $map['t.dqtime'][] = ['>', time()];
        // $map['t.dqtime'][] = ['<', strtotime( '+7 days' )];
        // $map['t.is_tx'] = 0;
        // $dqnum = db( 'customer' )->alias( 'a' )->join( 'cool_txtime t', 'a.id = t.c_id' )->field( 'a.*,t.dqtime,t.title as dqtitle' )->where( $map )->group( 'a.title' )->order( 't.dqtime asc,a.sort asc,a.id desc' )->count();
        // // 总客户数
        // $total_num = db( 'customer' )->cache( 'total_num',0,'sys' )->count();
        // $this->assign( 'total_num', $total_num );
        // // 总业务数
        // $salesman_num = db( 'salesman' )->cache( 'salesman_num',0,'sys' )->count();
        // $this->assign( 'salesman_num', $salesman_num );
        // // 2020年业绩
        // $where['createtime'][] =  [ '>', strtotime(date('Y-01-01', time()))];
        // $where['createtime'][] =  [ '<', strtotime( date( 'Y-01-01', time()) .'+1 year' )];
        // $xl_num = db( 'order' )->where($where)->cache( 'xl_num',0,'sys' )->count();
        // $yj_num = db( 'order' )->where($where)->cache( 'yj_num',0,'sys' )->sum('price');
        // $this->assign( 'xl_num', $xl_num );
        // $this->assign( 'yj_num', $yj_num );

        // $where2['createtime'][] =  [ '>', strtotime(date('Y-m', time()))];
        // $where2['createtime'][] =  [ '<', strtotime(date( 'Y-m', time()) .'+1 month' )];
        // $mxl_num = db( 'order' )->where($where2)->cache( 'mxl_num',0,'sys' )->count();
        // $myj_num = db( 'order' )->where($where2)->cache( 'myj_num',0,'sys' )->sum('price');
        // $this->assign( 'mxl_num', $mxl_num );
        // $this->assign( 'myj_num', $myj_num );
        // // $total_test_num = db( 'test' )->cache( true )->count();
        // $this->assign( 'dqnum', $dqnum );
        return $this->fetch();
    }

    public function navbar()
    {
        return $this->fetch();
    }

    public function nav()
    {
        return $this->fetch();
    }
    /**
     * 清理缓存
     */

    public function clear()
    {
        // Cache::clear();
        if (config('cache')['type'] == "File") {
            $R = RUNTIME_PATH;
            // echo $R;
            // $this->_deleteDir($R);
            $this->_deleteDir($R);
        } else {
            Cache::clear();
        }
        $result['info'] = '清除缓存成功!';
        $result['status'] = 1;
        $result['url'] = url('admin/index/index');
        return $result;
    }

    private function _deleteDir($R)
    {
        $handle = opendir($R);
        while (($item = readdir($handle)) !== false) {
            if ($item != '.' and $item != '..') {
                if (is_dir($R . '/' . $item)) {
                    $this->_deleteDir($R . '/' . $item);
                } else {
                    if (!unlink($R . '/' . $item)) {
                        die('error!');
                    }
                }
            }
        }
        closedir($handle);
        return rmdir($R);
    }

    /**
     * 退出登陆
     */

    public function logout()
    {
        if (config('cache')['type'] == "File") {
            $R = RUNTIME_PATH;
            // echo $R;
            // $this->_deleteDir($R);
            $this->_deleteDir($R);
        } else {
            Cache::clear();
        }
        session(null);
        $this->redirect('login/index');
    }

    public function getpv()
    {
        $stattime = strtotime(date("Y-m-d"), time());
        $shijianxian = Db::query("select date(from_unixtime(stattime)) as riqi, sum(pv)as pvnum,sum(uv)as uvnum,sum(ip)as ipnum   from cool_visit_detail where from_unixtime(stattime) >= date(now()) - interval 7 day group by day(from_unixtime(stattime));");
        $riqistr = '';
        $pvstr = '';
        $uvstr = '';
        $ipstr = '';
        foreach ($shijianxian as $key => $value) {
            $riqistr[$key] = $value['riqi'];
            $pvstr[$key] = $value['pvnum'];
            $uvstr[$key] = $value['uvnum'];
        }
        $result['riqistr'] = $riqistr;
        $result['pvstr'] = $pvstr;
        $result['uvstr'] = $uvstr;
        return $result;

    }

    public function mulapi()
    {
        $id = input('id');
        $type = input('type');
        if ($type == 'con') {
            $menu = db('permission')->find($id);
            $module = $menu['module'];
            $list = db($module)->field('title,id as value')->select();
            foreach ($list as $k => $v) {
                $list[$k]['name'] = $v['title'];
            }
            $res['data'] = $list;
            $res['code'] = 0;
            $res['msg'] = '请求成功';
            return json($res);
        } else {
            $res['data'] = [];
            $res['code'] = 1;
            $res['msg'] = '请求失败';
            return json($res);
        }
        // dump( $data );
    }

    // public function catid()
    // {
    //     $pid = input('pid');
    //     $iscate = db('category')->where('p_id', $pid)->value('id');
    //     if ($iscate) {
    //         $category = db('permission')->alias('p')->where('p.type', 1)->where('p.category_id', 9)->join('cool_category c', 'c.p_id = p.id')->field('p.id,p.category_id,p.description,p.icon,p.name,p.path,p.pid,p.sort,p.status,p.type,p.moduleid,c.ismenu,c.url,c.pagesize')->order('p.sort asc,p.id asc,p.create_time desc')->select();
    //     } else {
    //         $permission = db('permission')->where('type', 1)->where('id', $pid)->find();
    //         $category = db('permission')->where('type', 1)->where('category_id', $permission['category_id'])->where('id', $permission['id'])->where('status', 1)->where('state', $permission['state'])->select();
    //     }
    //     $nav = new Leftnav();
    //     // dump($this->category);
    //     if ($permission) {
    //         $data = $nav->authRule($category, $permission['pid']);
    //     } else {
    //         $data = $nav->authRule($category, 42);
    //     }
    //     foreach ($data as $k => $v) {
    //         $data[$k]['module'] = db('module')->where('id', $v['moduleid'])->value('title');
    //     }
    //     return json(array('code' => 200, 'data' => $data));
    // }
    public function catid()
    {
        $pid = input('pid');
        $iscate = db('category')->where('p_id', $pid)->value('id');
        if ($iscate) {
            $category = db('permission')->alias('p')->where('p.type', 1)->where('p.category_id', 9)->join('cool_category c', 'c.p_id = p.id')->field('p.id,p.category_id,p.description,p.icon,p.name,p.path,p.pid,p.sort,p.status,p.type,p.moduleid,c.ismenu,c.url,c.pagesize')->order('p.sort asc,p.id asc,p.create_time desc')->select();
        } else {
            $permission = db('permission')->where('type', 1)->where('id', $pid)->select();
            // $category = db('permission')->where('type', 1)->where('category_id', $permission['category_id'])->where('id', $permission['id'])->where('status', 1)->where('state', $permission['state'])->select();
        }
        $nav = new Leftnav();
        // dump($permission);
        // dump($this->category);
        if ($permission) {
            $data = $permission;
        } else {
            $data = $nav->authRule($category, 42);
        }
        foreach ($data as $k => $v) {
            $data[$k]['module'] = db('module')->where('id', $v['moduleid'])->value('title');
        }
        return json(array('code' => 200, 'data' => $data));
    }

}
