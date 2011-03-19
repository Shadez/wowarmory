<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>World of Warcraft Armory : Login to administration panel</title>
<link href="template/css/960.css" rel="stylesheet" type="text/css" media="all" />
<link href="template/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="template/css/text.css" rel="stylesheet" type="text/css" media="all" />
<link href="template/css/login.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
function SubmitLoginForm() {
    document.loginForm.submit();
}
</script>
</head>

<body>
<div class="container_16">
  <div class="grid_6 prefix_5 suffix_5">
   	  <h1>Login to administration panel</h1>
    	<div id="login">
    	  <p class="tip">You just need to hit the button and you're in!</p>
          <?php
          if(!Admin::IsLoggedIn()) {
            echo '<p class="error">Authentication required!</p>';
          }
          ?>     
    	  <form id="loginForm" name="loginForm" method="post" action="">
    	    <p>
    	      <label><strong>Username</strong>
<input type="text" name="username" class="inputText" id="textfield" />
    	      </label>
  	      </p>
    	    <p>
    	      <label><strong>Password</strong>
  <input type="password" name="password" class="inputText" id="textfield2" />
  	        </label>
    	    </p>
    		<a class="black_button" onclick="javascript:SubmitLoginForm();"><span>Authentification</span></a>
    	  </form>
		  <br clear="all" />
    	</div>
  </div>
</div>
<br clear="all" />
</body>
</html>