<?php
namespace app\api\model;
/**
 * Input组件库
 * @var string $from 表单class form:文本和输入框占两行，form-horizontal：文本输入框占一行
 * @var string $type input属性-type
 * @var string $name input属性-name
 * @var array  $options 一些通用选项
 * @return string $html 返回html
 */

use app\api\model\Txmap;

class Input {
    /**
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
      </div>
    </div>
     */
    /** @var array 一些配置 */
    protected $options = [
        'style'        => 'form',
        'title'       => '',
        'type'        => 'text',
        'name'        => '',
        'id'          => '',
        'disabled'    => false,
        'readonly'    => false,
        'placeholder' => '',
        'tips'        => '',
        'value'       => '',
        'div_class'   => '',
        'label_class' => 'col-sm-2',
        'input_class' => 'col-sm-10',
        'hidden'      => [],
        'date'        => [
            'date'    => true,
            'time'    => true,
        ],
        'timeSet' =>[
            'showInputs'  => 'false',     // 是否显示窗口输入框
            'showMeridian'=> 'false',     // true:12小时制 false:24小时制
            'defaultTime' => 'current', // 默认时间
            'showSeconds' => 'true'      // 是否显示秒
        ]

    ];

    protected $simple = [
        'string',
        'number',
        'tel',
        'link',
        'email'
    ];

    protected $audio = [
        '163.' => <<<EOF
<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=330 height=86 src="%s"></iframe>
EOF
        ,
        'default' => <<<EOF
<audio src="%s" controls="controls" preload="meta"></audio>
EOF
    ];

    protected $video = [
        'youku.' => <<<EOF
<embed src='%s' allowFullScreen='true' quality='high' width='480' height='400' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash'></embed>
EOF
    ,
    'default' => <<<EOF
<video src="" controls="controls" width="300" preload="meta"></video>
EOF
    ,
    'hdslb.'   => <<<EOF
<embed height="415" width="544" quality="high" allowfullscreen="true" type="application/x-shockwave-flash" src="%s" flashvars="aid=11647637&page=1" pluginspage="//www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
EOF
    ,
    'aixifan.' => <<<EOF
<iframe style="width:704px;height:436px;" src="%s" id="ACFlashPlayer-re" frameborder="0"></iframe>
EOF
];
    protected $operat = <<<EOF
<div style="position:absolute;right:0;top:-34px;opacity:0.3;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.3">
    <span class="btn btn-info btn-flat" title="修改" onclick="operat.edit(this)" style="opacity:inherit;">
        <span class="glyphicon glyphicon-edit"></span>
    </span>
    <span class="btn btn-danger btn-flat" title="删除" onclick="operat.delete(this)" style="opacity:inherit;">
        <span class="glyphicon glyphicon-remove"></span>
    </span>
    <span class="btn btn-default btn-flat" title="上移" onclick="operat.moveUp(this)" style="opacity:inherit;">
        <span class="glyphicon glyphicon-arrow-up"></span>
    </span>
    <span class="btn btn-default btn-flat" title="下移" onclick="operat.moveDown(this)" style="opacity:inherit;">
        <span class="glyphicon glyphicon-arrow-down"></span>
    </span>
</div>
EOF;
    protected $type;

    /** @var string label */
    protected $label;

    /** @var string input */
    protected $input;

    /** @var string tips */
    protected $tips = '';

    /** @var string 返回的html */
    protected $html;

    /** @param array $options 一些通用设置 */
    public function set($options = []){
        foreach ($options as $key => $value) {
            if(array_key_exists($key, $this->options)){
                $this->options[$key] = $value;
            }
        }
        return $this;
    }
    public function get(){
        $label = $this->getLabel();
        $input = $this->getInput();
        $tips  = $this->getTips();
        $this->getHtml();
        return $this->html;
    }

    protected function getLabel(){
        switch ($this->options['style']) {
            case 'form':
                $this->label = sprintf('<label for="%s">%s</label>', $this->options['id'], $this->options['title']);
                return true;
                break;
            case 'form-horizontal':
                $this->label = sprintf('<label for="%s" class="%s control-label">%s</label>', $this->options['id'], $this->options['label_class'], $this->options['title']);
                return true;
                break;
            default:
                return false;
        }
    }

    protected function getInput(){
        if(in_array($this->options['type'], $this->simple)){
            if($this->getsimble()){
                return true;
            }
        }
        elseif($this->options['type'] == 'text'){
            if($this->getText()){
                return true;
            }
        }
        elseif($this->options['type'] == 'rich'){
            if($this->getRich()){
                return true;
            }
        }
        elseif($this->options['type'] == 'date'){
            if($this->getDate()){
                return true;
            }
        }
        elseif($this->options['type'] == 'audio'){
            if($this->getAudio()){
                return true;
            }
        }
        elseif($this->options['type'] == 'video'){
            if($this->getVideo()){
                return true;
            }
        }
        elseif($this->options['type'] == 'image'){
            if($this->getImage()){
                return true;
            }
        }
        elseif($this->options['type'] == 'file'){
            if($this->getFile()){
                return true;
            }
        }
        elseif($this->options['type'] == 'city'){
            if($this->getCity()){
                return true;
            }
        }
        elseif($this->options['type'] == 'location'){
            if($this->getLocation()){
                return true;
            }
        }else{
            return false;
        }
    }

    protected function getTips(){
        if(!empty($this->options['tips'])){
            $this->tips = sprintf('<p class="help-block"><i class="text-warning">小贴士：</i>%s</p>', $this->options['tips']);
        }
    }

    protected function getHtml(){
        $this->input = sprintf('%s %s', $this->input, $this->tips);
        if($this->options['style'] == 'form-horizontal'){
            $this->input = sprintf('<div class="%s">%s</div>', $this->options['input_class'], $this->input);
        }
        $div = '<div class="form-group %s" style="position:relative;">%s %s %s %s</div>';
        $hidInput = '';
        if(!empty($this->options['hidden'])){
            foreach ($this->options['hidden'] as $k => $v) {
                $hidInput .= "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\">";
            }
        }
        if(in_array($this->options['type'], ['rich'])) $this->operat = '';
        $this->html = sprintf($div, $this->options['div_class'], $hidInput, $this->label, $this->input, $this->operat);
    }

    protected function getSimble(){
        $disabled = $this->options['disabled']?'disabled':'';
        $readonly = $this->options['readonly']?'readonly':'';
        $this->input = sprintf('<input type="text" class="form-control" id="%s" name="%s" placeholder="%s" %s %s value="%s">', $this->options['id'], $this->options['name'], $this->options['placeholder'], $disabled, $readonly, $this->options['value']);
    }
    /**
     * <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right" id="datepicker"></div>
     <div class="bootstrap-timepicker">
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control timepicker">

            <div class="input-group-addon">
              <i class="fa fa-clock-o"></i>
            </div>
          </div>
          <!-- /.input group -->
        </div>
        <!-- /.form group -->
      </div>
    </div>
     */
    protected function getDate(){
        if(empty($this->options['value'])) $this->options['value']=['date'=>'', 'time'=>''];
        $disabled = $this->options['disabled']?'disabled':'';
        $readonly = $this->options['readonly']?'readonly':'';
        $width    = $this->options['date']['time']&&$this->options['date']['date']?'width:50%':'';

        if($this->options['date']['date']){

            $date = sprintf(<<<EOF
<div class="input-group pull-left" style="%s">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    <input type="text" class="form-control datepicker" id="%s" name="%s" %s %s value="%s">
</div>
EOF
, $width, $this->options['id'], $this->options['name'].'[date]', $disabled, $readonly, $this->options['value']['date']);

            $dateJs = sprintf(<<<EOF
$(function() {
    $(".datepicker").each(function(){
        $(this).inputmask("yyyy-mm-dd", {
            "placeholder": "*"
        })
    });
});
EOF
, $this->options['id']);

        }else{
            $date   = '';
            $dateJs = '';
        }

        if($this->options['date']['time']){

            $time = sprintf(<<<EOF
<div class="bootstrap-timepicker pull-left" style="%s">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-clock-o"></i>
        </div>
        <input type="text" class="form-control timepicker" name="%s" value="%s">
    </div>
</div>
EOF
, $width, $this->options['name'].'[time]', $this->options['value']['time']);

            $timeJs = sprintf(<<<EOF
$(function() {
    $(".timepicker").timepicker({
        showInputs:%s,
        showMeridian:%s,
        defaultTime:"%s",
        showSeconds:%s
    });
});
EOF
, $this->options['timeSet']['showInputs'], $this->options['timeSet']['showMeridian'], $this->options['timeSet']['defaultTime'], $this->options['timeSet']['showSeconds']);

        }else{
            $time   = '';
            $timeJs = '';
        }

        $js = sprintf('<script>%s %s</script>', $dateJs, $timeJs);
        $this->input = sprintf('<div>%s %s</div> %s', $date, $time, $js);
    }

    protected function getAudio(){
        // $url = 'http://cdn.aixifan.com/player/ACFlashPlayer.out.swf?vid=5336205&ref=http://www.acfun.cn/v/ac3806466';
        $url = '//music.163.com/style/swf/widget.swf?sid=483671599&type=2&auto=0&width=320&height=66';
        // $url = '';
        $host = parse_url($this->options['value'] ,PHP_URL_HOST);
        foreach ($this->audio as $key => $value) {
            if(strpos($host, $key) !== false){
                $audio = $value;
                break;
            }
        }
        if(!empty($audio)){
            $audio = sprintf($audio, $this->options['value']);
        }else{
            $audio = sprintf($this->audio['default'], $this->options['value']);
        }
        $this->input = sprintf(<<<EOF
<div class="input-group">
    <input type="text" class="form-control" name="%s" value="%s"/>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default" onclick="sltMedia(this);">
            选择音频
        </button>
    </div>
</div>
<div class="input-group" style="padding-top:16px">
    %s
    <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这个音频" onclick="dltMedia(this)">×</em>
</div>
EOF
, $this->options['name'], $this->options['value'], $audio);
    }

    protected function getVideo(){
        // $url = 'http://cdn.aixifan.com/player/ACFlashPlayer.out.swf?vid=5336205&ref=http://www.acfun.cn/v/ac3806466';
        $url = 'http://player.youku.com/player.php/sid/XMjUzMDQzMTQxMg==/v.swf';
        // $url = '';
        $host = parse_url($this->options['value'], PHP_URL_HOST);
        foreach ($this->video as $key => $value) {
            if(strpos($host, $key) !== false){
                $video = $value;
                break;
            }
        }
        if(!empty($video)){
            $video = sprintf($video, $this->options['value']);
        }else{
            $video = sprintf($this->video['default'], $this->options['value']);
        }
        $this->input = sprintf(<<<EOF
<div class="input-group">
    <input type="text" class="form-control" name="%s" value="%s"/>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default" onclick="sltMedia(this);">
            选择视频
        </button>
    </div>
</div>
<div class="input-group" style="padding-top:16px">
    %s
    <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这个视频" onclick="dltMedia(this)">×</em>
</div>
EOF
, $this->options['name'], $this->options['value'], $video);
    }

    protected function getImage(){
        $url = 'http://pic.qiantucdn.com/58pic/14/12/89/58PIC2858PIC4nq_1024.jpg';
        $this->input = sprintf(<<<EOF
<div class="input-group">
    <input type="text" class="form-control" name="%s" value="%s"/>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default" onclick="sltMedia(this);">
            选择图片
        </button>
    </div>
</div>
<div class="input-group" style="margin-top:.5em;">
    <img src="%s" onerror="this.src='http://www.bwg.com/static/image/thumd.92feff019ddeae01d9ca13582a75ed0a.jpeg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
    <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="dltMedia(this)">×</em>
</div>
EOF
, $this->options['name'], $this->options['value'], $this->options['value']);
    }

    protected function getFile(){
        $url = 'http://pic.qiantucdn.com/58pic/14/12/89/58PIC2858PIC4nq_1024.jpg';
        $this->input = sprintf(<<<EOF
<div class="input-group">
    <input type="text" class="form-control" name="%s" value="%s"/>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default" onclick="sltFile(this);">
            文件上传
        </button>
    </div>
</div>
EOF
, $this->options['name'], $this->options['value']);
    }
    protected function getCity(){
        if(empty($this->options['value'])) $this->options['value']=['province'=>'', 'city'=>'', 'area'=>'', 'address'=>''];
        $map = new Txmap;
        $list = $map->getList();
        $list = json_decode($list,true);
        $pro = '<option value="0">省份</option>';
        foreach ($list['result'][0] as $value) {
            if($this->options['value']['province'] == $value['fullname']){
                $pro .= sprintf('<option value="%s" data-id="%s" selected>%s</option>', $value['fullname'], $value['id'], $value['fullname']);
                $proId = $value['id'];
            }else{
                $pro .= sprintf('<option value="%s" data-id="%s">%s</option>', $value['fullname'], $value['id'], $value['fullname']);
            }
        }
        $city = '';
        if(isset($proId)){
            $list = $map->getchildren($proId);
            $list = json_decode($list,true);
            $city = '<option value="0">区/城市</option>';
            foreach ($list['result'][0] as $value) {
                if($this->options['value']['city'] == $value['fullname']){
                    $cityId = $value['id'];
                    $city .= sprintf('<option value="%s" data-id="%s" selected>%s</option>', $value['fullname'], $value['id'], $value['fullname']);
                }else{
                    $city .= sprintf('<option value="%s" data-id="%s">%s</option>', $value['fullname'], $value['id'], $value['fullname']);
                }
            }
        }
        $area = '';
        if(isset($cityId)){
            $list = $map->getchildren($cityId);
            $list = json_decode($list,true);
            $area = '<option value="0">镇/街道</option>';
            foreach ($list['result'][0] as $value) {
                if($this->options['value']['area'] == $value['fullname']){
                    $area .= sprintf('<option value="%s" data-id="%s" selected>%s</option>', $value['fullname'], $value['id'], $value['fullname']);
                }else{
                    $area .= sprintf('<option value="%s" data-id="%s">%s</option>', $value['fullname'], $value['id'], $value['fullname']);
                }
            }
        }
        $this->input = sprintf(<<<EOF
<div class="city-group" id="%s">
    <select class="form-control select2 pro" style="width: 33%%;" onchange="getAreas(this,'city')" name="%s">
        %s
    </select>
    <select class="form-control select2 city" style="width: 33%%;" onchange="getAreas(this,'area')" name="%s">
        %s
    </select>
    <select class="form-control select2 area" style="width: 33%%;" name="%s">
        %s
    </select>
</div>
<div class="input-group" style="width:100%%">
    <input type="text" class="form-control" placeholder="详细地址" name="%s" value="%s"/>
</div>
<script>
$(function() {
    $('#%s .select2').select2();
})
</script>
EOF
, $this->options['id'], $this->options['name'].'[province]', $pro, $this->options['name'].'[city]', $city, $this->options['name'].'[area]', $area, $this->options['name'].'[address]', $this->options['value']['address'], $this->options['id']);
    }

    protected function getLocation(){
        if(empty($this->options['value'])) $this->options['value']=['latitude'=>'', 'longitude'=>'', 'address'=>''];
        $this->input = sprintf(<<<EOF
<div class="input-group">
    <div class="row">
        <div class="col-sm-6">
            <div class="input-group">
                <div class="input-group-addon">
                    纬度
                </div>
                <input type="text" class="form-control lat" name="%s" value="%s"/>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                <div class="input-group-addon">
                    经度
                </div>
                <input type="text" class="form-control lng" name="%s" value="%s"/>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="input-group">
                <div class="input-group-addon">
                    地址
                </div>
                <input type="text" class="form-control addr" name="%s" value="%s"/>
            </div>
        </div>
    </div>
    <div class="input-group-btn" onclick="sltLocation(this);">
        <button type="button" class="btn btn-default">
            选择地址
        </button>
    </div>
</div>
EOF
, $this->options['name'].'[latitude]', $this->options['value']['latitude'], $this->options['name'].'[longitude]', $this->options['value']['longitude'], $this->options['name'].'[address]', $this->options['value']['address']);
    }

    protected function getText(){
        $this->input = sprintf('<textarea class="form-control" id="%s" name="%s" placeholder="%s" rows="5">%s</textarea>', $this->options['id'], $this->options['name'], $this->options['placeholder'], $this->options['value']);
    }

    protected function getRich(){
        $this->input = sprintf(<<<EOF
<textarea class="textarea" placeholder="%s" style="width: 100%%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="%s" name="%s">%s</textarea>
<script>
$(function() {
    if(!CKEDITOR.instances['%s']){
        CKEDITOR.replace('%s');
    }else{
        CKEDITOR.remove('%s');
        CKEDITOR.replace('%s');
    }
})
</script>
EOF
,  $this->options['placeholder'], $this->options['id'], $this->options['name'], $this->options['value'], $this->options['id'], $this->options['id'], $this->options['id'],  $this->options['id']);
    }
}