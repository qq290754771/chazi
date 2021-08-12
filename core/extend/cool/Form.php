<?php
namespace cool;
use cool\Leftnav;
class Form{
    public $data = array();

    public function __construct($data=array()) {
        $this->data = $data;
    }
    public function catid($info,$value){
        $validate = getvalidate($info);
        $list = db('category')->select();;
        foreach ($list as $lk=>$v){
            $category[$v['id']] = $v;
        }
        $id = $field = $info['field'];
        $value = $value ? $value : $this->data[$field];
        $moduleid =$info['moduleid'];

        foreach ($category as $r){
            if($r['type']==1){
                continue;
            }
            $arr= explode(",",$r['arrchildid']);
            $show=0;
            foreach((array)$arr as $rr){
                if($category[$rr]['moduleid']==$moduleid){
                    $show=1;
                }
            }
            if(empty($show)){
                continue;
            }
            if($r['child']){
                $r['disabled'] = ' disabled';
            }else{
                $r['disabled'] = ' ';
            }
            $array[] = $r;
        }
        // $str  = "<option value='\$id' \$disabled \$selected>\$spacer \$catname</option>";
        // <dd><input type="checkbox" name="catid" title="\$spacer \$catname" value="\$id" lay-skin="primary" ></dd>
        $tree = new Tree ($array);

        if($info['setup']['multi'] == '1'){
          $str  = "<dd><input type='checkbox' name='catid[]' \$checked title='\$spacer \$catname' value='\$id' data-title='\$catname' lay-skin='primary' ></dd>";
          $parseStr = '
              <div class="layui-unselect layui-form-select downpanel cs">
                  <div class="layui-select-title">
                      <input type="text" placeholder="请选择所属栏目" value=""  readonly="" class="layui-input layui-unselect catidtitle"><i class="layui-edge"></i>
                  </div>
                  <dl class="layui-anim layui-anim-upbit" style="">';
          $parseStr .= $tree->get_tree(0, $str, $value);
          $parseStr .= '<div style="padding:10px 0 10px 10px;"><a href="#" class="layui-btn layui-btn-sm catidqr">确认</a></div>';
          $parseStr .= '</dl>';
          $parseStr .= '</div>';
        }else{
          $str  = "<option value='\$id' \$disabled \$selected>\$spacer \$catname</option>";
          $parseStr = '<select  id="'.$id.'" lay-verify="required" name="'.$field.'"  '.$validate.'>';
          $parseStr .= '<option value="">请选择'.$info['name'].'</option>';
          $parseStr .= $tree->get_tree(0, $str, $value);
          $parseStr .= '</select>';
        }
        return $parseStr;
    }

    public function text($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $field = $info['field'];
        $name = $info['name'];
        // dump($info['setup']);
        $info['setup']['ispassword'] ? $inputtext = 'password' : $inputtext = 'text';
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $pattern='';
        if($info['pattern']!='defaul'){
            $pattern='|'.$info['pattern'];
        }

        if($info['required']==1){
            $parseStr   = '<input autocomplete="off" type="'.$inputtext.'" data-required="'.$info['required'].'" min="'.$info['minlength'].'" max="'.$info['maxlength'].'" errormsg="'.$info['errormsg'].'" title="'.$name.'" placeholder="请输入'.$name.'(必填)" lay-verify="defaul'.$pattern.'" class="'.$info['class'].' layui-input" name="'.$field.'" value="'.$value.'" /> ';
            if($info['setup']['info']){
              $parseStr .= $info['setup']['info'];
            }
        }else{
          $parseStr   = '<input autocomplete="off" type="'.$inputtext.'" data-required="'.$info['required'].'" min="'.$info['minlength'].'" max="'.$info['maxlength'].'" errormsg="'.$info['errormsg'].'" title="'.$name.'" placeholder="请输入'.$name.'" lay-verify="defaul'.$pattern.'" class="'.$info['class'].' layui-input" name="'.$field.'" value="'.$value.'" /> ';
          if($info['setup']['info']){
            $parseStr .= $info['setup']['info'];
          }
        }
        return $parseStr;
    }

    public function textarea($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $field = $info['field'];
        $name = $info['name'];
        if($info['pattern']!='defaul'){
            $pattern='|'.$info['pattern'];
        }
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }

        if($info['required']==1){
            $parseStr   = '<textarea data-required="'.$info['required'].'" min="'.$info['minlength'].'" max="'.$info['maxlength'].'" errormsg="'.$info['errormsg'].'" title="'.$name.'" placeholder="请输入'.$name.'(必填)" lay-verify="defaul'.$pattern.'"  class="'.$info['class'].' layui-textarea" name="'.$field.'" />'.$value.'</textarea>';
        }else{
            $parseStr   = '<textarea data-required="'.$info['required'].'" min="'.$info['minlength'].'" max="'.$info['maxlength'].'" errormsg="'.$info['errormsg'].'" title="'.$name.'" placeholder="请输入'.$name.'" lay-verify="defaul'.$pattern.'"  class="'.$info['class'].' layui-textarea" name="'.$field.'" />'.$value.'</textarea>';
        }
        return $parseStr;
    }

    public function editor($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $field = $info['field'];
        $name = $info['name'];
        $pattern = ($info['pattern']!='defaul')?'|'.$info['pattern']:'';
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        if($info['setup']['edittype']=='UEditor'){
            //配置文件
            $str ='';
            $str .='<input type="hidden" id="editType" value="1">';
            $str .='<textarea name="'.$field.'" class="'.$info['class'].'" id="'.$info['class'].'">'.$value.'</textarea>';
            $str .='<script>var editor = new UE.ui.Editor();editor.render("'.$info['class'].'");</script>';
        }else{
            $str ='';
            $str .='<input type="hidden" id="editType" value="0">';
            if($value){
                $str .='<textarea name="'.$field.'" min="'.$info['minlength'].'" max="'.$info['maxlength'].'" errormsg="'.$info['errormsg'].'" title="'.$name.'" placeholder="请输入'.$name.'" lay-verify="defaul'.$pattern.'" class="'.$info['class'].'" id="'.$info['class'].'" >'.$value.'</textarea>';
            }else{
                $str .='<textarea name="'.$field.'" min="'.$info['minlength'].'" max="'.$info['maxlength'].'" errormsg="'.$info['errormsg'].'" title="'.$name.'" placeholder="请输入'.$name.'" lay-verify="defaul'.$pattern.'" class="'.$info['class'].'" id="'.$info['class'].'" >请输入……</textarea>';
            }
            $str .='<script>layui.use("layedit", function () {var layedit = layui.layedit;layedit.set({uploadImage: {url: \''.url("UpFiles/editUpload").'\',type: \'post\'}});edittext[\''.$info['class'].'\'] = layedit.build("'.$info['class'].'");})</script>';
        }
        return $str;
    }

    public function number($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(isset($info['setup']['ispassowrd'])){
            $inputtext = 'passowrd';
        }else{
            $inputtext = 'text';
        }
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        if(isset($info['setup']['size'])){
            $size = $info['setup']['size'];
        }else{
            $size = "";
        }
        $parseStr   = '<input type="'.$inputtext.'"   class="input-text '.$info['class'].' layui-input" name="'.$field.'"  id="'.$id.'" value="'.$value.'" size="'.$size.'"  '.$validate.'/> ';
        return $parseStr;
    }

    public function select($info,$value){

        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $id = $field = $info['field'];
        $validate = getvalidate($info);
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        if($value != '') $value = strpos($value, ',') ? explode(',', $value) : $value;
        if(is_array($info['options'])){
            $optionsarr = $info['options'];
        }else{
            $options    = $info['setup']['options'];
            $options = explode("\n",$info['setup']['options']);
            foreach($options as $r) {
                $v = explode("|",$r);
                $k = trim($v[1]);
                $optionsarr[$k] = $v[0];
            }
        }
        if(!empty($info['setup']['multiple'])) {
            $onchange = '';
            if(isset($info['setup']['onchange'])){
                $onchange = $info['setup']['onchange'];
            }
            $parseStr = '<select id="'.$id.'" name="'.$field.'"  onchange="'.$onchange.'" class="'.$info['class'].'"  '.$validate.' size="'.$info['setup']['size'].'" multiple="multiple" >';
        }else {
            $onchange = '';
            if(isset($info['setup']['onchange'])){
                $onchange = $info['setup']['onchange'];
            }
            $parseStr = '<select id="'.$id.'" name="'.$field.'" onchange="'.$onchange .'"  class="'.$info['class'].'" '.$validate.'>';
        }

        if(is_array($optionsarr)) {
            foreach($optionsarr as $key=>$val) {
                if(!empty($value)){
                    $selected='';
                    if(is_array($value)){
                        if(in_array($key,$value)){
                            $selected = ' selected="selected"';
                        }
                    }else{
                        if($value==$key){
                            $selected = ' selected="selected"';
                        }
                    }
                    $parseStr   .= '<option '.$selected.' value="'.$key.'">'.$val.'</option>';
                }else{
                    $parseStr   .= '<option value="'.$key.'">'.$val.'</option>';
                }
            }
        }
        $parseStr   .= '</select>';
        return $parseStr;
    }

    public function checkbox($info,$value){

        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $id = $field = $info['field'];
        $validate = getvalidate($info);
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $labelwidth = $info['setup']['labelwidth'];


        if(is_array($info['options'])){
            $optionsarr = $info['options'];
        }else{
            $options    = $info['setup']['options'];
            $options = explode("\n",$info['setup']['options']);
            foreach($options as $r) {
                $v = explode("|",$r);
                $k = trim($v[1]);
                $optionsarr[$k] = $v[0];
            }
        }
        if($value != '') $value = strpos($value, ',') ? explode(',', $value) : array($value);
        $i = 1;
        $parseStr ='';
        foreach($optionsarr as $key=>$r) {
            $key = trim($key);
            if($i>1){
                $validate='';
            }
            $checked = ($value && in_array($key, $value)) ? 'checked' : '';
            $parseStr .= '<input name="'.$field.'['.$i.']" id="'.$id.'_'.$i.'" '.$checked.' value="'.htmlspecialchars($key).'"  '.$validate.' type="checkbox" class="ace" title="'.htmlspecialchars($r).'">';
            $i++;
        }
        return $parseStr;

    }

    public function radio($info,$value){
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $id = $field = $info['field'];
        $validate = getvalidate($info);

        $action = ACTION_NAME;
        if ($action == 'add') {
            $value = $value ? $value : $info['setup']['default'];
        } else {
            $value = $value ? $value : $this->data[$field];
        }
        $labelwidth = $info['setup']['labelwidth'];
        $parseStr='';
        if (isset($info['options'])) {
            if (is_array($info['options'])) {
                $optionsarr = $info['options'];
            }
        } else if (isset($info['setup']['options'])) {
            $options = $info['setup']['options'];
            $options = explode("\n", $info['setup']['options']);
            foreach ($options as $r) {
                $v = explode("|", $r);
                $k = trim($v[1]);
                $optionsarr[$k] = $v[0];
            }
        }else {
            return $parseStr;
        }
        $i = 1;
        foreach($optionsarr as $key=>$r) {
            if($i>1){
                $validate ='';
            }
            $checked = trim($value)==trim($key) ? 'checked' : '';
            if(empty($value) && empty($key) ){
                $checked = 'checked';
            }
            $parseStr .= '<input name="'.$field.'" id="'.$id.'_'.$i.'" '.$checked.' value="'.$key.'" '.$validate.' type="radio" class="ace" title="'.$r.'" />';
            $i++;
        }
        return $parseStr;
    }

    public function groupid($info,$value){
        $newinfo = $info;
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $list = db('role')->select();;
        foreach ($list as $lk=>$v){
            $groups[$v['id']] = $v;
        }
        $options=array();
        foreach($groups as $key=>$r) {
            if($r['status']){
                $options[$key]=$r['name'];
            }
        }
        $newinfo['options']=$options;
        $fun=$info['setup']['inputtype'];
        return $this->$fun($newinfo,$value);
    }

    public function posid($info,$value){
        $newinfo = $info;
        $list = db('posid')->select();
        foreach ($list as $lk=>$v){
            $posids[$v['id']] = $v;
        }

        $options=array();
        $options[0]= "请选择";
        foreach($posids as $key=>$r) {
            $options[$key]=$r['name'];
        }
        $newinfo['options']=$options;
        if(isset($info['setup']['inputtype'])){
            $fun=$info['setup']['inputtype'];
        }
        return $this->select($newinfo,$value);
    }

    public function typeid($info,$value){
        $newinfo = $info;
        $list = db('type')->select();
        foreach ($list as $lk=>$v){
            $types[$v['id']] = $v;
        }

        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);

        $parentid=$info['setup']['default'];

        $options=array();
        $options[0]= '请选择';
        foreach($types as $key=>$r) {
            if($r['parentid']!=$parentid || empty($r['status'])) continue;
            $options[$key]=$r['name'];
        }
        $newinfo['options']=$options;
        $fun=$info['setup']['inputtype'];
        return $this->$fun($newinfo,$value);
    }

    public function template($info,$value){
        $templates= template_file(MODULE_NAME);
        $newinfo = $info;
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $options=array();
        $options[0]= "请选择";
        if($templates){
            foreach($templates as $key=>$r) {
                if(strstr($r['value'],'_show')){
                    $options[$r['value']]=$r['filename'];
                }
            }
        }
        $newinfo['options']=$options;
        //$fun=$info['setup']['inputtype'];
        return $this->select($newinfo,$value);
    }

    public function image($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $field = $info['field'];
        $action = ACTION_NAME;
        if($action=='add'){
            $value =$value?__PUBLIC__.$value:__ADMIN__."/images/tong.png";
        }else{
            if($this->data[$field]){
                $value = $value ?$value :  __PUBLIC__.$this->data[$field];
            }else{
                $value = __ADMIN__."/images/tong.png";
            }

        }


        $thumbstr ='<div class="layui-input-block"><input type="hidden" name="'.$field.'" id="'.$field.'Val" value="'.$this->data[$field].'"><div class="layui-upload">';
        $thumbstr .='<button type="button" class="layui-btn layui-btn-primary" id="'.$info['class'].'"><i class="icon icon-upload3"></i>点击上传</button>';
        $thumbstr .='<div class="layui-upload-list"><img class="layui-upload-img" id="'.$info['class'].'Img" src="'.$value.'"><p id="thumbText"></p>';
        $thumbstr .='</div></div></div>';
        if($info['setup']['info']){
          $thumbstr .= $info['setup']['info'];
        }
        $thumbstr.="<script>
                        layui.use('upload', function () {
                            var upload = layui.upload;
                            upload.render({
                                elem:'#".$info['class']."',
                                url: '".url('upFiles/upload')."',
                                title: '上传图片',
                                ext: '".$info['setup']['upload_allowext']."',
                                done: function(res){
                                    $('#".$field."Img').attr('src', '__PUBLIC__'+res.url);
                                    $('#".$field."Val').val(res.url);
                                }
                            });
                        });
                    </script>";

        return $thumbstr;
    }

    public function images($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $field = $info['field'];
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $data='';
        $i=0;
        if($value){
            $options = explode(";",mb_substr($value,0,-1));
            if(is_array($options)){
                foreach($options as  $r) {
                    $data .='<div class="layui-col-md3"><div class="dtbox"><img src="__PUBLIC__'.$r.'" class="layui-upload-img"><input type="hidden" class="imgVal" value="'.$r.'"><i class="delimg layui-icon">&#x1006;</i></div></div>';
                }
            }
        }
        $parseStr   = '<div id="images" class="images"></div><div id="upImg" class="upImg" data-i="'.$i.'">'.$data.'</div>';
        $parseStr   = '<div class="layui-upload">';
        $parseStr   .= '<button type="button" class="layui-btn" id="btn_'.$field.'">多图片上传</button><input type="hidden" name="'.$field.'" value="'.$value.'">';
        $parseStr   .= '<blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">';
        $parseStr   .= '预览图：<div class="layui-upload-list" id="demo_'.$field.'"><div class="layui-row layui-col-space10">'.$data.'</div></div> </blockquote></div>';
        $parseStr.="<script>
        layui.use('upload', function () {
            var upload = layui.upload;
            var imagesSrc_".$field." = '';
            upload.render({
                elem: '#btn_".$field."'
                ,url: '".url('upFiles/upImages')."'
                ,multiple: true
                ,done: function(res){
                    $('#demo_".$field." .layui-row').append('<div class=\"layui-col-md3\"><div class=\"dtbox\"><img src=\"".__PUBLIC__."'+ res.src +'\" class=\"layui-upload-img\"><input type=\"hidden\" class=\"imgVal\" value=\"'+ res.src +'\"> <i class=\"delimg layui-icon\">&#x1006;</i></div></div>');
                    imagesSrc_".$field." +=res.src+';';
                    $('input[name=\"".$field."\"]').val(imagesSrc_".$field.");
                }
            });
            $('#demo_".$field." .layui-row').on('click','.delimg',function(){
                var thisimg = $(this);
                var images='';
                layer.confirm('你确定要删除该图片吗？', function(index){
                    thisimg.parents('.layui-col-md3').remove();
                    layer.close(index);

                    $('#demo_".$field." .imgVal').each(function(i) {
                        images+=$(this).val()+';';
                    });
                    $('input[name=\"".$field."\"]').val(images);
                })
            })
        });
        </script>";


        return $parseStr;
    }
    public function file($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $field = $info['field'];
        $action = ACTION_NAME;
        $fileArr=explode('.',$this->data[$field]);
        $ext=$fileArr[1];
        if($action=='add' or $ext==''){
            $value ="__STATIC__/common/images/file.png";
        }else{
            $value = "__STATIC__/common/images/".$ext.".png";
        }
        $thumbstr ='<div class="layui-input-block" style="margin-left: 0;"><input type="hidden" name="'.$field.'" id="'.$field.'fval" value="'.$this->data[$field].'"><div class="layui-upload">';
        $thumbstr .='<button type="button" class="layui-btn layui-btn-primary" id="'.$info['class'].'"><i class="icon icon-upload3"></i>点击上传</button>';
        $thumbstr .='<div class="layui-upload-list"><img class="layui-upload-img" style="width:64px;" id="'.$info['class'].'File" src="'.$value.'"><p id="thumbText"></p>';
        $thumbstr .='</div></div></div>';
        $thumbstr.="<script>
                        layui.use('upload', function () {
                            var upload = layui.upload;
                            upload.render({
                                elem:'#".$info['class']."',
                                accept:'file',
                                url: '".url('upFiles/file')."',
                                title: '上传文件',
                                ext: '".$info['setup']['upload_allowext']."',
                                done: function(res){
                                    $('#".$field."File').attr('src', '__STATIC__/common/images/'+res.ext+'.png');
                                    $('#".$field."fval').val(res.url);
                                }
                            });
                        });
                    </script>";
        return $thumbstr;
    }

    /*public function files($info,$value){
        $info['setup']=is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $id = $field = $info['field'];
        $validate = getvalidate($info);
        $action = ACTION_NAME;
        if($action=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $data='';
        $i=0;
        if($value){
            $options = explode(":::",$value);
            if(is_array($options)){
                foreach($options as  $r) {
                    $v = explode("|",$r);
                    $k = trim($v[1]);
                    $optionsarr[$k] = $v[0];
                    $data .='<div id="uplistd_'.$i.'" class="col-md-6 ">
                    <div class="upimgs">
                    <input type="text"  class="form-control" name="'.$field.'[]" value="'.$v[0].'" style="margin-bottom:5px;"/>
                    <input type="text" class="form-control" name="'.$field.'_name[]" value="'.$v[1].'" placeholder="请填写文件标题"/>
                    <textarea class="form-control" name="'.$field.'_text[]" rows="2" cols="" style="margin:5px 0;" placeholder="请填写文件简介">'.$v[2].'</textarea>
                    <div class="clearfix"></div>
                    <a href="javascript:remove_this(\'uplistd_'.$i.'\');" class="btn btn-danger btn-block btn-xs">移除</a>
                    </div></div>';
                    $i++;
                }
            }
        }
        if(empty($info['setup']['upload_maxsize'])){
            $info['setup']['upload_maxsize'] =  intval(byte_format(config('attach_maxsize')));
        }
        $parseStr   = '<fieldset class="images_box">
        <legend>文件上传<span style="font-size: 16px;">（最多同时可以上传 <font color=\'red\'>'.$info['setup']['upload_maxnum'].'</font>张）</span></legend><center></center>
		<div id="'.$field.'_images" class="imagesList row">'.$data.'</div>
		</fieldset>
		<input type="button" class="btn btn-success btn-sm" value="文件上传" onclick="javascript:swfupload(\''.$field.'_uploadfile\',\''.$field.'\',\'文件上传\','.$info['setup']['more'].',0,\''.$info['setup']['upload_maxnum'].'\',\''.$info['setup']['upload_allowext'].'\','.$info['setup']['upload_maxsize'].','.$info['moduleid'].',up_images,nodo)">  ';

        return $parseStr;
    }*/

    public function multicolumn($info,$value)
    {
      $field = $info["field"];
      $value = $value ? $value : $this->data[$field];
      $multitype = $info["setup"]["multitype"];
      $catid = $info["setup"]["catid"];
      $multiple = $info["setup"]["multiple"];
      if($multitype == 'con'){
        // 内容
        $moduleid = db('category')->field('moduleid')->find($catid);
        $dbname = db('module')->field('name')->find($moduleid['moduleid']);
        $list = db($dbname['name'])->field('title,id')->where('catid',$catid)->select();
      }else{
        // 栏目
        $list = db('category')->field('id,catname as title')->where('parentid',$catid)->select();
      }
      $str = "";
      if($multiple == 0){
        $str.= "<select name=\"".$field."\">";
        foreach ($list as $key => $val) {
          if($value == $val['id']){
            $str.= '<option value="'.$val['id'].'" selected>'.$val['title'].'</option>';
          }else{
            $str.= '<option value="'.$val['id'].'">'.$val['title'].'</option>';
          }
        }
        $str.= "</select>";
      }elseif($multiple == 1){
        foreach ($list as $key => $val) {
          if($value == $val['id']){
            $str.= '<input type="radio" name="'.$field.'" value="'.$val['id'].'" title="'.$val['title'].'" checked/>';
          }else{
            $str.= '<input type="radio" name="'.$field.'" value="'.$val['id'].'" title="'.$val['title'].'"/>';
          }
        }
      }elseif($multiple == 2){
        $value = explode(',',$value);
        foreach ($list as $key => $val) {
          if(in_array($val['id'],$value)){
            $str.= '<input type="checkbox" name="'.$field.'[]" value="'.$val['id'].'" title="'.$val['title'].'" checked/>';
          }else{
            $str.= '<input type="checkbox" name="'.$field.'[]" value="'.$val['id'].'" title="'.$val['title'].'"/>';
          }
        }
      }
      return $str;
    }

    public function addbox($info,$value)
    {
      $field = $info['field'];
      $valuev = $value ? $value : $this->data[$field];
      if($info['setup']['other']){
        $otherarr = explode('|',$info['setup']['other']);
        $otherstr = '';
        foreach ($otherarr as $key => $value) {
          $val = explode(':',$value);
          if($val[0] == 'time'){
            $otherstr .= ' <div class="layui-inline">';
            $otherstr .= '   <input name="" id="'.$val[0].'-'.$field.'"  value="" class="layui-input '.$val[0].'-'.$field.'" placeholder="请输入'.$val[1].'">';
            $otherstr .= ' </div>';
            $otherstr .= ' <script>';
            $otherstr .= ' layui.use("laydate", function(){';
            $otherstr .= '  var laydate = layui.laydate;';
            $otherstr .= '  laydate.render({';
            $otherstr .= '      elem: "#'.$val[0].'-'.$field.'"';
            $otherstr .= '  });';
            $otherstr .= ' });';
            $otherstr .= ' </script>';
          }else{
            $otherstr .= ' <div class="layui-inline">';
            $otherstr .= '   <input name=""  value="" class="layui-input '.$val[0].'-'.$field.'" placeholder="请输入'.$val[1].'">';
            $otherstr .= ' </div>';
          }

        }
      }
      $str  = '';
      $str .= '<div class="layui-block addbox-'.$field.'">';
      $str .= ' <div class="layui-inline" style="width:2em;text-align:center">';
      $str .= ' 编号';
      $str .= ' </div>';
      $str .= $otherstr;
      $str .= ' <a class="layui-icon layui-icon-add-1" href="javascript:void(0)" id="addboxbtn-'.$field.'"></a>';
      $str .= '</div>';

      $str .= '<div class="layui-block addbox-list-'.$field.'">';

      $str .= '</div>';
      $str .= '<input name="'.$field.'" value=\''.$valuev.'\' class="layui-input" id="'.$field.'" type="hidden">';
      $str .= "<script>";
      $str .= "layui.use(['form','upload'],function () {";
      $str .= "      var form = layui.form;";
      $str .= "      var arr = new Array();";
      if($this->data[$field]){
        $str .= "    var dataobj = ".  $this->data[$field].";";
        $str .= "    if(dataobj){";
        $str .= "     $.each(dataobj,function(index,value){";
        $str .= "       arr.push(value);";
        $str .= "     });";
        $str .= "     subhtml();";
        $str .= "    }";
      }
      $str .= "    function addvideoarr() {";
      $str .= "    var arritem = [];console.log($('.addbox-".$field." .title-".$field."').val());";
      $str .= "      arritem['title'] = $('.addbox-".$field." .title-".$field."').val();";
      foreach ($otherarr as $key => $value) {
        $val = explode(':',$value);
        $str .= "    arritem['".$val[0]."'] = $('.addbox-".$field." input.".$val[0]."-".$field."').val();";
      }
      $str .= "      arr.push(arritem);";
      $str .= "    }function changevideoarr() {

					arr.length = 0;
					console.log(arr);
					$('.addbox-item-zyfs').each(function(i){
						var arritem = [];
						arritem['title'] = $(this).find('select').val();
						arritem['wkzdf'] = $(this).find('input.wkzdf-zyfs').val();
						arritem['lkzdf'] = $(this).find('input.lkzdf-zyfs').val();
						arritem['gongshi'] = $(this).find('input.gongshi-zyfs').val();
						arr.push(arritem);
					});

	    }";

      $str .= "    function encodeArray2D(obj) {";
		  $str .= "     var array = [];";
      $str .= "       $.each(obj,function(index,value){";
      $str .= "         var str = '';";
      $str .= "         for(var key in value){";
      $str .= "           str = str + '\"' + key+'\":'+ '\"' + value[key] + '\",';";
      $str .= "         }";
      $str .= "         array[index] = '{'+str.substring(0,str.length-1)+'}';";
      $str .= "       });";
		  $str .= "     return '[' + array.join(',') + ']';";
	    $str .= "    };";
      $str .= "    function subhtmlarr() {";
      $str .= "      $('#".$field."').val(encodeArray2D(arr));";
      $str .= "    };";
      $str .= "    function subhtml() {";
      $str .= "      $('#".$field."').val(encodeArray2D(arr));";
      $str .= "       var html = '',str='';";
      $str .= "       $.each(arr,function(index,value){";
      $str .= "           html = html + '<div class=\"layui-block addbox-item-".$field."\">';";
      $str .= "           html = html + '<div class=\"layui-inline\" style=\"width:2em;text-align:center\">';";
      $str .= "           html = html + (index + 1);";
      $str .= "           html = html + '</div> ';";
      $str .= "           html = html + '<div class=\"layui-inline\">';";
      // $str .= "           html = html + '<input type=\"text\" class=\"layui-input\" placeholder=\"请输入标题\" value=\"'+value.title+'\">';";

      foreach ($otherarr as $key => $value) {
          $val = explode(':',$value);
          $str .= "          html = html + ' <div class=\"layui-inline\">';";
          $str .= "          html = html + '   <input  type=\"text\" value=\"'+value.".$val[0]."+'\" class=\"layui-input ".$val[0]."-".$field."\" placeholder=\"请输入".$val[1]."\">';";
          $str .= "          html = html + ' </div>';";
      }
      // $str .= "           str = str + '".$otherstr."';";
      $str .= "           html = html + ' <a class=\"layui-icon layui-icon-close addboxdelbtn-".$field."[]\" href=\"javascript:void(0)\"></a>';";
      $str .= "           html = html + '</div>';";
      $str .= "        });";
      $str .= "       $('.addbox-list-".$field."').html(html);";
      $str .= "       $('.addbox-".$field." input').val('');  form.render();";
      $str .= "    }";
      $str .= "    $('.addbox-".$field."').on('click','#addboxbtn-".$field."',function(){";
      $str .= "       addvideoarr();";
      $str .= "       subhtml();";
      $str .= "    });";
      $str .= "    $('.addbox-list-".$field."').on('input propertychange','input',function(){";
      $str .= "       changevideoarr();";
      $str .= "       subhtmlarr();";
      $str .= "    });";
      $str .= "    $('body').on('click','.addbox-item-".$field." a',function(){";
      $str .= "       var i = $(this).parent().index();";
      $str .= "       arr.splice(i,1);";
      $str .= "       subhtml();";
      $str .= "    });";
      $str .= "});";
      $str .= "</script>";
      if($info['setup']['info']){
        $str .= $info['setup']['info'];
      }
      return $str;
    }

    public function addbox1($info,$value)
    {
      $field = $info['field'];
      if($info['setup']['other']){
        $otherarr = explode('|',$info['setup']['other']);
        $otherstr = '';
        foreach ($otherarr as $key => $value) {
          $val = explode(':',$value);
          $otherstr .= ' <div class="layui-inline">';
          $otherstr .= '   <input name=""  value="" class="layui-input '.$val[0].'-'.$field.'" placeholder="请输入'.$val[1].'">';
          $otherstr .= ' </div>';
        }
      }
      $tagstr = '';
      $list = db('tag')->field('id,title')->where('catid',42)->select();
      foreach ($list as $key => $value) {
        $tagstr .= '<option value="'.$value['id'].'" >'.$value['title'].'</option>';
      }
      $str  = '';
      $str .= '<div class="layui-block addbox-'.$field.'">';
      $str .= ' <div class="layui-inline" style="width:2em;text-align:center">';
      $str .= ' 编号';
      $str .= ' </div>';
      // $str .= ' <div class="layui-inline">';
      // $str .= '   <select class="layui-select title-'.$field.'">';
      // $str .=  $tagstr;
      // $str .= '   </select>';
      // $str .= ' </div>';
      // $str .= ' <div class="layui-inline">';
      // $str .= '   <input name="" value="" type="text" class="layui-input title-'.$field.'" placeholder="请输入标题">';
      // $str .= ' </div>';
      $str .= $otherstr;
      $str .= ' <a class="layui-icon layui-icon-add-1" href="javascript:void(0)" id="addboxbtn-'.$field.'"></a>';
      $str .= '</div>';

      $str .= '<div class="layui-block addbox-list-'.$field.'">';

      $str .= '</div>';
      $str .= '<input name="'.$field.'" value="" class="layui-input" id="'.$field.'" type="hidden">';
      $str .= "<script>";
      $str .= "layui.use(['form','upload'],function () {";
      $str .= "      var form = layui.form;";
      $str .= "      var arr = new Array();";
      if($this->data[$field]){
        $str .= "    var dataobj = ".  $this->data[$field].";";
        $str .= "    if(dataobj){";
        $str .= "     $.each(dataobj,function(index,value){";
        $str .= "       arr.push(value);";
        $str .= "     });";
        $str .= "     subhtml();";
        $str .= "    }";
      }
      $str .= "    function addvideoarr() {";
      $str .= "    var arritem = [];console.log($('.addbox-".$field." .title-".$field."').val());";
      $str .= "      arritem['title'] = $('.addbox-".$field." .title-".$field."').val();";
      foreach ($otherarr as $key => $value) {
        $val = explode(':',$value);
        $str .= "    arritem['".$val[0]."'] = $('.addbox-".$field." input.".$val[0]."-".$field."').val();";
      }
      $str .= "      arr.push(arritem);";
      $str .= "    }";
      $str .= "    function encodeArray2D(obj) {";
		  $str .= "     var array = [];";
      $str .= "       $.each(obj,function(index,value){";
      $str .= "         var str = '';";
      $str .= "         for(var key in value){";
      $str .= "           str = str + '\"' + key+'\":'+ '\"' + value[key] + '\",';";
      $str .= "         }";
      $str .= "         array[index] = '{'+str.substring(0,str.length-1)+'}';";
      $str .= "       });";
		  $str .= "     return '[' + array.join(',') + ']';";
	    $str .= "    };";

      $str .= "    function subhtml() {";
      $str .= "      $('#".$field."').val(encodeArray2D(arr));";
      $str .= "       var html = '',str='';";
      $str .= "       $.each(arr,function(index,value){";
      $str .= "           html = html + '<div class=\"layui-block addbox-item-".$field."\">';";
      $str .= "           html = html + '<div class=\"layui-inline\" style=\"width:2em;text-align:center\">';";
      $str .= "           html = html + (index + 1);";
      $str .= "           html = html + '</div> ';";
      foreach ($otherarr as $key => $value) {
          $val = explode(':',$value);
          $str .= "          html = html + ' <div class=\"layui-inline\">';";
          $str .= "          html = html + '   <input name=\"".$val[0]."-".$field."[]\" type=\"text\" value=\"'+value.".$val[0]."+'\" class=\"layui-input\" placeholder=\"请输入".$val[1]."\">';";
          $str .= "          html = html + ' </div>';";
      }
      // $str .= "           str = str + '".$otherstr."';";
      $str .= "           html = html + ' <a class=\"layui-icon layui-icon-close addboxdelbtn-".$field."[]\" href=\"javascript:void(0)\"></a>';";
      $str .= "           html = html + '</div>';";
      $str .= "        });";
      $str .= "       $('.addbox-list-".$field."').html(html);";
      $str .= "       $('.addbox-".$field." input').val('');  form.render();";
      $str .= "    }";
      $str .= "    $('.addbox-".$field."').on('click','#addboxbtn-".$field."',function(){";
      $str .= "       addvideoarr();";
      $str .= "       subhtml();";
      $str .= "    });";
      $str .= "    $('body').on('click','.addbox-item-".$field." a',function(){";
      $str .= "       var i = $(this).parent().index();";
      $str .= "       arr.splice(i,1);";
      $str .= "       subhtml();";
      $str .= "    });";
      $str .= "});";
      $str .= "</script>";
      return $str;
    }

    public function linkage($info){
        $field = $info['field'];
        $value = '';
        if($this->data[$field]){
            $value = explode(',',$this->data[$field]);
        }
        $region = db('region')->where(['pid'=>1])->select();
        $html='<div class="layui-input-inline">';
        $html .='<select name="'.$field.'[]" id="province" lay-filter="province">';
        $html .='<option value="">请选择省</option>';
        foreach ($region as $k=>$v){
            if($value[0] == $v['id']){
                $html .='<option selected value="'.$v['id'].'">'.$v['name'].'</option>';
            }else{
                $html .='<option value="'.$v['id'].'">'.$v['name'].'</option>';
            }
        }
        $html .='</select>';
        $html .='</div>';

        $city ='';
        if($value[0]){
            $city = db('region')->where(['pid'=>$value[0]])->select();
        }

        $html .='<div class="layui-input-inline">';
        $html .='<select name="'.$field.'[]" id="city" lay-filter="city">';
        $html .='<option value="">请选择市</option>';
        if($city){
            foreach ($city as $k=>$v){
                if($value[1] == $v['id']){
                    $html .='<option selected value="'.$v['id'].'">'.$v['name'].'</option>';
                }else{
                    $html .='<option value="'.$v['id'].'">'.$v['name'].'</option>';
                }
            }
        }

        $html .='</select>';
        $html .='</div>';

        $district ='';
        if($value[1]){
            $district = db('region')->where(['pid'=>$value[1]])->select();
        }


        $html .='<div class="layui-input-inline">';
        $html .='<select name="'.$field.'[]" id="district" lay-filter="district">';
        $html .='<option value="">请选择县/区</option>';

        if($district){
            foreach ($district as $k=>$v){
                if($value[2] == $v['id']){
                    $html .='<option selected value="'.$v['id'].'">'.$v['name'].'</option>';
                }else{
                    $html .='<option value="'.$v['id'].'">'.$v['name'].'</option>';
                }
            }
        }

        $html .='</select>';
        $html .='</div>';
        return $html;
    }
}
?>