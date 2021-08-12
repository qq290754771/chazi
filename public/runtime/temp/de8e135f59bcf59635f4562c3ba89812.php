<?php if (!defined('THINK_PATH')) exit(); /*a:20:{s:77:"D:\phpStudy\PHPTutorial\WWW\chazinew/app/admin\view\article/content/edit.html";i:1608189482;s:73:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\admin\view\common\head_form.html";i:1608189482;s:65:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\title.html";i:1608189482;s:64:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\text.html";i:1608189482;s:71:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\multicolumn.html";i:1608791795;s:65:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\radio.html";i:1608189482;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\datetime.html";i:1608189482;s:66:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\addbox.html";i:1608189482;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\textarea.html";i:1621931466;s:66:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\editor.html";i:1608189482;s:66:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\number.html";i:1608189482;s:66:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\select.html";i:1608189482;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\checkbox.html";i:1608189482;s:65:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\image.html";i:1608189482;s:66:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\images.html";i:1608189482;s:65:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\video.html";i:1608189482;s:65:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\catid.html";i:1608189482;s:67:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\linkage.html";i:1608189482;s:68:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\common\fields\position.html";i:1608189482;s:73:"D:\phpStudy\PHPTutorial\WWW\chazinew\app\admin\view\common\foot_form.html";i:1608189482;}*/ ?>
<!--
 * @Title:
 * @Descripttion:
 * @version:
 * @Author: wzs
 * @Date: 2020-05-19 19:33:51
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 19:40:34
-->
<!--
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-06-17 19:59:10
 * @LastEditors: wzs
 * @LastEditTime: 2020-08-05 11:47:25
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
  <link rel="stylesheet" href="/public/static/admin/js/spectrum/spectrum.css">
  <script src='/public/static/common/js/layui-mz-min.js'></script>
</head>


<body style="font-size: 14px;">


<script>
    var ADMIN = '/public/static/admin';
    var UPURL = "<?php echo url('UpFiles/upImages'); ?>";
    var PUBLIC = "/public/";
    var imgClassName,fileClassName;
</script>
<style>
    html {
        background-color: #fff;
    }
</style>
<div class="layui-fluid" style="font-size: 14px;">
    <form class="layui-form" method="post"  enctype ="multipart/form-data">
        <?php if($info['id'] != ''): ?><input TYPE="hidden" name="id" value="<?php echo $info['id']; ?>"><?php endif; if(is_array($fields) || $fields instanceof \think\Collection || $fields instanceof \think\Paginator): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;if(!empty($r['status'])): ?>
                <div class="layui-form-item">
                    <label class="layui-form-label"><?php echo $r['name']; ?></label>
                    <?php if($r['type'] == 'images'): ?>
                    <div class="layui-input-block dtsc" data-f="<?php echo $r['field']; ?>" id="box_<?php echo $r['field']; ?>">
                    <?php else: ?>
                    <div class="layui-input-block" id="box_<?php echo $r['field']; ?>">
                    <?php endif; if($r['type'] == 'title'): ?>
                    <!--
 * @Title: 标题组件
 * @Descripttion: 标题组件
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 20:50:58
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 17:29:35
 -->
<?php
if(array_key_exists('title_style',$form->data)){
    if($form->data['title_style']){
        $title_style = explode(';',$form->data['title_style']);
        $style_color = explode(':',$title_style[0]);
        $style_bold = explode(':',$title_style[1]);
        $style_color = $style_color[1];
        $style_bold = $style_bold[1];
    }
}
$boldchecked= $style_bold=='bold' ? 'checked' : '';
?>
<input autocomplete="off" type="text" name="<?php echo $r['field']; ?>" data-required="<?php echo $r['required']; ?>"
    value="<?php echo $form->data[$r['field']]; ?>" data-min="<?php echo $r['minlength']; ?>" data-max="<?php echo $r['maxlength']; ?>"
    data-errormsg="<?php echo $r['errormsg']; ?>" title="<?php echo $r['name']; ?>" placeholder="请输入<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>"
    lay-verify="defaul<?php echo $r['pattern']!='defaul'?'|'.$r['pattern']:''; ?>" class="<?php echo $r['class']; ?> layui-input" />

<?php if($r['setup']['style']): ?>
</div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">标题颜色</label>
    <div class="layui-input-block">
        <input type="text" name="style_color" id="style_color" value="" />
        <!-- <div id="style_color"></div> -->
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">加粗</label>
    <div class="layui-input-block">
        <input type="checkbox" name="style_bold" value="bold" <?php echo $boldchecked; ?> title="加粗">
<?php endif; if($r['setup']['thumb']): ?>
</div>
</div>
<div class="layui-form-item">
    <textarea id="uploadEditor" style="display: none;"></textarea>
    <label class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <input type="hidden" name="thumb" id="thumb" value="<?php echo $form->data['thumb']; ?>">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-primary" onClick="upImage()">
                <i class="icon icon-upload3"></i>
                点击上传
            </button>
            <div class="layui-upload-list">
                <img class="layui-upload-img" width="95" id="coolThumb" src="<?php echo !empty($form->data['thumb'])?'/public/'.$form->data['thumb']:'/public/static/admin'.'/images/tong.png'; ?>">
                <p id="thumbText"></p>
            </div>
        </div>
        <?php if($r['setup']['info']): ?>
        <div><?php echo $r['setup']['info']; ?></div>
        <?php endif; ?>
        <script src="/public/static/admin/js/spectrum/spectrum.js"></script>
        <script>
            $("#style_color").spectrum({
                showPaletteOnly: true,
                showPalette:true,
                hideAfterPaletteSelect:true,
                palette: [
                    ['#FF5722','#5FB878','#1E9FFF','#F7B824'],
                    ['#666666','#000000','#999933','#CCFF00'],
                    ['#FF9900','#333399','#009966','#FF33CC']
                ]
            });

            var o_ueditorupload = UE.getEditor('uploadEditor', {
                autoHeightEnabled: false,
                isShow: false,
                focus: false,
                enableAutoSave: false,
                autoSyncData: false,
                autoFloatEnabled: false,
                wordCount: false,
                sourceEditor: null,
                scaleEnabled: true,
                toolbars: [
                    ['insertimage', 'attachment']
                ]
            });
            o_ueditorupload.ready(function () {
                o_ueditorupload.hide();
                o_ueditorupload.addListener('beforeInsertImage', function (t, arg) {
                    $('#coolThumb').attr('src', arg[0].src);
                    $('#thumb').val(arg[0].src.substring(7, arg[0].src.lenght));
                });
            });

            function upImage() {
                var myImage = o_ueditorupload.getDialog('insertimage');
                myImage.open();
            }
        </script>
<?php endif; elseif($r['type'] == 'text'): ?>
                    <!--
 * @Title: text文本模块
 * @Descripttion: text文本模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
 <input
 autocomplete="off"
 type="<?php echo !empty($r['setup']['ispassword'])?'password':'text'; ?>"
 data-required="<?php echo $r['required']; ?>"
 min="<?php echo $r['minlength']; ?>"
 max="<?php echo $r['maxlength']; ?>"
 errormsg="<?php echo $r['errormsg']; ?>"
 title="<?php echo $r['name']; ?>"
 id="<?php echo $r['field']; ?>"
 placeholder="请输入<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>" lay-verify="defaul<?php echo $r['pattern']!='defaul'?'|'.$r['pattern']:''; ?>"
 class="<?php echo $r['class']; ?> layui-input"
 name="<?php echo $r['field']; ?>"
 value="<?php echo $form->data[$r['field']]; ?>"
 />
<span><?php echo $r['setup']['info']; ?></span>

                    <?php elseif($r['type'] == 'multicolumn'): ?>
                    <!--
 * @Title:
 * @Author: wzs
 * @Date: 2020-05-13 08:59:06
 * @LastEditors: wzs
 * @LastEditTime: 2020-08-13 13:14:25
 * @Description:
 -->
<?php
 $type = $r["setup"]["multitype"];
 $id = $r["setup"]["catid"];
 if ( $type == 'con' ) {
    $menu = db( 'permission' )->find( $id );
$module = $menu['module'];
$list = db( $module )->field( 'title, id as value' )->where('p_id', $id)->order('sort asc,id asc')->select();
foreach ( $list as $k=>$v ) {
$list[$k]['name'] = $v['title'];
}
$listjson = json_encode($list);
$mid = $form->data[$r['field']];
$value = json_encode(db($module)->where('id','in',$mid)->field('title as name,id as value')->select());
}
switch($r['setup']['multiple']): case "0": ?>
<div id="<?php echo $r['field']; ?>"></div>
<script>
    // https://maplemei.gitee.io/xm-select/#/senior/form
    var <?php echo $r['field']; ?> = xmSelect.render({
        el: '#<?php echo $r["field"]; ?>',
        name: '<?php echo $r["field"]; ?>',
        tips: "请选择<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>",
        language: 'zn',
        radio: true,
        paging: true,
        filterable: true,
        direction: 'up',
        data: <?php echo $listjson; ?>
    })
    <?php if($form->data[$r['field']]): ?>
    <?php echo $r['field']; ?>.setValue([
        {value: <?php echo $form->data[$r['field']]; ?>},
    ])
    <?php endif; ?>
</script>
<?php break; case "1": ?>
<div id="<?php echo $r['field']; ?>"></div>
<script>
    // https://maplemei.gitee.io/xm-select/#/senior/form
    var <?php echo $r['field']; ?> = xmSelect.render({
        el: '#<?php echo $r["field"]; ?>',
        name: '<?php echo $r["field"]; ?>',
        tips: "请选择<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>",
        language: 'zn',
        paging: true,
        filterable: true,
        direction: 'up',
        data: <?php echo $listjson; ?>
    })
    <?php if($form->data[$r['field']]): ?>
    <?php echo $r['field']; ?>.setValue(
        <?php echo $value; ?>
    )
    <?php endif; ?>
</script>
<?php break; case "2": if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
<input type="radio" name="<?php echo $r["field"]; ?>" value="<?php echo $val['value']; ?>" title="<?php echo $val['title']; ?>" <?php if($form->data[$r['field']] == $val['value']): ?>checked <?php endif; ?>/>
<?php endforeach; endif; else: echo "" ;endif; break; case "3": $value = explode(',',$form->data[$r['field']]);if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
<input type="checkbox" name="<?php echo $r["field"]; ?>[]" value="<?php echo $val['value']; ?>" title="<?php echo $val['title']; ?>" <?php if(in_array($val['value'],$value)): ?>checked <?php endif; ?>/>
<?php endforeach; endif; else: echo "" ;endif; break; endswitch; elseif($r['type'] == 'radio'): ?>
                    <!--
 * @Title: 
 * @Author: wzs
 * @Date: 2020-05-14 16:19:47
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-15 10:20:27
 * @Description: 
 -->

<?php
 $value = $form->data[$r['field']];
 $r['setup'] = is_array($r['setup']) ? $r['setup'] : string2array($r['setup']);
 $value = $value ? $value : $r['setup']['default'];
 $labelwidth = $r['setup']['labelwidth'];
 $optionsarr = [];
 if (isset($r['setup']['options'])) {
    $options = $r['setup']['options'];
    $options = explode("\n", $r['setup']['options']);
    foreach ($options as $kk => $rr) {
        $v = explode("|", $rr);
        $k = trim($v[1]);
        $optionsarr[$kk]['title'] = $v[0];
        $optionsarr[$kk]['id'] = $k;
    }
 }
if(is_array($optionsarr) || $optionsarr instanceof \think\Collection || $optionsarr instanceof \think\Paginator): $i = 0; $__LIST__ = $optionsarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<input name="<?php echo $r['field']; ?>" id="<?php echo $r['field']; ?>_<?php echo $i; ?>" <?php if($value == $vo['id']): ?>checked<?php endif; ?>  value="<?php echo $vo['id']; ?>"   type="radio" class="ace" title="<?php echo $vo['title']; ?>" />
<?php endforeach; endif; else: echo "" ;endif; elseif($r['type'] == 'datetime'): ?>
                    <!--
 * @Title: 时间模块
 * @Author: wzs
 * @Date: 2020-05-15 17:11:21
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 21:20:23
 * @Description: 
-->
<?php
if($r['setup']['option'] == 'year'){
    $value = $form->data[$r['field']] ? toDate($form->data[$r['field']],"Y") :
    toDate(time(),"Y"); 
}
else if($r['setup']['option'] == 'month'){
    $value = $form->data[$r['field']] ? toDate($form->data[$r['field']],"Y-m") :
    toDate(time(),"Y-m"); 
}
else if($r['setup']['option'] == 'datetime'){
    $value = $form->data[$r['field']] ? toDate($form->data[$r['field']],"Y-m-d H:i:s") :
    toDate(time(),"Y-m-d H:i:s"); 
}
else if($r['setup']['option'] == 'time'){
    $value = $form->data[$r['field']] ? toDate($form->data[$r['field']],"H:i:s") :
    toDate(time(),"H:i:s"); 
}
else{
    $value = $form->data[$r['field']] ? toDate($form->data[$r['field']],"Y-m-d H:i:s") :
    toDate(time(),"Y-m-d H:i:s"); 
}
?>
<input
  type="datetime"
  title="<?php echo $r['name']; ?>"
  name="<?php echo $r['field']; ?>"
  data-required="<?php echo $r['required']==1?'required' : ''; ?>"
  placeholder="请选择<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>"
  value="<?php echo $value; ?>"
  class="<?php echo $r['class']; ?> layui-input"
  id="<?php echo $r['field']; ?>"
/>

<script>
  layui.use(["laydate"], function () {
    var laydate = layui.laydate;
    laydate.render({
      elem: "#<?php echo $r['field']; ?>", //指定元素
      type: "<?php echo $r['setup']['option']; ?>",
      <?php if($r['setup']['option'] == 'year'): ?>
      format: "yyyy"
      <?php elseif($r['setup']['option'] == 'month'): ?>
      format: "yyyy-MM"
      <?php elseif($r['setup']['option'] == 'datetime'): ?>
      format: "yyyy-MM-dd HH:mm:ss"
      <?php elseif($r['setup']['option'] == 'time'): ?>
      format: "HH:mm:ss"
      <?php else: ?>
      format: "yyyy-MM-dd HH:mm:ss"
      <?php endif; ?>
    });
  });
</script>

                    <?php elseif($r['type'] == 'addbox'): ?>
                    <!--
 * @Title: 添加框组件
 * @Author: wzs
 * @Date: 2020-05-18 15:34:42
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-19 09:45:57
 * @Description: title-type-field-setting
 * title: 标题
 * type : text 文本框|select 下拉选框|datetime 时间框
 * field ：字段名称
 * setting : 设置 json 格式 如：select  {type:con,id:73} 为id=73下面的内容标题
-->
<?php 
 $addoption = $r['setup']['other'];
 $addoption = explode('|',$addoption);
 $addoptionArr = [];
 foreach($addoption as $k => $v){
    // $addoption[$k]
    //dump(explode('-',$v));
    $arr = explode('-',$v);
    $addoptionArr[$k]['title'] = $arr[0];
    $addoptionArr[$k]['type'] = $arr[1];
    $addoptionArr[$k]['field'] = $arr[2];
    $addoptionArr[$k]['option'] = json_decode($arr[3], true);
 }
?>
<div class="layui-block addbox-<?php echo $r['field']; ?>">
  <div class="layui-inline" style="width: 2em; text-align: center;">编号</div>
  <?php if(is_array($addoptionArr) || $addoptionArr instanceof \think\Collection || $addoptionArr instanceof \think\Paginator): $i = 0; $__LIST__ = $addoptionArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
  <div class="layui-inline">
    <?php switch($vo['type']): case "text": ?>
    <input value="" class="layui-input <?php echo $r['field']; ?>_<?php echo $vo['field']; ?>" placeholder="请输入<?php echo $vo['title']; ?>" />
    <?php break; case "select": ?>
    <select class="<?php echo $r['field']; ?>_<?php echo $vo['field']; ?>" lay-filter="<?php echo $r["field"]; ?>">
      <option value="">请选择<?php echo $vo['title']; ?></option>
      <?php 
          // 调取内容标题
          if($vo['option']['type'] == 'con'){
            $permission = db('permission')->find($vo['option']['id']);
            $plist = db($permission['module'])->select();
          }elseif($vo['option']['type'] == 'cate'){

          }
      if(is_array($plist) || $plist instanceof \think\Collection || $plist instanceof \think\Paginator): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voa): $mod = ($i % 2 );++$i;?>
      <option value="<?php echo $voa['id']; ?>"><?php echo $voa['title']; ?></option>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
    <?php break; case "datetime": break; default: ?>
    <input value="" class="layui-input <?php echo $r['field']; ?>_<?php echo $vo['field']; ?>" placeholder="请输入<?php echo $vo['title']; ?>" />
    <?php endswitch; ?>

  </div>
  <?php endforeach; endif; else: echo "" ;endif; ?>
  <a class="layui-icon layui-icon-add-1" href="javascript:void(0)" id="addboxbtn-<?php echo $r['field']; ?>"></a>
</div>
<div class="layui-block addbox-list-<?php echo $r['field']; ?>"></div>
<input name="<?php echo $r['field']; ?>" value="" class="layui-input" id="<?php echo $r['field']; ?>" type="hidden" />
<script>
  layui.use(["form", "upload", "laydate"], function () {
    var form = layui.form;
    var arr = new Array();
    var laydate = layui.laydate;
    <?php if($form->data[$r['field']]): ?>
    var dataobj = <?php echo $form->data[$r['field']]; ?>;
    if(dataobj){
      $.each(dataobj,function(index,value){
        arr.push(value);
      });  
      <?php echo $r['field']; ?>_subhtml();
    }
    <?php endif; ?>
    // 添加处理数据
    function <?php echo $r['field']; ?>_addarr() {
      var arritem = [];
      <?php if(is_array($addoptionArr) || $addoptionArr instanceof \think\Collection || $addoptionArr instanceof \think\Paginator): $i = 0; $__LIST__ = $addoptionArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      arritem["<?php echo $vo['field']; ?>"] = $(".addbox-<?php echo $r['field']; ?> .<?php echo $r['field']; ?>_<?php echo $vo['field']; ?>").val();
      <?php endforeach; endif; else: echo "" ;endif; ?>
      arr.push(arritem);
    }
    // 修改处理数据
    function <?php echo $r['field']; ?>_changearr() {
      arr = [];
      $(".addbox-item-<?php echo $r['field']; ?>").each(function (i) {
        var arritem = [];
        <?php if(is_array($addoptionArr) || $addoptionArr instanceof \think\Collection || $addoptionArr instanceof \think\Paginator): $i = 0; $__LIST__ = $addoptionArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        arritem["<?php echo $vo['field']; ?>"] = $(this).find('.<?php echo $r["field"]; ?>_<?php echo $vo['field']; ?>').val();
        <?php endforeach; endif; else: echo "" ;endif; ?>
        arr.push(arritem);
      });
      
    }
    function encodeArray2D(obj) {
      var array = [];
      $.each(obj, function (index, value) {
        var str = "";
        for (var key in value) {
          str = str + '"' + key + '":' + '"' + value[key] + '",';
        }
        array[index] = "{" + str.substring(0, str.length - 1) + "}";
      });
      return "[" + array.join(",") + "]";
    }
    // 设置数据写入最终隐藏域
    function <?php echo $r['field']; ?>_setArr() {
      $("#<?php echo $r['field']; ?>").val(encodeArray2D(arr));
    }
    // 拼接列表结构
    function <?php echo $r['field']; ?>_subhtml() {
      <?php echo $r['field']; ?>_setArr()
      var html = "",
        str = "";
      $.each(arr, function (index, value) {
        html = html + '<div class="layui-block addbox-item-<?php echo $r["field"]; ?>">';
        html = html + ' <div class="layui-inline" style="width: 2em; text-align: center;">' + (index + 1) +'</div>';
        <?php if(is_array($addoptionArr) || $addoptionArr instanceof \think\Collection || $addoptionArr instanceof \think\Paginator): $i = 0; $__LIST__ = $addoptionArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        html = html + '  <div class="layui-inline">';
          <?php switch($vo['type']): case "text": ?>
            html = html + '  <input  value="'+value.<?php echo $vo['field']; ?>+'" class="layui-input <?php echo $r["field"]; ?>_<?php echo $vo['field']; ?>" placeholder="请输入<?php echo $vo['title']; ?>" />';
            <?php break; case "select": ?>
                html = html + '  <select lay-filter="<?php echo $r["field"]; ?>" class="<?php echo $r["field"]; ?>_<?php echo $vo['field']; ?>" >';
                  html = html + '  <option value="">请选择<?php echo $vo['title']; ?></option>';
                    <?php 
                        if($vo['option']['type'] == 'con'){
                            $permission = db('permission')->find($vo['option']['id']);
                            $plist = db($permission['module'])->select();
                        }elseif($vo['option']['type'] == 'cate'){
                          
                        }
                    if(is_array($plist) || $plist instanceof \think\Collection || $plist instanceof \think\Paginator): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voa): $mod = ($i % 2 );++$i;?>
                    html = html + '  <option value="<?php echo $voa['id']; ?>" '+ (value.<?php echo $vo['field']; ?> == <?php echo $voa['id']; ?> ? "selected" : "") +'><?php echo $voa['title']; ?></option>';
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    html = html + '  </select>';
            <?php break; case "datetime": break; default: ?>
            html = html + '  <input value="'+value.<?php echo $vo['field']; ?>+'"  class="layui-input <?php echo $r["field"]; ?>_<?php echo $vo['field']; ?>" placeholder="请输入<?php echo $vo['title']; ?>" />';
          <?php endswitch; ?>
          
        html = html + '</div>';
        <?php endforeach; endif; else: echo "" ;endif; ?>
        html = html + ' <a class="layui-icon layui-icon-close addboxdelbtn-pro[]" href="javascript:void(0)"></a>';
        html = html + '</div>';
      });
      $(".addbox-list-<?php echo $r['field']; ?>").html(html);
      $(".addbox-<?php echo $r['field']; ?> input").val("");
      form.render();
    }
    $(".addbox-<?php echo $r['field']; ?>").on("click", "#addboxbtn-<?php echo $r['field']; ?>", function () {
      <?php echo $r['field']; ?>_addarr();
      <?php echo $r['field']; ?>_subhtml();
    });
    $(".addbox-list-<?php echo $r['field']; ?>").on("input propertychange", "input", function () {
      <?php echo $r['field']; ?>_changearr();
      <?php echo $r['field']; ?>_setArr();
    });

    form.on("select(<?php echo $r['field']; ?>)", function(data){
      <?php echo $r['field']; ?>_changearr();
      <?php echo $r['field']; ?>_setArr();
    });
    
    $("body").on("click", ".addbox-item-<?php echo $r['field']; ?> a", function () {
      var i = $(this).parent().index();
      arr.splice(i, 1);
      <?php echo $r['field']; ?>_subhtml();
    });
  });
</script>
                    <?php elseif($r['type'] == 'textarea'): ?>
                    <!--
 * @Title: areatext多行文本模块
 * @Descripttion: areatext多行文本模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<textarea
        data-required="<?php echo $r['required']; ?>"
        min="<?php echo $r['minlength']; ?>"
        max="<?php echo $r['maxlength']; ?>"
        errormsg="<?php echo $r['errormsg']; ?>"
        title="<?php echo $r['name']; ?>"
        placeholder="请输入<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>"
        lay-verify="defaul<?php echo $r['pattern']!='defaul'?'|'.$info['pattern'] : $r['pattern']; ?>"
        class="<?php echo $r['class']; ?> layui-textarea"
        name="<?php echo $r['field']; ?>"
>
<?php echo $form->data[$r['field']]; ?>
</textarea>

                    <?php elseif($r['type'] == 'editor'): ?>
                    <!--
 * @Title: editor编辑器模块
 * @Descripttion: editor编辑器模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<input type="hidden" id="editType" value="1">
<textarea
        name="<?php echo $r['field']; ?>"
        class="<?php echo $r['class']; ?>"
        id="<?php echo $r['class']; ?>"
>
    <?php echo $form->data[$r['field']]; ?>
</textarea>
<script>var editor = new UE.ui.Editor();editor.render("<?php echo $r['class']; ?>");</script>

                    <?php elseif($r['type'] == 'number'): ?>
                    <!--
 * @Title: number数字模块
 * @Descripttion: number数字模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<input
        type="text"
        class="input-text <?php echo $r['class']; ?> layui-input"
        name="<?php echo $r['field']; ?>"
        id="<?php echo $r['field']; ?>"
        value="<?php echo !empty($form->data[$r['field']])?$form->data[$r['field']] : $r['setup']['default']; ?>"
        size="<?php echo !empty($r['setup']['size'])?$r['setup']['size'] : ''; ?>"  <?php echo getvalidate($r); ?>
/>

                    <?php elseif($r['type'] == 'select'): ?>
                    <!--
 * @Title: select下拉列表模块
 * @Descripttion: select下拉列表模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-08-01 22:46:16
 -->
<?php
$optionsarr = '';
    if(is_array($r['options'])){
        
        $i = 0;
        foreach($r['options'] as $k =>$v) {
            $optionsarr[$i] = array('name' => $v,'value'=>$k);
            $i++;
        }
    }else{
        $options    = $r['setup']['options'];
        $options = explode("\n",$r['setup']['options']);
        foreach($options as $kk =>$v) {
            $v = explode("|",$v);
            $k = trim($v[1]);
            $optionsarr[$kk]=array('name' => $v[0],'value'=>$k);

        }
        
    }
   
    $optionsarr = json_encode($optionsarr);
switch($r['setup']['multiple']): case "0": ?>
    <div id="<?php echo $r['field']; ?>"></div>
    <script>
        // https://maplemei.gitee.io/xm-select/#/senior/form
        var <?php echo $r['field']; ?> = xmSelect.render({
            el: '#<?php echo $r["field"]; ?>',
            name: '<?php echo $r["field"]; ?>',
            tips: "请选择<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>",
            language: 'zn',
            radio: true,
            paging: false,
            filterable: true,
            data: <?php echo $optionsarr; ?>
        })
            <?php if($form->data[$r['field']]): ?>
            <?php echo $r['field']; ?>.setValue([
                {value: <?php echo $form->data[$r['field']]; ?>},
            ])
            <?php endif; ?>
    </script>
 <?php break; case "1": ?>
    <div id="<?php echo $r['field']; ?>"></div>
    <script>
        // https://maplemei.gitee.io/xm-select/#/senior/form
        var <?php echo $r['field']; ?> = xmSelect.render({
            el: '#<?php echo $r["field"]; ?>',
            name: '<?php echo $r["field"]; ?>',
            tips: "请选择<?php echo $r['name']; ?><?php echo $r['required']==1?'(必填)' : ''; ?>",
            language: 'zn',
            paging: true,
            filterable: true,
            data: <?php echo $optionsarr; ?>
        })
        <?php if($form->data[$r['field']]): ?>
            <?php echo $r['field']; ?>.setValue([
                <?php $aa = explode(',',$form->data[$r['field']]);if(is_array($aa) || $aa instanceof \think\Collection || $aa instanceof \think\Paginator): $i = 0; $__LIST__ = $aa;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                {value: <?php echo $vo; ?>},
                <?php endforeach; endif; else: echo "" ;endif; ?>
            ])
        <?php endif; ?>
    </script>
 <?php break; endswitch; elseif($r['type'] == 'checkbox'): ?>
                    <!--
 * @Title: checkbox多选模块
 * @Descripttion: checkbox多选模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-31 14:11:18
 -->
<?php
$optionsarr = '';
if(is_array($r['options'])){
    $optionsarr = $r['options'];
}else{
    $options    = $r['setup']['options'];
    $options = explode("\n",$r['setup']['options']);
    foreach($options as $vs) {
        $v = explode("|",$vs);
        $k = $v[1];
        $optionsarr[$k] = array('title'=>$v[0],'id'=>$v[1]);
    }
    $i = 1;
}
$value = $form->data[$r['field']];
if($value != '') $value = strpos($value, ',') ? explode(',', $value) : array($value);
if(is_array($optionsarr) || $optionsarr instanceof \think\Collection || $optionsarr instanceof \think\Paginator): $key = 0; $__LIST__ = $optionsarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key;?>
<input name="<?php echo $r['field']; ?>[<?php echo $i; ?>]" id="<?php echo $r['field']; ?>_<?php echo $i; ?>" v="<?php echo $value; ?>" key="<?php echo $key; ?>" <?php echo $value && in_array($val['id'], $value)?'checked' : ''; ?> value="<?php echo $val['id']; ?>"  <?php echo getvalidate($r); ?> type="checkbox" class="ace" title="<?php echo $val['title']; ?>" <?php echo $i++; ?>>

<?php endforeach; endif; else: echo "" ;endif; elseif($r['type'] == 'image'): ?>
                    <!--
 * @Title: image单图上传模块
 * @Descripttion: image单图上传模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-16 23:03:13
 -->
<textarea id="<?php echo $r['field']; ?>Editor" style="display: none;"></textarea>
<input type="hidden" name="<?php echo $r['field']; ?>" id="<?php echo $r['field']; ?>Val" value="<?php echo $form->data[$r['field']]; ?>">
<div class="layui-upload">
    <button type="button" class="layui-btn layui-btn-primary" onClick="<?php echo $r['field']; ?>_upImage()">
        <i class="icon icon-upload3"></i>
        点击上传
    </button>
    <div class="layui-upload-list">
        <img class="layui-upload-img" id="<?php echo $r['class']; ?>Img"
            src="<?php echo !empty($form->data[$r['field']])?imgUrl($form->data[$r['field']]) : '/public/static/admin'.'/images/tong.png'; ?>">
        <p id="thumbText"></p>
    </div>
</div>
<?php if($r['setup']['info']): ?>
<div><?php echo $r['setup']['info']; ?></div>
<?php endif; ?>
<script>
    // layui.use('upload', function () {
    //     var upload = layui.upload;
    //     upload.render({
    //         elem: "#<?php echo $r['class']; ?>",
    //         url: "<?php echo url('upfiles/upload'); ?>",
    //         title: '上传图片',
    //         ext: "<?php echo $r['setup']['upload_allowext']; ?>",
    //         done: function (res) {
    //             $("#<?php echo $r['field']; ?>Img").attr('src', '/public/' + res.url);
    //             $("#<?php echo $r['field']; ?>Val").val(res.url);
    //         }
    //     });
    // });
    var o_ueditorupload<?php echo $r["field"]; ?> = UE.getEditor('<?php echo $r["field"]; ?>Editor', {
        autoHeightEnabled: false,
        isShow: false,
        focus: false,
        enableAutoSave: false,
        autoSyncData: false,
        autoFloatEnabled: false,
        wordCount: false,
        sourceEditor: null,
        scaleEnabled: true,
        toolbars: [
            ['insertimage', 'attachment']
        ]
    });
    o_ueditorupload<?php echo $r["field"]; ?>.ready(function () {
        o_ueditorupload<?php echo $r["field"]; ?>.hide();
        o_ueditorupload<?php echo $r["field"]; ?>.addListener('beforeInsertImage', function (t, arg) {
            console.log(arg[0].src)
            $('#<?php echo $r["class"]; ?>Img').attr('src', arg[0].src);
            $('#<?php echo $r["field"]; ?>Val').val(arg[0].src.substring(7, arg[0].src.lenght));
        });
    });
    function <?php echo $r['field']; ?>_upImage() {
        var myImage = o_ueditorupload<?php echo $r["field"]; ?>.getDialog('insertimage');
        myImage.open();
    }
</script>
                    <?php elseif($r['type'] == 'images'): ?>
                    <!--
 * @Title: images多图上传模块
 * @Descripttion: images多图上传模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-24 21:09:33
 -->
<?php
$value = $form->data[$r['field']];
$data='';
if($value){
    $options = explode(";",mb_substr($value,0,-1));
    if(is_array($options)){
        foreach($options as  $ri) {
            $data .='<div class="layui-col-md3"><div class="dtbox"><img src="'.$ri.'" style="width: 100%;" class="layui-upload-img"><input type="hidden" class="imgVal" value="'.$ri.'"><i class="delimg layui-icon">&#x1006;</i></div></div>';
        }
    }
}
?>
<textarea id="<?php echo $r['field']; ?>Editor" style="display: none;"></textarea>
<div id="images" class="images">

</div>
<div id="upImg" class="upImg" data-i="<?php echo $i; ?>">

</div>
<div class="layui-upload">
    <button type="button" class="layui-btn" id="btn_<?php echo $r['field']; ?>" onClick="<?php echo $r['field']; ?>_upImage()">
        多图片上传
    </button>
    <input type="hidden" name="<?php echo $r['field']; ?>" value="<?php echo $form->data[$r['field']]; ?>">
    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
        预览图：<div class="layui-upload-list" id="demo_<?php echo $r['field']; ?>">
        <div class="layui-row layui-col-space10">
          <?php echo $data; ?>
        </div>
    </div>
    </blockquote>
</div>
<script>
    // layui.use('upload', function () {
    //     var upload = layui.upload;
    //     var imagesSrc_<?php echo $r['field']; ?> = '';
    //     upload.render({
    //         elem: '#btn_<?php echo $r["field"]; ?>'
    //         ,url: "<?php echo url('upfiles/upImages'); ?>"
    //         ,multiple: true
    //         ,done: function(res){
    //         $('#demo_<?php echo $r["field"]; ?> .layui-row').append('<div class="layui-col-md3"><div class="dtbox"><img src="/public/'+ res.src +'" class="layui-upload-img"><input type="hidden" class="imgVal" value="'+ res.src +'"> <i class="delimg layui-icon">&#x1006;</i></div></div>');
    //         imagesSrc_<?php echo $r['field']; ?> +=res.src+';';
    //         $('input[name="<?php echo $r['field']; ?>"]').val(imagesSrc_<?php echo $r['field']; ?>);
    //     }
    // });
    //     $('#demo_<?php echo $r["field"]; ?> .layui-row').on('click','.delimg',function(){
    //         var thisimg = $(this);
    //         var images='';
    //         layer.confirm('你确定要删除该图片吗？', function(index){
    //             thisimg.parents('.layui-col-md3').remove();
    //             layer.close(index);

    //             $('#demo_<?php echo $r["field"]; ?> .imgVal').each(function(i) {
    //                 images+=$(this).val()+';';
    //             });
    //             $('input[name="<?php echo $r['field']; ?>"]').val(images);
    //         })
    //     })
    // });
    var imagesSrc_<?php echo $r['field']; ?> = '';
    var o_ueditorupload<?php echo $r["field"]; ?> = UE.getEditor('<?php echo $r["field"]; ?>Editor', {
        autoHeightEnabled: false,
        isShow: false,
        focus: false,
        enableAutoSave: false,
        autoSyncData: false,
        autoFloatEnabled: false,
        wordCount: false,
        sourceEditor: null,
        scaleEnabled: true,
        toolbars: [
            ['insertimage', 'attachment']
        ]
    });
    o_ueditorupload<?php echo $r["field"]; ?>.ready(function () {
        o_ueditorupload<?php echo $r["field"]; ?>.hide();
        o_ueditorupload<?php echo $r["field"]; ?>.addListener('beforeInsertImage', function (t, arg) {
            // console.log(arg)
            arg.forEach(item => {
                console.log(item.src)
                $('#demo_<?php echo $r["field"]; ?> .layui-row').append('<div class="layui-col-md3"><div class="dtbox"><img src="'+ item.src +'" class="layui-upload-img"><input type="hidden" class="imgVal" value="'+ item.src +'"> <i class="delimg layui-icon">&#x1006;</i></div></div>');
                imagesSrc_<?php echo $r['field']; ?> +=item.src+';';
                $('input[name="<?php echo $r["field"]; ?>"]').val(imagesSrc_<?php echo $r['field']; ?>);
            });
            // $('#<?php echo $r["class"]; ?>Img').attr('src', arg[0].src);
            // $('#<?php echo $r["field"]; ?>Val').val(arg[0].src.substring(7, arg[0].src.lenght));
        });
    });
    function <?php echo $r['field']; ?>_upImage() {
        var myImage = o_ueditorupload<?php echo $r["field"]; ?>.getDialog('insertimage');
        myImage.open();
    }
    $('#demo_<?php echo $r["field"]; ?> .layui-row').on('click','.delimg',function(){
            var thisimg = $(this);
            var images='';
            layer.confirm('你确定要删除该图片吗？', function(index){
                thisimg.parents('.layui-col-md3').remove();
                layer.close(index);

                $('#demo_<?php echo $r["field"]; ?> .imgVal').each(function(i) {
                    images+=$(this).val()+';';
                });
                $('input[name="<?php echo $r['field']; ?>"]').val(images);
            })
        })
</script>

                    <?php elseif($r['type'] == 'video'): ?>
                    <!--
 * @Title: video视频七牛云上传模块
 * @Descripttion: video视频七牛云上传模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<div class="layui-input-block" style="margin-left: 0;">
    <input type="hidden" name="<?php echo $r['field']; ?>" id="<?php echo $r['field']; ?>fval" value="<?php echo $form->data[$r['field']]; ?>">
    <div class="layui-upload">
    <botton type="file" class="layui-btn layui-btn-primary" id="<?php echo $r['class']; ?>but" value="点击上传">
        <span id="<?php echo $r['field']; ?>jindu"></span>点击上传
    </botton>
    <div class="layui-upload-list" id="<?php echo $r['field']; ?>text" style="height: 150px;background-repeat: no-repeat;background-size: auto 100%;background-image: url(<?php echo !empty($form->data[$r['field']])?$form->data[$r['field']].'?vframe/jpg/offset/1' : ''; ?>)">
    </div>
    </div>
</div>

<!--<div class="layui-input-block">-->
    <!--<input type="hidden" name="<?php echo $r['field']; ?>" id="<?php echo $r['field']; ?>Val" value="<?php echo $form->data[$r['field']]; ?>">-->
    <!--<div class="layui-upload">-->
        <!--<button type="button" class="layui-btn layui-btn-primary" id="<?php echo $r['class']; ?>">-->
            <!--<i class="icon icon-upload3"></i>-->
            <!--点击上传-->
        <!--</button>-->
        <!--<div class="layui-upload-list">-->
            <!--<img class="layui-upload-img" id="<?php echo $r['class']; ?>Img" src="<?php echo !empty($form->data[$r['field']])?'/public/'.$form->data[$r['field']] : '/public/static/admin'.'/images/tong.png'; ?>">-->
            <!--<p id="thumbText"></p>-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->
<script src="//cdn.bootcss.com/plupload/2.1.8/moxie.min.js"></script>
<script src="//cdn.bootcss.com/plupload/2.1.8/plupload.full.min.js"></script>
<script src="https://unpkg.com/qiniu-js@1.0.24/dist/qiniu.min.js"></script>
<script>
    $(function(){
        //生成随机字符
        function randomWord(randomFlag, min, max){
            var str = "",
            range = min,
                arr = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

            // 随机产生
            if(randomFlag){
                range = Math.round(Math.random() * (max-min)) + min;
            }
            for(var i=0; i<range; i++){
                pos = Math.round(Math.random() * (arr.length-1));
                str += arr[pos];
            }
            return str;
        }
        layui.use(['upload','element'], function () {
            var upload = layui.upload,element = layui.element;
            var domain = 'xingyong.zhuimeizc.com'; //bucket绑定的域名
            var uploader = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                browse_button: "<?php echo $r['class']; ?>but",         // 上传选择的点选按钮，**必需**
                // 在初始化时，uptoken, uptoken_url, uptoken_func 三个参数中必须有一个被设置
                // 切如果提供了多个，其优先级为 uptoken > uptoken_url > uptoken_func
                // 其中 uptoken 是直接提供上传凭证，uptoken_url 是提供了获取上传凭证的地址，如果需要定制获取 uptoken 的过程则可以设置 uptoken_func
                //         uptoken : '', // uptoken 是上传凭证，由其他程序生成
                uptoken_url: '/uptoken.php',         // Ajax 请求 uptoken 的 Url，**强烈建议设置**（服务端提供）
                // uptoken_func: function(file){    // 在需要获取 uptoken 时，该方法会被调用
                //    // do something
                //    return uptoken;
                // },
                get_new_uptoken: true,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                // downtoken_url: '/downtoken',
                // Ajax请求downToken的Url，私有空间时使用,JS-SDK 将向该地址POST文件的key和domain,服务端返回的JSON必须包含`url`字段，`url`值为该文件的下载地址
                // unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
                // save_key: true,                  // 默认 false。若在服务端生成 uptoken 的上传策略中指定了 `sava_key`，则开启，SDK在前端将不对key进行任何处理
                domain: domain,     // bucket 域名，下载资源时用到，**必需**
                // container: 'ccontainer',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                max_file_size: '2048mb',             // 最大文件体积限制
                flash_swf_url: 'http://cdn.bootcss.com/plupload/2.1.9/Moxie.swf',  //引入 flash,相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: false,                     // 开启可拖曳上传
                // drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                // x_vars : {
                //    自定义变量，参考http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html
                //    'time' : function(up,file) {
                //        var time = (new Date()).getTime();
                //           do something with 'time'
                //        return time;
                //    },
                //    'size' : function(up,file) {
                //        var size = file.size;
                //           do something with 'size'
                //        return size;
                //    }
                // },
                init: {
                    'FilesAdded': function(up, files) {
                        plupload.each(files, function(file) {
                            // 文件添加进队列后,处理相关的事情
                            console.log(JSON.stringify(file));
                        });
                    },
                    'BeforeUpload': function(up, file) {
                        // 每个文件上传前,处理相关的事情
//                    layer.load(2, {
//                        shade: [0.5, '#000']
//                    });
//                    element.render()
//                    $('.layui-progress').show();
                    },
                    'UploadProgress': function(up, file) {
                        // 每个文件上传时,处理相关的事情

                        var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                        $("#<?php echo $r['field']; ?>jindu").text(file.percent + "%");
                        element.progress('progressBar',file.percent  + '%');
                        // progress.setProgress(file.percent + \"%\", file.speed, chunk_size);
                    },
                    'FileUploaded': function(up, file, info) {
                        // 每个文件上传成功后,处理相关的事情
                        // 其中 info 是文件上传成功后，服务端返回的json，形式如
                        // {
                        //    \"hash\": \"Fh8xVqod2MQ1mocfI4S4KpRL6D98\",
                        //    \"key\": \"gogopher.jpg\"
                        //  }
                        // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                        console.log(info);
                        console.log(JSON.parse(info.response))
                        var domain = up.getOption('domain');
                        var res = JSON.parse(info.response);
                        var sourceLink ='http://' + domain + '/' + res.key; //获取上传成功后的文件的Url
                        console.log(sourceLink);
                        layer.closeAll('loading');
                        $('.layui-progress').hide();
                        layer.msg('文件上传成功', {
                            icon: 1,
                            shade: 0.5,
                            time: 1000
                        })

                        document.getElementById('<?php echo $r['field']; ?>text').style.backgroundImage = "url('" + sourceLink + "?vframe/jpg/offset/1')";
                        $('#<?php echo $r['field']; ?>fval').val(sourceLink);
                    },
                    'Error': function(up, err, errTip) {
                        //上传出错时,处理相关的事情
                    },
                    'UploadComplete': function() {
                        //队列文件处理完毕后,处理相关的事情
                    },
                    'Key': function(up, file) {
                        // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                        // 该配置必须要在 unique_names: false , save_key: false 时才生效
                        var date = new Date();
                        var time = date.getFullYear()+""+date.getMonth()+""+date.getDay();
                        var key = time+randomWord(false,5)+"_"+file.name;
                        // do something with key here
                        return key
                    }
                }
            });
        });
    });
</script>
<!--<script>-->
    <!--layui.use(['qiniuyun', 'layer', 'element', 'jquery'], function () {-->
        <!--var $ = layui.jquery-->
            <!--,element = layui.element-->
            <!--,layer = layui.layer-->
            <!--,qiniuyun = layui.qiniuyun;-->
        <!--qiniuyun.loader({-->
            <!--domain: 'xingyong.zhuimeizc.com'              // 后台设置的域名项-->
            <!--, elem: "#<?php echo $r['class']; ?>but"          // 绑定的element-->
            <!--, token: "jsVWLBDesLtETZa3uanGLgEeN4ubNMNZYxqoLNCL"              // 授权token-->
            <!--, retryCount: 6                  // 重连次数，默认6(可选)-->
            <!--// , region: 'video'        // 选择上传域名区域，默认自动分析(可选)-->
            <!--, next: function(response){-->
                <!--element.progress('video-progress', response.total.percent + '%');       // 进度条-->
            <!--}-->
            <!--, complete: function(res){-->
                <!--// layer.closeAll('loading'); // 关闭loading关闭-->
                <!--layer.msg("上传成功！");-->
                <!--console.log(res)-->
            <!--}-->
        <!--})-->
    <!--})-->
<!--</script>-->

                    <?php elseif($r['type'] == 'p_id'): ?>
                    <!--
 * @Title: catid栏目模块
 * @Descripttion: catid栏目模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<select  id="<?php echo $r['field']; ?>" lay-verify="required" name="<?php echo $r['field']; ?>"   lay-filter="<?php echo $r['field']; ?>" <?php echo getvalidate($r); ?>>
</select>
<script>
    $(function(){
        layui.use('form', function () {
            var form = layui.form;
            var pid = <?php echo input('pid'); ?>;
            $.post("<?php echo url('index/catid'); ?>",{pid:pid},function(res){
                if(res.code == 200){
                    $("#<?php echo $r['field']; ?>").empty();
                    data = res.data;
                    var str = "";
                    $.each(data,function(i,v){
                        if(pid == v.id){
                            str += "<option value='"+v.id+"' selected>"+v.name+"</option>"
                        }
                    })
                    console.log(str)
                    $("#<?php echo $r['field']; ?>").append(str);
                    form.render();
                }
            })
        })
    })
</script>

                    <?php elseif($r['type'] == 'linkage'): ?>
                    <!--
 * @Title: linkage城市联动模块
 * @Descripttion: linkage城市联动模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<?php
    $value = explode(',',$form->data[$r['field']]);
    $region = db('region')->where(['pid'=>1])->select();
    if($value[0]){
    $city = db('region')->where(['pid'=>$value[0]])->select();
    }
    if($value[1]){
    $district = db('region')->where(['pid'=>$value[1]])->select();
    }
?>
<div class="layui-input-inline">
    <select name="<?php echo $r['field']; ?>[]" class="linkage-province" lay-filter="province">
        <option value="">请选择省</option>
        <?php if(is_array($region) || $region instanceof \think\Collection || $region instanceof \think\Paginator): $i = 0; $__LIST__ = $region;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($value[0] == $v['id']): ?>
            <option selected value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
            <?php else: ?>
            <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </select>
</div>
<div class="layui-input-inline">
    <select name="<?php echo $r['field']; ?>[]" id="city" lay-filter="city">
        <option value="">请选择市</option>
        <?php if($city): if(is_array($city) || $city instanceof \think\Collection || $city instanceof \think\Paginator): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($value[1] == $v['id']): ?>
            <option selected value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
            <?php else: ?>
            <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
            <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
    </select>
</div>

<div class="layui-input-inline">
    <select name="<?php echo $r['field']; ?>[]" id="district" lay-filter="district">
        <option value="">请选择县/区</option>
        <?php if($district): if(is_array($district) || $district instanceof \think\Collection || $district instanceof \think\Paginator): $i = 0; $__LIST__ = $district;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($value[2] == $v['id']): ?>
        <option selected value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php else: ?>
        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
    </select>
</div>
<script>
    layui.use(['form','laydate'], function () {
        var form = layui.form, laydate = layui.laydate;

        form.on('select(province)', function (data) {
            var pid = data.value;
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.get("<?php echo url('publics/getRegion'); ?>?pid=" + pid, function (data) {
                layer.close(loading);
                var html = '<option value="">请选择市</option>';
                $.each(data, function (i, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#city').html(html);
                $('#district').html('<option value="">请选择县/区</option>');
                form.render()
            });
        });
        form.on('select(city)', function (data) {
            var pid = data.value;
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.get("<?php echo url('publics/getRegion'); ?>?pid=" + pid, function (data) {
                layer.close(loading);
                var html = '<option value="">请选择县/区</option>';
                $.each(data, function (i, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#district').html(html);

                form.render()
            });
        });
    })
</script>

                    <?php elseif($r['type'] == 'position'): ?>
                    <!--
 * @Title: 地图定位
 * @Author: wzs
 * @Date: 2020-06-08 09:03:29
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-08 14:11:34
 * @Description:
-->
<?php
    $positionArr = explode(',',$form->data[$r['field']]);
if($r['setup']['map'] == 1): ?>
<script
  charset="utf-8"
  src="https://map.qq.com/api/js?v=2.exp&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77"
></script>
<style>
  /* .csssprite {
    display: none;
  }
  .smnoprint {
    display: none;
  } */
</style>
<script>
  var geocoder,
    map,
    marker = null;
  var init = function () {
    var center = new qq.maps.LatLng(45.77689, 126.62011);
    map = new qq.maps.Map(document.getElementById("<?php echo $r['field']; ?>_container"), {
      center: center,
      zoomControl: false,
      panControl: false,
      zoom: 20,
    });
    var marker = new qq.maps.Marker({
      map: map,
      position: center,
    });
    var info = new qq.maps.InfoWindow({
      map: map,
    });
    var getpos = function () {
      marker.setDraggable(true);

      //获取标记的可拖动属性
      info.open();
      info.setContent("拖动定位,点击选择");
      info.setPosition(marker.getPosition());
      //地址和经纬度之间进行转换服务
      qq.maps.event.addListener(marker, "dragend", function () {
        info.open();
        info.setPosition(marker.getPosition());
      });

      qq.maps.event.addListener(marker, "click", function () {
        console.log(marker.getPosition());
        var result = marker.getPosition();
        layer.close(layer.index);
        $("#<?php echo $r['field']; ?>_lng").val(result.lng);
        $("#<?php echo $r['field']; ?>_lat").val(result.lat);
        $("#<?php echo $r['field']; ?>").val(result.lng + ',' + result.lat)
        // console.log(result.detail.location);
        // alert("坐标地址为： " + String(result.detail.location).split(",")[0]);
      });
    };
    geocoder = new qq.maps.Geocoder();
    //设置服务请求成功的回调函数
    geocoder.setComplete(function (result) {
      map.setCenter(result.detail.location);
      marker.setPosition(result.detail.location)
      getpos();
    });
    //若服务请求失败，则运行以下函数
    geocoder.setError(function () {
      alert("出错了，请输入正确的地址！！！");
    });
  };

  function codeAddress() {
    var address = document.getElementById("<?php echo $r['field']; ?>_search").value;
    address = address?address:'黑龙江哈尔滨'
    //对指定地址进行解析
    init()
    geocoder.getLocation(address);
  }
</script>
<script>
  $(function () {
    layui.use("layer", function () {
      var layer = layui.layer;
    });
    $("#<?php echo $r['field']; ?>_get").click(function () {
      layer.open({
        skin: "<?php echo $r['field']; ?>-tan",
        type: 1,
        area: "500px",
        title: "选择地点",
        scrollbar: false,
        content: $("#<?php echo $r['field']; ?>_location"),
        success: function () {
          codeAddress();
        },
      });
    });
  });
</script>
<div class="layui-form-label" style="width: 2em;">
  经度
</div>
<div class="layui-input-inline">
  <input type="text" class="layui-input" name="<?php echo $r['field']; ?>_lng" id="<?php echo $r['field']; ?>_lng" value="<?php echo $positionArr['0']; ?>"/>
</div>
<div class="layui-form-label" style="width: 2em;">
  纬度
</div>
<div class="layui-input-inline">
  <input type="text" class="layui-input" name="<?php echo $r['field']; ?>_lat" id="<?php echo $r['field']; ?>_lat" value="<?php echo $positionArr['1']; ?>"/>
</div>
<input type="hidden" id="<?php echo $r['field']; ?>" name="<?php echo $r['field']; ?>" value='<?php echo $form->data[$r["field"]]; ?>'>
<div class="layui-btn" id="<?php echo $r['field']; ?>_get">点击获取</div>
<div
  id="<?php echo $r['field']; ?>_location"
  class=""
  style="width: 500px; height: 393px; display: none;"
>
  <div style="padding: 20px;">
    <div class="layui-input-inline" style="width: 386px;">
      <input
        id="<?php echo $r['field']; ?>_search"
        class="layui-input"
        type="text"
        value=""
      />
    </div>
    <div class="layui-btn" onclick="codeAddress()">搜索</div>
    <div style="height: 310px; overflow: hidden;">
      <div
        style="width: 100%; height: 320px; margin-top: 15px;"
        id="<?php echo $r['field']; ?>_container"
      ></div>
    </div>
  </div>
</div>

<?php else: ?>
<script
  type="text/javascript"
  src="http://api.map.baidu.com/api?key=&v=1.1&services=true"
></script>
<div id="<?php echo $r['field']; ?>_location" style="width: 500px; height: 500px; display: none;"></div>
<div class="layui-form-label" style="width: 2em;">
  经度
</div>
<div class="layui-input-inline">
  <input type="text" name="<?php echo $r['field']; ?>_lng" class="layui-input" id="<?php echo $r['field']; ?>_lng" value="<?php echo $positionArr['0']; ?>"/>
</div>
<div class="layui-form-label" style="width: 2em;">
  纬度
</div>
<div class="layui-input-inline">
  <input type="text"  name="<?php echo $r['field']; ?>_lat" class="layui-input" id="<?php echo $r['field']; ?>_lat" value="<?php echo $positionArr['1']; ?>"/>
</div>
<input type="hidden" id="<?php echo $r['field']; ?>" name="<?php echo $r['field']; ?>" value='<?php echo $form->data[$r["field"]]; ?>'>
<div class="layui-btn" id="dian">点击获取</div>

<script>
  $(function () {
    layui.use("layer", function () {
      var layer = layui.layer;

        var lat = $("#<?php echo $r['field']; ?>_lat").val();
        var lng = $("#<?php echo $r['field']; ?>_lng").val();
        if(!lat || !lng){
            var lng = 126.572054;

            var lat = 45.784085;
        }

    $("#dian").click(function () {


        console.log(lat);
        console.log(lng);
        layer.open({
        type: 1,
        area: "500px",
        title: "选择定位",
        content: $("#<?php echo $r['field']; ?>_location"),
        success: function () {
          var map = new BMap.Map("<?php echo $r['field']; ?>_location"); // 创建地图实例
          map.enableScrollWheelZoom(); //启用滚轮放大缩小，默认禁用
          var point = new BMap.Point(lng,lat); // 创建点坐标
          map.centerAndZoom(point, 12);
          function myFun(result) {
            var cityName = result.name;
            map.setCenter(cityName);
            // alert("当前定位城市:"+cityName);
          }
          var myCity = new BMap.LocalCity();
          myCity.get(myFun);
          var marker = new BMap.Marker(map.getCenter()); // 创建标注
          map.addOverlay(marker); // 将标注添加到地图中
          marker.enableDragging(); //可拖拽
          //marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
          map.addEventListener("click", function (e) {
            // alert(e.point.lng+","+e.point.lat);// 单击地图获取坐标点；
            // $("#<?php echo $r['field']; ?>_lng").val(e.point.lng);
            // $("#<?php echo $r['field']; ?>_lat").val(e.point.lat);
            // $("#<?php echo $r['field']; ?>").val(e.point.lng + ',' + e.point.lat);
            map.panTo(new BMap.Point(e.point.lng, e.point.lat)); // map.panTo方法，把点击的点设置为地图中心点
          });
          marker.addEventListener("dragend", function (e) {
            //拖拽标注获取标注坐标
            // alert("当前位置：" + e.point.lng + ", " + e.point.lat);           //可拖拽的标注
            $("#<?php echo $r['field']; ?>_lng").val(e.point.lng);
            $("#<?php echo $r['field']; ?>_lat").val(e.point.lat);
            $("#<?php echo $r['field']; ?>").val(e.point.lng + ',' + e.point.lat);
            layer.confirm('你确定选择，经度：'+e.point.lng+'维度：'+e.point.lat,function(){
                layer.closeAll();
            });
              // $("#<?php echo $r['field']; ?>_location").hide();
          });
          //加载完成之后,改变标注点坐标,使之和当前定位的城市基本相符
          map.addEventListener("tilesloaded", function () {
            var newpoint = map.getCenter();
            marker.setPosition(newpoint);
          });
        },
        cancel: function () {},
      });
    });

    });
  });
</script>
<?php endif; elseif($r['type'] == 'catid'): ?>
                    <!--
 * @Title: catid栏目模块
 * @Descripttion: catid栏目模块
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-12 22:28:22
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-18 14:49:53
 -->
<select  id="<?php echo $r['field']; ?>" lay-verify="required" name="<?php echo $r['field']; ?>"   lay-filter="<?php echo $r['field']; ?>" <?php echo getvalidate($r); ?>>
</select>
<script>
    $(function(){
        layui.use('form', function () {
            var form = layui.form;
            var pid = <?php echo input('pid'); ?>;
            $.post("<?php echo url('index/catid'); ?>",{pid:pid},function(res){
                if(res.code == 200){
                    $("#<?php echo $r['field']; ?>").empty();
                    data = res.data;
                    var str = "";
                    $.each(data,function(i,v){
                        if(pid == v.id){
                            str += "<option value='"+v.id+"' selected>"+v.name+"</option>"
                        }
                    })
                    console.log(str)
                    $("#<?php echo $r['field']; ?>").append(str);
                    form.render();
                }
            })
        })
    })
</script>

                    <?php else: ?>
                    <?php echo getform($form,$r,input($r['field'])); endif; ?>
                    </div>
                </div>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                <?php if(MODULE_NAME == 'page'): ?>
                <!-- <a href="<?php echo url('category/index'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a> -->
                <?php else: if(input('type') != 'page'): ?>
                <a href="<?php echo url('index',['catid'=>input('catid')]); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
                <?php endif; endif; ?>
            </div>
        </div>
    </form>
</div>
<script>
    var url= "<?php echo $action=='add'?url('add'): url('edit'); ?>";
    layui.use(['form','upload', 'admin'], function () {
        var form = layui.form,admin = layui.admin();
        admin.init();
        form.on('submit(submit)', function (data) {
            $.post(url, data.field, function (res) {
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        admin.formReload();;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
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
 * @LastEditTime: 2020-07-29 17:27:06
-->     
<script>
  layui.config({
      base: '/public/static/admin/js/module/',
      version: Date.parse(new Date()),
      debug: true
    }).extend({
      sliderVerify: 'sliderVerify'
    }).use(['jquery','admin'], function () {
      var admin = layui.admin();
      admin.initPage()
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
