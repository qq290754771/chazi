<?php
/*
 * @Title:
 * @Descripttion:
 * @version:
 * @Author: wzs
 * @Date: 2020-05-09 19:58:17
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-16 23:28:18
 */
namespace app\home\controller;

class Index extends Common
{
    public function _initialize()
    {
        parent::_initialize();
    }
    public function index()
    {
        // if (!session('user')) {
        //     $this->redirect('/login');
        // }
        // $user = session('user');
        // $where2['s_id'] = $user['id'];
        // $where2['createtime'][] = ['>', strtotime(date('Y-m', time()))];
        // $where2['createtime'][] = ['<', strtotime(date('Y-m', time()) . '+1 month')];
        // $dxl_num = db('order')->where($where2)->count();
        // $dyj_num = db('order')->where($where2)->sum('price');
        // $this->assign('dxl_num', $dxl_num);
        // $this->assign('dyj_num', $dyj_num);

        // $where['s_id'] = $user['id'];
        // $where['createtime'][] = ['>', strtotime(date('Y-01-01', time()))];
        // $where['createtime'][] = ['<', strtotime(date('Y-01-01', time()) . '+1 year')];
        // $yxl_num = db('order')->where($where)->count();
        // $yyj_num = db('order')->where($where)->sum('price');
        // $this->assign('yxl_num', $yxl_num);
        // $this->assign('yyj_num', $yyj_num);
        return $this->fetch();
    }

    public function getdyorder()
    {
        // dump(session('user'));
        $user = session('user');
        $page = input('page');
        $time = input('time');
        $where['s_id'] = $user['id'];
        $where['createtime'][] = ['>', strtotime(date('Y-m', $time))];
        $where['createtime'][] = ['<', strtotime(date('Y-m', $time) . '+1 month')];
        // dump($where);
        $list = db('order')->where($where)->field('userid,username,updatetime,lang,sort,template', true)->order('createtime desc')->paginate(array(
            'list_rows' => 8,
            'page' => $page,
        ))->toArray();
        // dump($list);
        foreach ($list['data'] as $k => $v) {
            $list['data'][$k]['orderid'] = $v['createtime'] . $v['id'];
            $list['data'][$k]['createtime'] = date('Y-m-d', $v['createtime']);
        }
        // $list['data'] = [];
        // $list['last_page'] = 0;
        $res = $list;
        $res['code'] = 1;
        $res['msg'] = '获取成功';
        return json($res);
    }

    public function getTimeDate()
    {
        $user = session('user');
        $page = input('page');
        $where['s_id'] = $user['id'];
        // $list = db('order')->where($where)->field("concat(DATE_FORMAT(from_unixtime(createtime),'%m'),'月' ) as timea, sum(price) as price, count(id) as num")->order('timea asc')->group('timea')->paginate(array(
        //         'list_rows' => 8,
        //         'page' => $page,
        //     ))->toArray();
        $list['data'] = \think\Db::query("SELECT DATE_FORMAT(from_unixtime(createtime),'%Y年%m月')as time,createtime, sum(price) as price, count(id) as num FROM `cool_order` WHERE  `s_id` = '" . $user['id'] . "' GROUP BY `time` ORDER BY `time` ASC ");
        // dump($list);
        $list['total'] = count($list);
        $list['current_page'] = 1;
        $list['per_page'] = 1;
        $list['last_page'] = 1;
        $res = $list;
        $res['code'] = 1;
        $res['msg'] = '获取成功';
        return json($res);
    }

    public function login()
    {
        if (request()->isPost()) {
            $username = input('username');
            $password = input('password');
            $info = db('salesman')->where('tel', $username)->where('password', $password)->find();
            if (!empty($info)) {
                session('user', $info);
                $res['code'] = 1;
                $res['msg'] = '登录成功';
                return json($res);
            } else {
                $res['code'] = 0;
                $res['msg'] = '登录失败';
                return json($res);
            }
        } else {
            return $this->fetch();
        }

    }
    protected function buildHtml($htmlfile = '', $htmlpath = '', $templateFile = '')
    {
        $content = $this->fetch($templateFile);
        $htmlpath = !empty($htmlpath) ? $htmlpath : './appTemplate/';
        $htmlfile = $htmlpath . $htmlfile . '.' . config('url_html_suffix');
        $File = new \think\template\driver\File();
        $File->write($htmlfile, $content);
        return $content;
    }
    public function me()
    {
        if (!session('user')) {
            $this->redirect('/login');
        }
        $user = session('user');
        $time = input('time');
        $where2['s_id'] = $user['id'];
        $where2['createtime'][] = ['>', strtotime(date('Y-m', $time))];
        $where2['createtime'][] = ['<', strtotime(date('Y-m', $time) . '+1 month')];
        $dxl_num = db('order')->where($where2)->count();
        $dyj_num = db('order')->where($where2)->sum('price');
        $this->assign('dxl_num', $dxl_num);
        $this->assign('dyj_num', $dyj_num);

        $where['s_id'] = $user['id'];
        $where['createtime'][] = ['>', strtotime(date('Y-01-01', time()))];
        $where['createtime'][] = ['<', strtotime(date('Y-01-01', time()) . '+1 year')];
        $yxl_num = db('order')->where($where)->count();
        $yyj_num = db('order')->where($where)->sum('price');
        $this->assign('yxl_num', $yxl_num);
        $this->assign('yyj_num', $yyj_num);
        $this->assign('m', date('Y-m', $time));
        return $this->fetch();
    }

    public function bss()
    {
        $this->buildHtml('index', APP_PATH . "../html/", 'index/index');
    }
}
