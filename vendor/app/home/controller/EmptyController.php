<?php
namespace app\home\controller;

use think\Db;
use think\Request;
use cool\Form;
class EmptyController extends Common
{
    protected $dao, $fields , $dbname;
    public function _initialize()
    {
        parent::_initialize();
        $this->dbname = db('permission')->where('id',input('catId'))->value('module');
        define('DBNAME',$this->dbname);
        $this->dao = db($this->dbname);
        $this->assign('dbname', DBNAME);
        $this->assign('catId', input('catId'));
        $this->assign('catname', getcatname(input('catId')));
        $this->assign('parentId', getcatname(input('catId'), 'pid'));
    }
    public function index()
    {

            $rightNavInfo = db('permission')->alias('p')->join('category c ','p.id= c.p_id')->where('p.id',input('catId'))->field('c.id,c.p_id,c.catdir,p.name,c.image,c.url,p.pid')->find();

            $this->assign('categoryInfo',$rightNavInfo);    //当前栏目
            if($rightNavInfo['pid'] != 0) {
                $navlist = db('category')->alias('c')->join('permission p ','p.id= c.p_id')->field('c.id,c.p_id,c.catdir,p.name,c.image,c.url,p.pid')->where('p.id', $rightNavInfo['pid'])->where('c.ismenu', 1)->order('p.sort,c.id')->select();
                $this->assign('navlist', $navlist);
            }
            $map['a.p_id'] = input('catId');
            $list = $this->dao->alias('a')->join('permission p', 'a.p_id = p.id', 'left')->where($map)->field('a.*,p.name')->order('a.sort asc,a.createtime desc')->fetchsql(false)->paginate($this->pagesize);
            // 获取分页显示
            $page = $list->render();
            $list = $list->toArray();
            foreach ($list['data'] as $k => $v) {
                $list['data'][$k]['catdir'] = db('category')->where('p_id',$v['p_id'])->value('catdir');
                $list['data'][$k]['controller'] = $list['data'][$k]['catdir'];
                $list_style = explode(';', $v['title_style']);
                $list['data'][$k]['title_color'] = $list_style[0];
                $list['data'][$k]['title_weight'] = $list_style[1];
                $title_thumb = $v['thumb'];
                $list['data'][$k]['title_thumb'] = $title_thumb ? __PUBLIC__ . $title_thumb : __HOME__ . '/images/portfolio-thumb/p' . ($k + 1) . '.jpg';
            }
            $this->assign('list', $list['data']);
            $this->assign('page', $page);
            // dump($list);
            $cattemplate = db('category')->where('p_id', input('catId'))->value('template_list');
            $template = $cattemplate ? $cattemplate : $this->dbname . '_list';
            return $this->fetch($template);
    }
    public function info()
    {
        //内容信息
        $this->dao->where('id', input('id'))->setInc('hits');
        $info = $this->dao->where('id', input('id'))->find();
        $info['pic'] = $info['pic']?__PUBLIC__.$info['pic']:"__HOME__/images/sample-images/blog-post".rand(1, 3).".jpg";
        $title_style = explode(';', $info['title_style']);
        $info['title_color'] = $title_style[0];
        $info['title_weight'] = $title_style[1];
        $title_thumb = $info['thumb'];
        $info['title_thumb'] = $title_thumb?__PUBLIC__.$title_thumb:'__HOME__/images/sample-images/blog-post'.rand(1, 3).'.jpg';
        $this->assign('info', $info);

        $rightNavInfo = db('permission')->alias('p')->join('category c ','p.id= c.p_id')->where('p.id',input('catId'))->field('c.id,c.p_id,c.catdir,p.name,c.image,c.url,p.pid')->find();
        $this->assign('categoryInfo',$rightNavInfo);    //当前栏目
        if($rightNavInfo['pid'] != 0) {
            $navlist = db('category')->alias('c')->join('permission p ','p.id= c.p_id')->field('c.id,c.p_id,c.catdir,p.name,c.image,c.url,p.pid')->where('p.id', $rightNavInfo['pid'])->where('c.ismenu', 1)->order('p.sort,c.id')->select();
            $this->assign('navlist', $navlist);
        }
        //文章内容页模板
        if($info['template']) {
            $template = $info['template'];
        }else{
            $cattemplate = db('category')->where('p_id', $info['p_id'])->value('template_show');
            if($cattemplate) {
                $template = $cattemplate;
            }else{
                $template = DBNAME.'_show';
            }
        }
        return $this->fetch($template);
    }
    public function load()
    {
        $thumbgroup = db('picture')->field('thumbgroup')->where('id', input('id'))->find();
        // $info = $this->dao->where('id',input('id'))->find();
        $thumbgroup = substr($thumbgroup['thumbgroup'], 0, -1);
        $thumbgrouparry = explode(';', $thumbgroup);
        foreach ($thumbgrouparry as $key => $value) {
            $thumbgrouparry[$key] = '/public' . $value;
        }
        return json(['data' => $thumbgrouparry, 'code' => 1, 'message' => '操作完成']);
    }
    public function page()
    {
        $listnav = db('category')->where(array('parentid' => 10))->field(['id', 'catname'])->select();
        foreach ($listnav as $k => $v) {
            $listnav[$k]['num'] = db('blog')->where(array('catid' => $v['id']))->count();
            $str .= ',' . $v['id'];
            // $str=$str.','.$v['id'];
        }
        $map = 'catid in(' . substr($str, 1) . ')';
        $list = db('case')->where($map)->paginate(8);
        //echo db('case')->getlastsql();exit;
        $page = $list->render();
        $list = $list->toArray();
        $this->assign('page', $page);
        $this->assign('list', $list['data']);
        return $this->fetch('case_load');
    }
    public function deal()
    {
        $newproducts = db('product')->where(array('isnew' => 1))->select();
        $catdir = db('category')->where(array('id' => $newproducts[0]['catid']))->field('catdir')->select();
        $list = db('product')->where('isnew', 1)->paginate(9);
        //分页显示
        $page = $list->render();
        $this->assign('catdir', $catdir[0]['catdir']);
        $this->assign('page', $page);
        $this->assign('products', $newproducts);
        return $this->fetch('page_show');
    }
}
