<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"D:\phpStudy\PHPTutorial\WWW\chazinew/app/admin\view\module\index/index.html";i:1623718541;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\admin\view\common\head.html";i:1617070101;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\admin\view\common\foot.html";i:1608189482;}*/ ?>
<!--
 * @Title: 模型列表页
 * @Descripttion: 模型列表页
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-10 22:13:08
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 19:39:03
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


<div class="layui-fluid">
   <div class="layui-card">
    <div class="admin-main layui-anim layui-anim-upbit">
      <div class="layui-card-header"><?php echo lang('module'); ?><?php echo lang('list'); ?></div>
      <div class="layui-card-body" pad15>
        <div style="padding-bottom: 5px;">
            <a pop-href="<?php echo url('add'); ?>" class="layui-btn layui-btn-small"><?php echo lang('add'); ?><?php echo lang('module'); ?></a>
        </div>
        <table class="layui-table" id="list" lay-filter="list"></table>
      </div>
    </div>
   </div>
</div>

<script type="text/html" id="action">
    <a pop-href="<?php echo url('module.fields/index'); ?>?id={{d.id}}" class="layui-btn layui-btn-normal layui-btn-xs">模型字段</a>
    <a pop-href="<?php echo url('edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>
<script type="text/html" id="status">
    {{# if(d.status==1){ }}
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="status">开启</a>
    {{# }else{  }}
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="status">禁用</a>
    {{# } }}
</script>
<script>
    layui.use(['table', 'admin'], function() {
        var table = layui.table, admin = layui.admin(),$ = layui.jquery;
        admin.init();
        tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            page:true,
            cellMinWidth: 80,
            cols: [[
                {field: 'id', title: '<?php echo lang("id"); ?>', width:60, fixed: true},
                {field: 'title', title: '<?php echo lang("module"); ?><?php echo lang("name"); ?>'},
                {field: 'name', title: '<?php echo lang("table"); ?>'},
                {field: 'description', title: '<?php echo lang("detail"); ?>'},
                {field: 'status', align: 'center',title: '<?php echo lang("status"); ?>', width: 80,toolbar: '#status'},
                {width: 200, align: 'center', toolbar: '#action'}
            ]]
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'status') {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post('<?php echo url("moduleState"); ?>', {'id': data.id}, function (res) {
                    layer.close(loading);
                    if (res.status == 1) {
                        if (res.moduleState == 1) {
                            obj.update({
                                status: '<a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="status">开启</a>'
                            });
                        } else {
                            obj.update({
                                status: '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="status">禁用</a>'
                            });
                        }
                    } else {
                        layer.msg('操作失败！', {time: 1000, icon: 2});
                        return false;
                    }
                })
            }else if(obj.event === 'del'){
                layer.confirm('你确定要删除该模型吗？', {icon: 3}, function (index) {
                    $.post("<?php echo url('del'); ?>",{id:data.id},function(res){
                        if(res.code==1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
    })
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
