<?php
namespace app\admin\controller;

use app\admin\controller\common\CommonAuth;
use cool\Form;
use think\Db;
use think\Request;

class EmptyController extends CommonAuth
{
    protected $fields, $searchfields, $listfields;
    public function _initialize()
    {
        parent::_initialize();
        // 拆分处理字段
        $this->splitfield();
    }

    public function index()
    {
        if (request()->isPost()) {
            // dump(input());
            $model = $this->biao;
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $order = "sort asc,id desc";
            $post = input();
            unset($post['page']);
            unset($post['limit']);
            $map = $this->formatMap($post);
            // dump($map);
            $list = $model->where($map)->order($order)->paginate(array(
                'list_rows' => $pageSize,
                'page' => $page,
            ))->toArray();
            // echo $model->getlastSql();
            // 处理查出来的列表
            $lists = $this->formatField($list['data']);
            $rsult['code'] = 0;
            $rsult['msg'] = "获取成功";
            $rsult['data'] = $lists;
            $rsult['count'] = $list['total'];
            $rsult['rel'] = 1;
            return $rsult;
        } else {
            try {
                return $this->fetch('article/' . $this->temfile . '/index');
            } catch (\Exception $th) {
                return $this->fetch('article/content/index');
            }

        }
    }
    public function edit()
    {
        if (request()->isPost()) {
            $request = Request::instance();
            $controllerName = $request->controller();
            $model = $this->biao;
            $fields = $this->fields;
            // dump(input('post.'));exit;
            $data = $this->checkfield($fields, input('post.'));
            if ($data['code'] == "0") {
                $result['msg'] = $data['msg'];
                $result['code'] = 0;
                return $result;
            }
            if (isset($fields['updatetime'])) {
                $data['userid'] = session('admin_id');
            }
            if (isset($fields['updatetime'])) {
                $data['updatetime'] = time();
            }
            $title_style = '';
            if (isset($data['style_color'])) {
                $title_style .= 'color:' . $data['style_color'] . ';';
                unset($data['style_color']);
            } else {
                $title_style .= 'color:#222;';
            }
            if (isset($data['style_bold'])) {
                $title_style .= 'font-weight:' . $data['style_bold'] . ';';
                unset($data['style_bold']);
            } else {
                $title_style .= 'font-weight:normal;';
            }
            if ($fields['title']['setup']['style'] == 1) {
                $data['title_style'] = $title_style;
            }
            if ($controllerName != 'Page') {
                $data['updatetime'] = time();
            }
            if (isset($data['isposid'])) {
                $data['isposid'] = implode(',', $data['isposid']);
            }
            if (isset($fields['catid'])) {
                if (is_array($data['catid'])) {
                    $data['catid'] = implode(',', $data['catid']);
                }
            }
            unset($data['aid']);
            unset($data['pics_name']);
            //编辑多图和多文件
            foreach ($fields as $k => $v) {
                if ($v['type'] == 'files') {
                    if (!$data[$k]) {
                        $data[$k] = '';
                    }
                    $data[$v['field']] = $data['images'];
                }

                if ($v['type'] == 'linkage') {
                    $data[$v['field']] = implode(',', $data[$v['field']]);
                }

                if ($v['setup']['ispassword'] == 1) {
                    if ($data[$v['field']]) {
                        $data[$v['field']] = md5($data[$v['field']]);
                    } else {
                        unset($data[$v['field']]);
                    }
                }
            }
            // dump($data);exit;
            $list = $model->update($data);
            if (false !== $list) {
                if ($controllerName == 'Page') {
                    // $result['url'] = url("admin/category/index");
                    $result['url'] = url("/admin/page/edit/", array(
                        'id' => input('backid'),
                    ));
                } else {
                    $result['url'] = url("admin/" . $controllerName . "/index", array(
                        'catid' => input('backid'),
                    ));
                }

                $result['msg'] = '修改成功!';
                $result['code'] = 1;
                return $result;
            } else {
                $result['msg'] = '修改失败!';
                $result['code'] = 0;
                return $result;
            }
        } else {
            $id = input('id');
            $request = Request::instance();
            $controllerName = $request->controller();
            if ($controllerName == 'Page') {
                $p = $this->biao->where('id', $id)->find();
                if (empty($p)) {
                    $data['id'] = $id;
                    $data['title'] = $this->categorys[$id]['catname'];
                    $data['keywords'] = $this->categorys[$id]['keywords'];
                    $this->biao->insert($data);
                }
            }

            $info = $this->biao->where('id', $id)->find();
            $form = new Form($info);
            $returnData['vo'] = $info;
            $returnData['form'] = $form;
            $this->assign('info', $info);
            $this->assign('form', $form);
            $this->assign('title', '编辑内容');
            try {
                if ($this->type == 'page') {
                    return $this->fetch('article/content/page');
                } else {
                    return $this->fetch('article/' . $this->temfile . '/edit');
                }
            } catch (\Exception $th) {
                return $this->fetch('article/content/edit');
            }
        }

    }
    public function add()
    {
        if (request()->isPost()) {
            $request = Request::instance();
            $controllerName = $request->controller();
            $model = $this->biao;
            $fields = $this->fields;
            $data = $this->checkfield($fields, input('post.'));
            if (isset($data['code']) && $data['code'] == 0) {
                return $data;
            }
            if ($fields['createtime'] && empty($data['createtime'])) {
                $data['createtime'] = time();
            }
            if ($fields['updatetime'] && empty($data['updatetime'])) {
                $data['updatetime'] = time();
            }
            if ($controllerName != 'Page') {
                if ($fields['updatetime']) {
                    $data['updatetime'] = $data['createtime'];
                }
            }
            $data['userid'] = session('admin_id');
            $data['username'] = session('username');
            $title_style = '';
            if (isset($data['style_color'])) {
                $title_style .= 'color:' . $data['style_color'] . ';';
                unset($data['style_color']);
            } else {
                $title_style .= 'color:#222;';
            }
            if (isset($data['style_bold'])) {
                $title_style .= 'font-weight:' . $data['style_bold'] . ';';
                unset($data['style_bold']);
            } else {
                $title_style .= 'font-weight:normal;';
            }
            if ($fields['title']['setup']['style'] == 1) {
                $data['title_style'] = $title_style;
            }
            $aid = $data['aid'];
            unset($data['style_color']);
            unset($data['style_bold']);
            unset($data['aid']);
            unset($data['pics_name']);
            //编辑多图和多文件
            foreach ($fields as $k => $v) {
                if ($v['type'] == 'files') {
                    if (!$data[$k]) {
                        $data[$k] = '';
                    }
                    $data[$v['field']] = $data['images'];
                }
                if ($v['type'] == 'linkage') {
                    $data[$v['field']] = implode(',', $data[$v['field']]);
                }
            }
            $id = $model->insertGetId($data);
            if ($id !== false) {
                $catid = $controllerName == 'page' ? $id : $data['catid'];
                if ($aid) {
                    $Attachment = db('attachment');
                    $aids = implode(',', $aid);
                    $data2['id'] = $id;
                    $data2['catid'] = $catid;
                    $data2['status'] = '1';
                    $Attachment->where("aid in (" . $aids . ")")->update($data2);
                }
                if ($controllerName == 'page') {
                    $result['url'] = url("admin/page/edit/id/" . $data['catid'] . ".html");
                } else {
                    $result['url'] = url("admin/" . $controllerName . "/index", array(
                        'catid' => $data['catid'],
                    ));
                }
                $result['msg'] = '添加成功!';
                $result['code'] = 1;
                return $result;
            } else {
                $result['msg'] = '添加失败!';
                $result['code'] = 0;
                return $result;
            }
        } else {
            $form = new Form();
            $this->assign('form', $form);
            $this->assign('title', '添加内容');

            try {
                if ($this->type == 'page') {
                    return $this->fetch('article/content/page');
                } else {
                    return $this->fetch('article/' . $this->temfile . '/edit');
                }

            } catch (\Exception $th) {
                return $this->fetch('article/content/edit');
            }
        }
    }
    public function del()
    {
        $id = input('post.id');
        $model = $this->biao;
        $model->where(array(
            'id' => $id,
        ))->delete();
        return ['code' => 1, 'msg' => '删除成功！'];
    }
    public function delAll()
    {
        $request = Request::instance();
        $controllerName = $request->controller();
        $map['id'] = array(
            'in',
            input('param.ids/a'),
        );
        $model = db('permission')->where('id',input('pid'))->value('module');
        db($model)->where($map)->delete();
        $result['code'] = 1;
        $result['msg'] = '删除成功！';
        $result['url'] = url('index', array(
            'catid' => input('post.catid'),
        ));
        return $result;
    }
    public function ruleOrder()
    {
        $model = $this->biao;
        $catid = input('catid');
        $data = input('post.');
        $model->update($data);
        $result = ['msg' => '排序成功！', 'url' => url('index', array(
            'catid' => $catid,
        )), 'code' => 1];
        return $result;
    }
    public function delImg()
    {
        $file = ROOT_PATH . __PUBLIC__ . input('post.url');
        if (file_exists($file)) {
            is_dir($file) ? dir_delete($file) : unlink($file);
        }
        if (input('post.id')) {
            $picurl = input('post.picurl');
            $picurlArr = explode(':', $picurl);
            $pics = substr(implode(":::", $picurlArr), 0, -3);
            $model = $this->biao;
            $map['id'] = input('post.id');
            $model->where($map)->update(array(
                'pics' => $pics,
            ));
        }
        $result['msg'] = '删除成功!';
        $result['code'] = 1;
        return $result;
    }
    public function state()
    {

        $model = $this->biao;
        $id = Input('id');
        if (Input('status') == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        // echo $status;
        $data['status'] = $status;
        $res = $model->where('id', $id)->update($data);
        if ($res) {
            if (Input('status') == 1) {
                $result['url'] = url('Article/index?status=3');
            }
            $result['msg'] = '修改成功!';
            $result['code'] = 1;
            return $result;
        } else {
            $result['msg'] = '修改失败!';
            $result['code'] = 0;
            return $result;
        }
    }

    /**
     * @name: 拆分字段 分成 列表字段 和 查询字段
     * @descripttion:
     * @param {type}
     * @return:
     */
    public function splitfield()
    {
        $fields = cache($this->moduleid . '_Field');
        // dump($fields);exit;
        $total = 'false';
        if($fields){

            foreach ($fields as $key => $res) {
                $res['setup'] = string2array($res['setup']);
                // dump($res['setup']);exit;
                if ($res['type'] == 'select' || $res['type'] == 'radio' || $res['type'] == 'checkbox') {
                    $optionsarr = [];
                    $options = explode("\n", $res['setup']["options"]);
                    foreach ($options as $rrr) {
                        $va = explode("|", $rrr);
                        $ka = trim($va[1]);
                        $optionsarr[$ka] = $va[0];
                    }
                    // dump($optionsarr );
                    $res["options"] = $optionsarr;
                }
                $this->fields[$key] = $res;
                if ($res['issearch']) {
                    $this->searchfields[$key] = $res;
                }
                if ($res['islist']) {
                    $this->listfields[$key] = $res;
                }
                if ($res['istotal'] == 1) {
                    $total = 'true';
                }
            }

        }
        unset($fields);
        unset($res);
        // 处理layui列表显示
        if($this->listfields){
            $this->listformat();
        }
        // 处理layui查询
        if($this->searchfields){
            $this->searchformat();
        }
        // 是否开启合计
        $this->assign('total', $total);
        $this->assign('fields', $this->fields);
    }

    /**
     * @description: 添加编辑时处理提交的字段
     * @param {type}
     * @return: 返回过滤的$post
     */
    public function checkfield($fields, $post)
    {
        foreach ($post as $key => $val) {
            if (isset($fields[$key])) {

                if (!empty($fields[$key]['required']) && empty($post[$key])) {
                    $result['msg'] = $fields[$key]['errormsg'] ? $fields[$key]['errormsg'] : '缺少必要参数！' . "$key";
                    $result['code'] = 0;
                    return $result;
                }
                switch ($fields[$key]['type']) {
                    case 'textarea':
                        $post[$key] = addslashes($post[$key]);
                        break;
                    case 'editor':
                        $content = stripslashes($post['content']);
                        if ($fields['description'] && $post['description'] == '') {
                            $post['description'] = str_cut(str_replace(array(
                                "\r\n",
                                "\t",
                                '[page]',
                                '[/page]',
                                '&ldquo;',
                                '&rdquo;',
                            ), '', strip_tags($content)), 150);
                        }

                        if (($fields['thumb']||$fields['title']['setup']['thumb'] == "1") && $post['thumb'] == '') {
                            $post['thumb'] = substr(get_html_first_imgurl($content),7);
                        }
                        break;
                    case 'checkbox':
                        $post[$key] = implode(',', $post[$key]);
                        break;
                    case 'datetime':
                        $post[$key] = strtotime($post[$key]);
                        break;
                    case 'linkage':
                        if ($post[$key][0]) {
                            $post[$key] = implode(',', $post[$key]);
                        } else {
                            unset($post[$key]);
                        }
                        break;
                }
            }
        }
        return $post;
    }

    /**
     * @description: 列表过滤字段
     * @param list Array
     * @return: 返回过滤后的list
     */
    public function formatField($list)
    {
        foreach ($list as $k => $v) {

            foreach ($v as $kk => $vv) {
                switch ($this->fields[$kk]['type']) {
                    case 'datetime':
                        if ($this->fields[$kk]['setup']['option'] == 'year') {
                            $list[$k][$kk] = date('Y', $vv);
                        } else if ($this->fields[$kk]['setup']['option'] == 'month') {
                            $list[$k][$kk] = date('Y-m', $vv);
                        } else if ($this->fields[$kk]['setup']['option'] == 'datetime') {
                            $list[$k][$kk] = date('Y-m-d H:i:s', $vv);
                        } else if ($this->fields[$kk]['setup']['option'] == 'time') {
                            $list[$k][$kk] = date('H:i:s', $vv);
                        } else {
                            $list[$k][$kk] = date('Y-m-d H:i:s', $vv);
                        }

                        break;
                    case 'p_id':

                        $list[$k][$kk] = db('permission')->where('id', $vv)->value('name');
                        break;
                    case 'multicolumn':
                        $module = db('permission')->where('id', $this->fields[$kk]['setup']['catid'])->value('module');
                        $list[$k][$kk] = db($module)->where('id',$vv)->value('title');
                        break;
                    case 'image':
                        $list[$k][$kk] = imgUrl($vv);
                        break;
                    case 'radio':
                        $options = explode("\n", $this->fields[$kk]['setup']['options']);
                        foreach ($options as $kkk => $rrr) {

                            $va = explode("|", $rrr);
                            $ka = trim($va[1]);
                            $optionsarr[$va[1]] = $va[0];
                        }
                        $list[$k][$kk] = $optionsarr[$vv];
                        break;
                    case 'checkbox':
                        $options = explode("\n", $this->fields[$kk]['setup']['options']);
                        foreach ($options as $kkk => $rrr) {
                            $va = explode("|", $rrr);
                            $ka = trim($va[1]);
                            $optionsarr[$va[1]] = $va[0];
                        }
                        $vv = explode(',', $vv);
                        $list[$k][$kk] = $optionsarr[$vv[0]] . ',' . $optionsarr[$vv[1]];
                        break;
                    case 'select':
                        if ($this->fields[$kk]['setup']['multiple'] == 0) {
                            $options = explode("\n", $this->fields[$kk]['setup']['options']);
                            foreach ($options as $kkk => $rrr) {
                                $va = explode("|", $rrr);
                                $ka = trim($va[1]);
                                $optionsarr[$va[1]] = $va[0];
                            }
                            $list[$k][$kk] = $optionsarr[$vv];

                        } else {
                            $options = explode("\n", $this->fields[$kk]['setup']['options']);
                            foreach ($options as $kkk => $rrr) {
                                $va = explode("|", $rrr);
                                $ka = trim($va[1]);
                                $optionsarr[$va[1]] = $va[0];
                            }
                            $vv = explode(',', $vv);
                            $list[$k][$kk] = $optionsarr[$vv[0]] . ',' . $optionsarr[$vv[1]];

                        }

                        break;
                    default:
                        break;
                }
            }
        }
        return $list;
    }
    /**
     * @description: 处理列表筛选条件
     * @param {type}
     * @return: 返回map
     */
    public function formatMap($post)
    {
        $map = [];
        foreach ($post as $k => $v) {
            if ($this->searchfields[$k]) {
                // 搜索字段中
                switch ($this->searchfields[$k]['type']) {
                    case 'datetime':
                        $timeArr = explode(' - ', $v);
                        $start = strtotime($timeArr[0]);
                        $end = strtotime($timeArr[1]);
                        $map[$k][] = ['>', $start];
                        $map[$k][] = ['<', $end];
                        break;
                    case 'title':
                        $map[$k] = array(
                            'like',
                            '%' . $v . '%',
                        );
                        break;
                    case 'text':
                        $map[$k] = array(
                            'like',
                            '%' . $v . '%',
                        );
                        break;
                    case 'select':
                        $map[] = ['exp', Db::raw('FIND_IN_SET(' . $v . ',' . $k . ')')];
                        break;
                    default:
                        $map[$k] = $v;
                        break;
                }
            } else {
                // 不在搜索字段中
                $map[$k] = $v;
            }
        }
        // dump($map);exit;
        return $map;
    }
    /**
     * @name: 处理layui列表显示
     * @param {type}
     * @return: 返回json
     */

    public function listformat()
    {
        $listArr = [];
        $listArr[0]['type'] = 'checkbox';
        $listArr[0]['fixed'] = 'left';
        $listArr[0]['width'] = '6%';
        $i = 1;
        foreach ($this->listfields as $k => $v) {
            $listArr[$i]['field'] = $v['field'];
            $listArr[$i]['title'] = $v['name'];
            $listArr[$i]['templet'] = '#' . $v['field'];
            $listArr[$i]['width'] = ((100-16)/(count($this->listfields))).'%';
            $i++;
        }
        array_push($listArr, [
            'align' => 'center',
            'toolbar' => '#action',
            'width' => '10%',
            'title' => '操作',
            'fixed' => 'right'
        ]);
        $this->assign('listArr', json_encode($listArr));
    }
    /**
     * @name: 处理layui查询
     * @param {type}
     * @return: 返回json
     */
    public function searchformat()
    {
        $searchArr = [];
        $i = 0;
        foreach ($this->searchfields as $k => $v) {
            $searchArr[$i]['name'] = $v['field'];
            $searchArr[$i]['elemName'] = $v['name'];
            switch ($v['type']) {
                case 'datetime':
                    $searchArr[$i]['type'] = 'date';
                    break;
                case 'select':
                    $searchArr[$i]['type'] = 'select';
                    $options = explode("\n", $v['setup']['options']);
                    foreach ($options as $kkk => $rrr) {
                        $va = explode("|", $rrr);
                        $ka = trim($va[1]);
                        $optionsarr[$kkk]['name'] = $va[0];
                        $optionsarr[$kkk]['value'] = $ka;
                    }
                    $searchArr[$i]['data'] = $optionsarr;
                    break;
                case 'multicolumn':
                    $searchArr[$i]['type'] = 'select';
                    $table = db('permission')->where('id',$v['setup']['catid'])->value('module');
                    $optionsarr = db($table)->select();
                    $searchArr[$i]['data'] = $optionsarr;
                    break;
                default:
                    $searchArr[$i]['type'] = 'input';
                    break;
            }

            $i++;
        }
        // dump($searchArr);exit;
        $this->assign('searchfields', json_encode($searchArr));
    }

    /**
     * @description: 获取地址
     * @param {type}
     * @return:
     */
    public function getRegion()
    {
        $Region = db("region");
        $map['pid'] = input("pid");
        $list = $Region->where($map)->select();
        return $list;
    }
}
