<? 
include('sys/ini.php');


if(isset($_GET['l'])){



$url_hash = $_GET['l'];
$get_url = mysql_fetch_array(mysql_query("SELECT * FROM links WHERE hash='".$url_hash."'"));
$get_count = mysql_fetch_array(mysql_query("SELECT * FROM ip WHERE hash='".$url_hash."' and ip='".$_SERVER['REMOTE_ADDR']."'"));


if(empty($get_count['id'])){
$total = $get_url['count'] + 1;
mysql_query("UPDATE links SET count='".$total."' WHERE hash='".$get_url['hash']."'");
mysql_query("INSERT INTO ip (hash, ip, user_id)
VALUES ('".$url_hash."', '".$_SERVER['REMOTE_ADDR']."', '".$get_url['user_id']."')");
}


echo '<meta http-equiv="refresh" content="0;URL='.$get_url['url'].'">';




}else{

if(isset($_SESSION['mail'])){
$logon = 1;

if(isset($_GET['remove'])){
if(is_numeric($_GET['remove'])){
mysql_query("DELETE FROM links WHERE user_id = '".$user_info['id']."' and id='".$_GET['remove']."'");
}
}


}else{
$logon = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>URL Killer</title>

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="css/jumbotron.css" rel="stylesheet">
	
	
	 <script language='JavaScript' type='text/JavaScript'>
	function check(){
	var mail_a;
	var pass_a;
	var loading_a;
	mail_a = document.getElementById('u_mail').value;
	pass_a = document.getElementById('u_pass').value;
	loading_a = '<font size=3><div class="alert alert-warning">Please wait...</div></font>';
	get('sign=1&mail=' + mail_a + '&pass=' + pass_a,'notify',loading_a,'notify','sys/info.php','POST');
    };
	
	function signout(){
	get('dest=1','notify',' ','notify','sys/info.php','POST');
    };
	
	function createurl(){
	var target_url = document.getElementById('url').value;
	var old_text;
	    old_text = document.getElementById('gettab').innerHTML;
	get('createurl=' + target_url,'gettab',old_text,'gettab','sys/info.php','POST');
	
	target_url = '';
	old_text = '';
	document.getElementById('url').value = '';
    };
	
					function runScript(e) {
    if (e.keyCode == 13) {
        check();
        return false;
    }
}

					function runScript3(e) {
    if (e.keyCode == 13) {
        createurl();
        return false;
    }
}
</script>
	
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
         <a class="navbar-brand" href="#">URL Killer</a>
        </div>
		
		<? if($logon == 0){ ?>
		<div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form">
		    <div class="form-group">
              <input type="text" onkeypress="return runScript(event)" value="test@test.com" id="u_mail" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" onkeypress="return runScript(event)" value="testpassw" id="u_pass" placeholder="Password" class="form-control">
            </div>
			<button type="submit" onclick="check();" class="btn btn-success">Sign in</button>
       	</form>
		</div>
		 <? }else{ ?> 
		  <div class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" role="form">
		      <div class="form-group">
              <? echo '<font color="white">Hello, '.$user_info['mail'].'</font>';  ?>
            </div>
			<button type="submit" onclick="signout();" class="btn btn-success">Sign out</button>
       	</form>
		</div>
		 <? } ?>
      </div>
    </div>
	

    <div class="jumbotron">
      <div class="container">
	   <h1>Welcome to URL Killer</h1>
	   <p>Please try script...</p>
       <div id="notify"></div>
	   <hr>
        <p><b>E-mail:</b> test@test.com</p>
        <p><b>Password:</b> testpassw</p>
      </div>
    </div>

   <div class="container">
 
  
  <? if($logon == 1){?> 
 
   <input class="form-control" onkeypress="return runScript3(event)" id="url" value="https://www.youtube.com/watch?v=3_2cAbijZVc"  placeholder="www. your website address">
   <br>
   <button type="button"  onclick="createurl();" class="btn btn-primary btn-lg btn-block">Kill Him!</button> 
  <br>
  
<div class="panel panel-default">

 <div class="panel-heading">Your short links</div>

 
    <div id="gettab">
	
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
</div>
</div>
<? } ?>

      <hr>


      <footer>
        <p>&copy; URL Killer 2014</p>
      </footer>
    </div> 
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="sys/core.js"></script>
  </body>
</html>
<? } ?>