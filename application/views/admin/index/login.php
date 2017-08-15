<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?= $title?></title>

	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Roboto:300);
		.login-page {
		  width: 360px;
		  padding: 8% 0 0;
		  margin: auto;
		}
		.form {
		  position: relative;
		  z-index: 1;
		  background: #FFFFFF;
		  max-width: 360px;
		  margin: 0 auto 100px;
		  padding: 45px;
		  text-align: center;
		  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
		}
		.form input {
		  font-family: "Roboto", sans-serif;
		  outline: 0;
		  background: #f2f2f2;
		  width: 100%;
		  border: 0;
		  margin: 0 0 15px;
		  padding: 15px;
		  box-sizing: border-box;
		  font-size: 14px;
		}
		.form button {
		  font-family: "Roboto", sans-serif;
		  text-transform: uppercase;
		  outline: 0;
		  background: #95a5a6;
		  width: 100%;
		  border: 0;
		  padding: 15px;
		  color: #FFFFFF;
		  font-size: 14px;
		  -webkit-transition: all 0.3 ease;
		  transition: all 0.3 ease;
		  cursor: pointer;
		}
		.form button:hover,.form button:active,.form button:focus {
		  background: #7f8c8d;
		}
		.form .message {
		  margin: 15px 0 0;
		  color: #b3b3b3;
		  font-size: 12px;
		}
		.form .message a {
		  color: #95a5a6;
		  text-decoration: none;
		}
		.container {
		  position: relative;
		  z-index: 1;
		  max-width: 300px;
		  margin: 0 auto;
		}
		.container:before, .container:after {
		  content: "";
		  display: block;
		  clear: both;
		}
		body {
		  background: #95a5a6; /* fallback for old browsers */
		  background: -webkit-linear-gradient(right, #95a5a6, #7f8c8d);
		  background: -moz-linear-gradient(right, #95a5a6, #7f8c8d);
		  background: -o-linear-gradient(right, #95a5a6, #7f8c8d);
		  background: linear-gradient(to left, #95a5a6, #7f8c8d);
		  font-family: "Roboto", sans-serif;
		  -webkit-font-smoothing: antialiased;
		  -moz-osx-font-smoothing: grayscale;      
		}
	</style>
</head>
<body>
	<div class="login-page">
	  <div class="form">
	    <form class="login-form" method="post">
	    <!-- <img src="./uploads/Logo_MissPhoto.png" style="max-width: 200px;"> -->
	      <input type="text" name="username" value="<?= $formData['username']?>" required="required" placeholder="username"/>
	      <input type="password" name="password" value="<?= $formData['password']?>" required="required" placeholder="password"/>
	      <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
	      <button type="submit" name="flogin">login</button>
	      <p class="message">Đơn vị thực hiện <a target="_blank" href="http://itsgroup.vn/">ITSGroup</a></p>
	      <?php if (isset($error) && $error != ''): ?>
	      	<p class="message" style="color: #c0392b;"><?= $error?></p>
	      <?php endif ?>
	    </form>
	  </div>
	</div>
</body>
</html>