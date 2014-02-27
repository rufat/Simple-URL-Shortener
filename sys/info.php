<?
include('ini.php');

//Auth
if(isset($_POST['sign'])){
$mail = htmlspecialchars($_POST['mail']);
$pass = htmlspecialchars($_POST['pass']);

echo '<p>Wrong login and pass!</p>';
echo $mail.' '.$pass;

//email filter
if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

//check user
$user_info2 = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE mail='".$mail."' and password='".$pass."'"));
if(isset($user_info2['id'])){
$_SESSION['mail'] = $mail;
$_SESSION['pass'] = $pass;
echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
}
}

//session destroy POST
if(isset($_POST['dest'])){
session_destroy();
echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}

//Let's create a short URL address
if(isset($_POST['createurl']) and isset($_SESSION['mail'])){
$url = htmlspecialchars($_POST['createurl']);

$geturls2 = mysql_query("SELECT * FROM links WHERE user_id='".$user_info['id']."' AND url='".$url."'");
$getcu2 = mysql_fetch_array($geturls2);
if(!isset($getcu2['hash'])){

if (preg_match("/\b(?:(?:https?|http?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url))
  {
  $newurl = substr(sha1($url), 0, -35);
mysql_query("INSERT INTO links (hash, url, user_id, user)
VALUES ('".$newurl."', '".$url."', '".$user_info['id']."', '".$user_info['mail']."')");
  }
  
}?>

  <table class="table">
<thead>
          <tr>
            <th>#</th>
            <th>shortlink</th>
            <th>url</th>
            <th>count</th>
            <th>user</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
		
		<?
	    $num = 0;
	    $geturls = mysql_query("SELECT * FROM links WHERE user_id='".$user_info['id']."'");
		while($urls = mysql_fetch_array($geturls)){
		?>
          <tr>
            <td><? echo $num = $num + 1; ?></td>
            <td><a href="<? echo '?l='.$urls['hash']; ?>" target="_blank"><? echo 'http://'.$_SERVER['HTTP_HOST'].'/?l='.$urls['hash']; ?></a></td>
            <td><a href="<? echo $urls['url']; ?>" target="_blank"><? echo $urls['url']; ?></a></td>
            <td><? echo $urls['count']; ?></td>
            <td><? echo $urls['user']; ?></td>
            <td><a href="index.php?remove=<? echo $urls['id']; ?>" type="button" class="btn btn-danger">Remove</a></td>
          </tr>
		<?}?>  
		  
        </tbody>
  </table>
  
  
<? } ?>