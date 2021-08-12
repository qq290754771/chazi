<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpStudy\PHPTutorial\WWW\chazinew/app/admin\view\article/content/index.html";i:1623217705;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\admin\view\common\head.html";i:1617070101;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\admin\view\common\foot.html";i:1608189482;}*/ ?>
<!--
 * @Title:
 * @Descripttion:
 * @version:
 * @Author: wzs
 * @Date: 2020-05-09 19:58:17
 * @LastEditors: wzs
 * @LastEditTime: 2020-08-01 19:48:05
 -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?php echo config('sys_name'); ?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/static/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/public/static/admin/css/admin.css" media="all">
  <link rel="stylesheet" href="/public/static/admin/css/tableFilter.css" media="all">

  <!-- <link rel="stylesheet" href="/public/static/admin/css/template.css" media="all">
  <link rel="stylesheet" href="/public/static/plugins/font-awesome/css/font-awesome.min.css" media="all"> -->
  <script src="/public/static/layui/layui.js"></script>
  <script src="/public/static/ueditor/ueditor.config.js" type="text/javascript"></script>
  <script src="/public/static/ueditor/ueditor.all.min.js" type="text/javascript"></script>
  <script src="/public/static/common/js/jquery.2.1.1.min.js"></script>
  <script src="/public/static/admin/js/xm-select.js"></script>
  <script src="/public/static/admin/js/spectrum/spectrum.js"></script>
  <link rel="stylesheet" href="/public/static/admin/js/spectrum/spectrum.css">
  <script src='/public/static/common/js/layui-mz-min.js'></script>
  <style>
      .layui-carousel>[carousel-item]>*{
        background-color: #fff;
      }

      .layui-nav .layui-carousel .layui-this:after{
        display: none;
      }
  </style>
</head>


<body style="font-size:14px">
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <!-- 侧边菜单 -->
      <div class="layui-layout-main">
        <div class="layui-header">
          <!-- 头部区域 -->
          <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item layadmin-flexible" lay-unselect>
              <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                  <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                </a>
            </li>
            <li class="layui-nav-item layui-hide-xs" lay-unselect>
              <a href="/admin/index.html" target="_blank" title="前台">
                  <i class="layui-icon layui-icon-website"></i>
                </a>
            </li>
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;" layadmin-event="refresh" data-url="<?php echo url('index/clear'); ?>" title="刷新">
                  <i class="layui-icon layui-icon-refresh-3"></i>
                </a>
            </li>
          </ul>
          <ul class="layui-nav layui-layout-right" style="padding-right: 20px;" lay-filter="layadmin-layout-right">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"><img src="<?php echo imgUrl(session('avatar')); ?>" class="layui-nav-img"><?php echo session('username'); ?></a>
              <dl class="layui-nav-child">
              <?php if(session('admin_id') == 1): ?>
                <dd><a pop-href="<?php echo url('system.admin/edit'); ?>?admin_id=<?php echo session('admin_id'); ?>" href="javascript:void(0)"><i class="layui-icon layui-icon-tips" style="margin-right: 10px;"></i>基本资料</a></dd>
                <dd><a pop-href="<?php echo url('system.admin/edit'); ?>?admin_id=<?php echo session('admin_id'); ?>" style="display:flex;justify-content: center;" href="javascript:void(0)"><i class="layui-icon layui-icon-password" style="margin-right: 10px;"></i>修改密码</a></dd>
                <hr>
              <?php endif; ?>
                <dd ><a href="<?php echo url('index/logout'); ?>" style="display:flex;justify-content: center;"><i class="layui-icon layui-icon-logout" style="margin-right: 10px;"></i><span>退出登录</span></a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-side layui-side-menu">
      <div class="layui-side-scroll">
        <div class="layui-logo" lay-href="<?php echo url('main'); ?>">
          <span style="font-size:24px;font-weight: bold;"><?php echo config('sys_name'); ?></span>
        </div>

        <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
          <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
          <li data-name="<?php echo $vo['title']; ?>" class="layui-nav-item">
            <?php if($vo['children']): ?>
            <a href="javascript:;" lay-tips="<?php echo $vo['name']; ?>" lay-direction="2">
              <i class="layui-icon layui-icon-<?php echo $vo['icon']; ?>"></i>
                <cite><?php echo $vo['name']; ?></cite>
            </a>
            <?php else: ?>
            <a <?php if($vo['path'] != '#'): ?>lay-href="<?php echo url($vo['path']); ?>" <?php endif; ?> lay-tips="<?php echo $vo['name']; ?>" lay-direction="2">
              <i class="layui-icon layui-icon-<?php echo $vo['icon']; ?>"></i>
                <cite><?php echo $vo['name']; ?></cite>
            </a>
            <?php endif; if($vo['children']): if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voa): $mod = ($i % 2 );++$i;?>
                <dl class="layui-nav-child">
                  <?php if($voa['children']): ?>
                  <dd data-name="<?php echo $vob['name']; ?>">
                    <a href="javascript:;"><?php echo $voa['name']; ?></a>
                    <dl class="layui-nav-child">
                      <?php if(is_array($voa['children']) || $voa['children'] instanceof \think\Collection || $voa['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $voa['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vob): $mod = ($i % 2 );++$i;?>
                      <dd data-name="<?php echo $vob['name']; ?>" class="layui-nav-item">
                        <?php if($vob['children']): ?>
                        <a href="javascript:;"><?php echo $vob['name']; ?></a>
                        <dl class="layui-nav-child">
                          <?php if(is_array($vob['children']) || $vob['children'] instanceof \think\Collection || $vob['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vob['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voc): $mod = ($i % 2 );++$i;?>
                          <dd data-name="<?php echo $voc['name']; ?>"><a lay-href="<?php echo url($voc['path']); ?>"><?php echo $voc['name']; ?></a></dd>
                          <?php endforeach; endif; else: echo "" ;endif; ?>
                        </dl>
                        <?php else: ?>
                        <a lay-href="<?php echo url($vob['path']); ?>"><?php echo $vob['name']; ?></a>
                        <?php endif; ?>
                      </dd>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                  </dd>
                  <?php else: ?>
                  <dd data-name="<?php echo $vob['name']; ?>">
                    <a lay-href="<?php echo url($voa['path']); ?>"><?php echo $voa['name']; ?></a>
                  </dd>
                  <?php endif; ?>
                </dl>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
          </li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>
         
        <div class="layui-body" >
          <div class="layadmin-tabsbody-item layui-show" id="LAY_app_body">
              <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
                <a lay-href="/admin">首页</a><span lay-separator="">/</span>
                <?php if($active_pname): ?><a ><?php echo $active_pname; ?></a><span lay-separator="">/</span><?php endif; ?>
                <a><cite><?php echo $active_name; ?></cite></a>
              </div>


<style>
    #condition .layui-form-item {
        margin-bottom: 0;
    }
</style>
<div class="layui-fluid" id="doc-content">
    <div class="layui-card">
        <div class="layui-card-header"><?php echo $pageName; ?><?php echo lang('list'); ?></div>
        <div class="layui-card-body" pad15>
            <div class="demoTable" style="display: flex;">
                <?php if(($controller == 'huodong' && session('admin_id') != 1) || ($controller == 'jilu' &&
                session('admin_id') != 1)): else: ?>
                <a pop-href="<?php echo url('add'); ?>?pid=<?php echo input('pid'); ?>" class="layui-btn"
                    style="margin-right: 10px;"><?php echo lang('add'); ?></a>
                <?php endif; ?>
                <div id="condition"></div>
                <!--<a href="<?php echo url('index',['pid'=>input('pid')]); ?>" class="layui-btn">显示全部</a>-->
                 <button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>
                <a href="<?php echo url('index',['pid'=>input('pid')]); ?>" class="layui-btn"
                    style="float:right;margin-left: auto;">刷新</a>
                <div style="clear: both;"></div>
            </div>
            <div class="slist" id="slist">
                <div class="stit">筛选条件:</div>
                <div class="list"></div>
            </div>
            <table class="layui-table" id="list" lay-filter="list"></table>
        </div>
    </div>
</div>

<script type="text/html" id="title">
    {{# if(d.thumb){ }}<i class="layui-icon layui-icon-picture" style="margin-right:5px;"
        onmouseover="layer.tips('<img src=/public//{{d.thumb}}>',this,{tips: [2, '#fff']});"
        onmouseout="layer.closeAll();"></i>{{# } }}
    <span style="{{d.title_style}}">{{d.title}}</span>
</script>

<script type="text/html" id="image">
    <div style="text-align: center">
        {{# if(d.image){ }}
        {{d.image}}
        {{# }else{  }}
        {{d.images}}
        {{# } }}
    </div>
</script>
<script type="text/html" id="action">
    <a pop-href="<?php echo url('edit'); ?>?id={{d.id}}&pid=<?php echo input('pid'); ?>" class="layui-btn layui-btn-xs">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/html" id="sort">
    <input name="sort" type="number" data-id="{{d.id}}" class="list_order layui-input" value="{{d.sort}}" size="10" style="text-align:center;padding-left:0;" lay-event="sort"/>
</script>

<script>
    layui.use(['table', 'admin', 'tableFilter', 'selectC'], function () {
        var table = layui.table,
            $ = layui.jquery,
            admin = layui.admin(),
            tableFilter = layui.tableFilter,
            selectC = layui.selectC;
        admin.init();
        var that = null;
        tableIn = table.render({
            elem: '#list',
            url: '<?php echo url(input("type")?"index?type=".input("type"):"index"); ?>?p_id=<?php echo input("pid"); ?>',
            method: 'post',
            page: true,
            toolbar: '#toolbarDemo',
            totalRow: <?php echo $total; ?>,
            cellMinWidth: 80,
            id:'content',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [
                <?php echo $listArr; ?>
            ],
            done: function (res, curr, count) {
                that = this
                apitableFilterIns.reload()
                admin.init();
            }
        });
        var apitableFilterIns = tableFilter.render({
            'elem': '#list',
            'parent': '#doc-content',
            'mode': 'api',
            'filters': [

            ],
            'done': function (filters) {
            }
        })
        var condition = selectC({
            elem: "#condition",
            number: 1,
            reset: true,
            options: <?php echo $searchfields; ?>,
            search: function (data) {
                that.where = {}
                tableIn.reload({
                    where: data
                });
            }
        })
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'status') {
                loading = layer.load(1, {
                    shade: [0.1, '#fff']
                });
                $.post('<?php echo url("state"); ?>', {
                    'id': data.id,
                    'status': data.status
                }, function (res) {
                    layer.close(loading);
                    if (res.code == 1) {
                        tableIn.reload({
                            where: that.where
                        })
                    } else {
                        layer.msg(res.msg, {
                            time: 1000,
                            icon: 2
                        });
                        return false;
                    }
                })
            } else if (obj.event === 'del') {
                layer.confirm('<?php echo lang("Are you sure you want to delete it"); ?>', function (index) {
                    $.post("<?php echo url('del'); ?>", {
                        id: data.id
                    }, function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg, {
                                time: 1000,
                                icon: 1
                            });
                            tableIn.reload({
                                where: that.where
                            })
                        } else {
                            layer.msg(res.msg, {
                                time: 1000,
                                icon: 2
                            });
                        }
                    });
                    layer.close(index);
                });
            }
        });
        $('#delAll').click(function(){
            layer.confirm('确认要删除选中的内容吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delAll'); ?>", {ids: ids,pid:<?php echo input('pid'); ?>}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
        $('body').on('blur','.list_order',function() {
            var id = $(this).attr('data-id');
            var sort = $(this).val();
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post('<?php echo url("ruleOrder"); ?>',{id:id,sort:sort},function(res){
                layer.close(loading);
                if(res.code === 1){
                    layer.msg('排序成功', {time: 1000, icon: 1}, function () {
                        renderTable();
                    });
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                }
            })
        });
    });
</script>
<!--
 * @Title: 底部模板
 * @Descripttion: 底部模板
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-06-17 19:59:10
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-06 16:26:15
-->     </div>
</div>
</div>
</div>
</div>
<script>
layui.config({
  base: '/public/static/admin/js/module/',
  version: Date.parse(new Date()),
  debug: true
}).extend({
  sliderVerify: 'sliderVerify'
}).use(['jquery','admin','carousel'], function () {
  var admin = layui.admin();
  var carousel = layui.carousel;
  admin.initPage()
    carousel.render({
    elem: '#test1',
    anim: 'updown',
    width: '500px',
    height: '64px',
    arrow: 'none',
    indicator: 'none',
    interval: 3000,
    autoplay: true
  });
})
</script>
</body>
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
<script src="/public/static/admin/js/ie8hack/html5shiv.min.js"></script>
<script src="/public/static/admin/js/ie8hack/respond.min.js"></script>
<script src="/public/static/admin/js/ie8hack/placeholders.min.js"></script>
<![endif]-->

</html>