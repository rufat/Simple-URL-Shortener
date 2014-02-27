<?
session_start();
//Enter your DB infos
$host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

if(!@mysql_connect($host,$db_name,$db_pass)){
echo 'c problem';
}

if(!@mysql_select_db($db_user)){
echo 's problem';
}

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_bin'");

if(isset($_SESSION['mail']) and isset($_SESSION['pass'])){
$user_info = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE mail='".$_SESSION['mail']."' and password='".$_SESSION['pass']."'"));
}
?>