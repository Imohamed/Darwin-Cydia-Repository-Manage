<?php
$versions = array(
  array(
    'label' => '本地文件安装',
    'url' => 'local',
    'description' => '使用本地安装，请在我的博客中下载整合包，并重命名为latest.zip'
  ),
  array(
    'label' => 'DCRM PRO',
    'url' => 'http://jclxiazai.tk/DCRM/DCRM.zip',
    'description' => '下载最新版DCRM PRO'
  ),
  //添加你想要的语言
  
);

$download_ok  = false;
$done_zip = false;
if (isset($_POST['install'])){
  //download latest
  if (isset($_POST['ver']) && in_array($_POST['ver'],array('1','2'))){
    $download_ok = http_get_file($versions[$_POST['ver']]['url'],'latest.zip');
  }elseif ($_POST['ver'] == '0'){
    //use local file
    $download_ok = file_exists('latest.zip');
    if(!$download_ok){
      echo '<br/> 文件不存在，尝试下载最新稳定版本.';
    }
  }else{
    //use get latest stable url for remote
    $uri = Get_latest_version_url($versions[$_POST['ver']]['lang_code']);
    $download_ok = http_get_file($uri,'latest.zip');
  }
  //unzip
  if ($download_ok){
    $done_zip = extract_zip('latest.zip',$_POST['folder']);
  }else{
    echo '<br/> 文件不存在，尝试下载最新稳定版本.';
    die();
  }
  
  //create database
  if (isset($_POST['mk_db']) && $_POST['mk_db'] == 'mkdb' ){
    create_db($_POST['db_user'],$_POST['db_pass'],$_POST['server'],$_POST['db_name']);
  }
  
  
  
  //redirect to installer
  if ($done_zip){
    ?>
    <div style="display: none;">
      <?php includejQuery(); ?>
      <form action="<?php echo $_POST['folder'].'/install/setup-config.php?step=3'; ?>" method="post" id="insa">
      <p>下面你应该输入你的数据库信息。如果你不知道这些，联系你的主机。 </p>
      <table class="form-table">
        <tbody><tr>
          <th scope="row"><label for="dbname">数据库名称</label></th>
          <td><input type="text" value="<?php echo $_POST['db_name'];?>" size="25" id="dbname" name="dbname"></td>
          <td>你想运行WP的数据库的名称。 </td>
        </tr>
        <tr>
          <th scope="row"><label for="uname">数据库用户名</label></th>
          <td><input type="text" value="<?php echo $_POST['db_user'];?>" size="25" id="uname" name="uname"></td>
          <td>你的MySQL用户名</td>
        </tr>
        <tr>
          <th scope="row"><label for="pwd">密码</label></th>
          <td><input type="text" value="<?php echo $_POST['db_pass'];?>" size="25" id="pwd" name="pwd"></td>
          <td>...和你MySQL的密码.</td>
        </tr>
        <tr>
          <th scope="row"><label for="dbhost">数据库主机</label></th>
          <td><input type="text" value="<?php echo $_POST['server'];?>" size="25" id="dbhost" name="dbhost"></td>
          <td>你可以需要从主机商得到这个信息, 如果 <code>主机</code>不工作</td>
        </tr>
        <tr>
          <th scope="row"><label for="prefix">表前缀</label></th>
          <td><input type="text" size="25" value="<?php echo $_POST['db_prefix'];?>" id="prefix" name="prefix"></td>
          <td>如果你想运行多个DCRM安装在一个数据库，请修改这个.</td>
        </tr>
      </tbody></table>
        <p class="step"><input id="bong" type="submit" class="button" value="Submit" name="submit"></p>
      </form>
    </div>
    <?php
    echo '<script type="text/javascript">
        jQuery(document).ready(function() {
          jQuery("#bong").click();
        });
      </script>';
      exit();
  }
}else{
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html>
  <head>
    <title>DCRM 急速安装</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
    html{background:#f9f9f9;}body{background:#fff;color:#333;font-family:sans-serif;margin:2em auto;padding:1em 2em;-webkit-border-radius:3px;border-radius:3px;border:1px solid #dfdfdf;max-width:700px;}a{color:#21759B;text-decoration:none;}a:hover{color:#D54E21;}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px Georgia,"Times New Roman",Times,serif;margin:30px 0 0 0;padding:0;padding-bottom:7px;}h2{font-size:16px;}p,li,dd,dt{padding-bottom:2px;font-size:14px;line-height:1.5;}code,.code{font-size:14px;}ul,ol,dl{padding:5px 5px 5px 22px;}a img{border:0;}abbr{border:0;font-variant:normal;}#logo{margin:6px 0 14px 0;border-bottom:none;text-align:center;}.step{margin:20px 0 15px;}.step,th{text-align:left;padding:0;}.submit input,.button,.button-secondary{font-family:sans-serif;text-decoration:none;font-size:14px!important;line-height:16px;padding:6px 12px;cursor:pointer;border:1px solid #bbb;color:#464646;-webkit-border-radius:15px;border-radius:15px;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;}.button:hover,.button-secondary:hover,.submit input:hover{color:#000;border-color:#666;}.button,.submit input,.button-secondary{background:#f2f2f2 url(../images/white-grad.png) repeat-x scroll left top;}.button:active,.submit input:active,.button-secondary:active{background:#eee url(../images/white-grad-active.png) repeat-x scroll left top;}textarea{border:1px solid #dfdfdf;-webkit-border-radius:3px;border-radius:3px;font-family:sans-serif;width:695px;}.form-table{border-collapse:collapse;margin-top:1em;width:100%;}.form-table td{margin-bottom:9px;padding:10px 20px 10px 0;border-bottom:8px solid #fff;font-size:14px;vertical-align:top;}.form-table th{font-size:14px;text-align:left;padding:16px 20px 10px 0;border-bottom:8px solid #fff;width:140px;vertical-align:top;}.form-table code{line-height:18px;font-size:14px;}.form-table p{margin:4px 0 0 0;font-size:11px;}.form-table input{line-height:20px;font-size:15px;padding:2px;border:1px #DFDFDF solid;-webkit-border-radius:3px;border-radius:3px;font-family:sans-serif;}.form-table input[type=text],.form-table input[type=password]{width:206px;}.form-table th p{font-weight:normal;}.form-table.install-success td{vertical-align:middle;padding:16px 20px 10px 0;}.form-table.install-success td p{margin:0;font-size:14px;}.form-table.install-success td code{margin:0;font-size:18px;}#error-page{margin-top:50px;}#error-page p{font-size:14px;line-height:18px;margin:25px 0 20px;}#error-page code,.code{font-family:Consolas,Monaco,monospace;}#pass-strength-result{background-color:#eee;border-color:#ddd!important;border-style:solid;border-width:1px;margin:5px 5px 5px 0;padding:5px;text-align:center;width:200px;display:none;}#pass-strength-result.bad{background-color:#ffb78c;border-color:#ff853c!important;}#pass-strength-result.good{background-color:#ffec8b;border-color:#fc0!important;}#pass-strength-result.short{background-color:#ffa0a0;border-color:#f04040!important;}#pass-strength-result.strong{background-color:#c3ff88;border-color:#8dff1c!important;}.message{border:1px solid #e6db55;padding:.3em .6em;margin:5px 0 15px;background-color:#ffffe0;}body.rtl{font-family:Tahoma,arial;}.rtl h1{font-family:arial;margin:5px -4px 0 0;}.rtl ul,.rtl ol{padding:5px 22px 5px 5px;}.rtl .step,.rtl th,.rtl .form-table th{text-align:right;}.rtl .submit input,.rtl .button,.rtl .button-secondary{margin-right:0;}.rtl #user_login,.rtl #admin_email,.rtl #pass1,.rtl #pass2{direction:ltr;}#description {
	background-repeat: no-repeat;
	color: #4C4C4C;
	font-family: Georgia,"Times New Roman",Times,serif;
	font-size: 16px;
	font-style: italic;
	min-height: 45px;
	padding: 15px 10px;
	background: none repeat scroll 0 0 #DBECF8;
	border-radius: 6px 6px 6px 6px;
	float: right;
}
    </style>
  </head>
  <body>
    <div>
      <h1 id="logo"> <a href="http://apt.jclmiku.ml"><img src="http://pic.jclmiku.ml/logo.png"></a>
      </h1>
      <p>急速安装DCRM（此文件只能适用于Apache）</p>
      <br />
      <p>
        <?php if (!function_exists('curl_init') || !in_array('curl', get_loaded_extensions())){ ?>
      </p>
      <p><b>cURL</b> 没有被启动，本程序需要curl的支持</p>
      <?php } ?>
      <form method="POST" name="installer_form">
    <p>
      <input name="installer" type="hidden" value="ins" />
    选择你要安装的版本:
    <select name="ver" id="ver">
      <?php
      $radios = '';
      foreach ($versions as $key => $arr){
        $radios .=  '<option  value="'.$key.'" />'.$arr['label'].'</option>';
      }
      $radios  = str_replace('value="1"','value="1" selected="selected"',$radios);
      echo $radios;
    ?>
    </select>
    <br/>
    <span id="description"> 欢迎使用DCRM急速安装！！</span>    </p>
    <p>
      <input  name="mk_db" type="checkbox" value="mkdb" checked="checked"/> 
      创建数据库</p>
    <p>数据库服务器（本地主机）
      <input name="server" type="text" value="localhost" />
    </p>
    <p>数据库名称
      <input name="db_name" id="db_name" type="text" value="" />
    </p>
    <p>数据库用户名
      <input name="db_user" type="text" value="" />
    </p>
    <p>数据库用户密码 
      <input name="db_pass" type="text" value="" />
    </p>
    <p>表前缀
      <input name="db_prefix" type="text" value="apt_" />
    </p>
    <p class="step">
      <input name="install" type="submit" class="button" value="开始" />
    </p>
  </form>
  </div>
  <?php includejQuery(); ?>
  <script>
  var descs = [];
  jQuery(document).ready(function(){
    <?php
    foreach ($versions as $key => $arr){
      echo  'descs[' . $key . '] = "' .$arr['description']. '";';
      echo "\n";
    }
    ?>
    jQuery("#folder").change(function(){
      jQuery("#db_name").val(jQuery("#folder").val());
    });
    jQuery("#description").html(descs[jQuery("#ver").val()]);
    jQuery("#ver").change(function(){
      jQuery("#description").hide('fast');
      jQuery("#description").html(descs[jQuery(this).val()]);
      jQuery("#description").show('2300');
    });
  });
  </script>
  </body>
  </html>
  <?php
}

function http_get_file($remote_url, $local_file){
    $fp = fopen($local_file, 'w');
    $cp = curl_init($remote_url);
    curl_setopt($cp, CURLOPT_FILE, $fp);
    $buffer = curl_exec($cp);
    curl_close($cp);
    fclose($fp);
    return true;
}


function extract_zip($zip_File,$folder){
  $zip = new ZipArchive() ;
  // open archive
  if ($zip->open($zip_File) !== TRUE) {
    die ('Could not open archive');
  }
  $zip->extractTo(getcwd());
  // close archive
  // print success message
  $zip->close();
  rename(getcwd().'/wordpress', getcwd().'/'.$folder);
  return true;
}


function create_db($user,$pass,$server,$db_name){
  $link = mysql_connect($server, $user, $pass);
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  $sql = 'CREATE DATABASE '.$db_name;
  if (mysql_query($sql, $link)) {
    return true;
  } else {
    return false;
  }
}
  
function Get_latest_version_url($local = "en_US"){
  $url =  'http://api.wordpress.org/core/version-check/1.6/?locale='.$local;
  $c = curl_init($url);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  $page = curl_exec($c);
  curl_close($c);
  $ret = unserialize( $page);
/*  echo '<pre>';
  echo $local;
  var_dump($ret);
  echo '</pre>';
  die();*/
  return $ret['offers'][0]['download'];
}

/**
 * includejQuery simple function to include jQuery js
 *
 * @author Ohad Raz <admin@bainternet.info>
 * @since 0.3
 *
 * @return VOID
 */
function includejQuery(){
  ?>
  <script type="text/javascript" src="http://ajax.useso.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
  <?php
}
