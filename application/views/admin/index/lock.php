<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?= $title?></title>
  	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>

	<style type="text/css">
		/* Form */
		.form {
		  position: relative;
		  z-index: 1;
		  background: #FFFFFF;
		  max-width: 300px;
		  margin: 0 auto 100px;
		  padding: 30px;
		  border-top-left-radius: 3px;
		  border-top-right-radius: 3px;
		  border-bottom-left-radius: 3px;
		  border-bottom-right-radius: 3px;
		  text-align: center;
		}
		.form input {
		  outline: 0;
		  background: #f2f2f2;
		  width: 100%;
		  border: 0;
		  margin: 0 0 15px;
		  padding: 15px;
		  border-top-left-radius: 3px;
		  border-top-right-radius: 3px;
		  border-bottom-left-radius: 3px;
		  border-bottom-right-radius: 3px;
		  box-sizing: border-box;
		  font-size: 14px;
		}
		.form button {
		  outline: 0;
		  background: #EF3B3A;
		  width: 100%;
		  border: 0;
		  padding: 15px;
		  border-top-left-radius: 3px;
		  border-top-right-radius: 3px;
		  border-bottom-left-radius: 3px;
		  border-bottom-right-radius: 3px;
		  color: #FFFFFF;
		  font-size: 14px;
		  -webkit-transition: all 0.3 ease;
		  transition: all 0.3 ease;
		  cursor: pointer;
		}
		.form .message {
		  margin: 15px 0 0;
		  color: #b3b3b3;
		  font-size: 12px;
		}
		.form .message a {
		  color: #EF3B3A;
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
		.container .info {
		  margin: 50px auto;
		  text-align: center;
		}
		.container .info h1 {
		  margin: 0 0 15px;
		  padding: 0;
		  font-size: 36px;
		  font-weight: 300;
		  color: #1a1a1a;
		}
		body {
		  background: #ccc;
		  font-family: "Roboto", sans-serif;
		  -webkit-font-smoothing: antialiased;
		  -moz-osx-font-smoothing: grayscale;
		}
		body:before {
		  content: "";
		  position: fixed;
		  top: 0;
		  left: 0;
		  display: block;
		  background: rgba(255, 255, 255, 0.8);
		  width: 100%;
		  height: 100%;
		}
	</style>
</head>
<body>  
<div class="container">
  <div class="info">
    <h1><?= $title?></h1>
    <h2><?= $user_active['active_user_fullname']?></h2>
  </div>
</div>
<div class="form">
  <img src="<?= $user_active['active_user_avatar']?>" style="width: 100px;margin: 10px;border: 1px solid red;border-radius: 300px;-webkit-border-radius: 300px;-moz-border-radius: 300px;"/>
  <form class="lock-form" method="post">
  	<input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
    <input type="password"  name="password" placeholder="Nhập mật khẩu"/>
    <?php if (isset($error)): ?>
    	<cite style="color: red;text-align: center;"><?= $error?></cite>
    <?php endif ?>
    <button>MỞ KHÓA</button>
    <p class="message">Đăng nhập bằng <a href="<?= my_library::admin_site()?>index/logout">tài khoản khác!</a></p>
  </form>
</div>
</body>
</html>