<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>登录页面</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- basic styles -->

	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/font-awesome.min.css" />

	<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

	<!-- page specific plugin styles -->

	<!-- fonts -->

	<!-- ace styles -->

	<link rel="stylesheet" href="assets/css/ace.min.css" />
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

	<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

	<!-- inline styles related to this page -->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

	<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->

	<link rel="stylesheet" href="assets/css/adminbase.css" />
	<link rel="stylesheet" href="/<?php echo SOURCE_DIR ?>/login/login/index.css" />
	<script src="assets/js/adminbase.js"></script>
	<script src="/<?php echo SOURCE_DIR ?>/login/login/index.js"></script>
	<link rel="shortcut icon" href="assets/image/favicon.ico" type="image/x-icon" />
	<link rel="Bookmark" href="assets/image/favicon.ico" />
</head>

<body class="login-layout">
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
						<div class="center">
							<h1>
								<img id="log" src="/assets/image/log.png" />
							</h1>
							<h4 class="blue">&copy; 叁伍伍叁健康科学研究院</h4>
						</div>

						<div class="space-6"></div>

						<div id="divlogin" class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header blue lighter bigger">
											<i class="icon-coffee green"></i>
											请输入帐号和密码登录
										</h4>

										<div class="space-6"></div>

										<form>
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-left">
														<input id="inputName" value="<?php if ($_SERVER['REMOTE_HOST'] = "127.0.0.1") echo "admin"; ?>" type="text" class="form-control" placeholder="帐号" />
														<i class="icon-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-left">
														<input id="inputPassword" type="password" value="<?php if ($_SERVER['REMOTE_HOST'] = "127.0.0.1") echo "123456"; ?>" class="form-control" placeholder="密码" />
														<i class="icon-lock"></i>
													</span>
												</label>
												<div class="space"></div>

												<label class="block clearfix">
													<img id="verifyCodeImage" class="verifyCodeImage" src="<?php ActionLink('verifycode', 'login') ?>" onclick="btnChangeVerifyCodeClick(this)" alt="刷新">
													<input type="text" id="inputVerifyCode" value="<?php if ($_SERVER['REMOTE_HOST'] = "127.0.0.1") echo "1234"; ?>" maxlength="4" placeholder="">
													<button type="button" id="btnLogin" onclick="btnLoginClick(this);" class="width-35 pull-right btn btn-sm btn-primary">
														<i class="icon-user"></i>
														登录
													</button>
												</label>

												<div class="space-4"></div>
											</fieldset>
										</form>
									</div><!-- /widget-main -->

									<div class="toolbar clearfix">
										<div>
											<a href="#" class="forgot-password-link">
												<i class="icon-arrow-left"></i>
											</a>
										</div>

										<div>
											<a href="#" class="user-signup-link">
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div>
								</div><!-- /widget-body -->
							</div><!-- /login-box -->

							<div id="forgot-box" class="forgot-box widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header red lighter bigger">
											<i class="icon-key"></i>
											Retrieve Password
										</h4>

										<div class="space-6"></div>
										<p>
											Enter your email and to receive instructions
										</p>

										<form>
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="email" class="form-control" placeholder="Email" />
														<i class="icon-envelope"></i>
													</span>
												</label>

												<div class="clearfix">
													<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
														<i class="icon-lightbulb"></i>
														Send Me!
													</button>
												</div>
											</fieldset>
										</form>
									</div><!-- /widget-main -->

									<div class="toolbar center">
										<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
											Back to login
											<i class="icon-arrow-right"></i>
										</a>
									</div>
								</div><!-- /widget-body -->
							</div><!-- /forgot-box -->

							<div id="signup-box" class="signup-box widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header green lighter bigger">
											<i class="icon-group blue"></i>
											New User Registration
										</h4>

										<div class="space-6"></div>
										<p> Enter your details to begin: </p>

										<form>
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="email" class="form-control" placeholder="Email" />
														<i class="icon-envelope"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="text" class="form-control" placeholder="Username" />
														<i class="icon-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" class="form-control" placeholder="Password" />
														<i class="icon-lock"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" class="form-control" placeholder="Repeat password" />
														<i class="icon-retweet"></i>
													</span>
												</label>

												<label class="block">
													<input type="checkbox" class="ace" />
													<span class="lbl">
														I accept the
														<a href="#">User Agreement</a>
													</span>
												</label>

												<div class="space-24"></div>

												<div class="clearfix">
													<button type="reset" class="width-30 pull-left btn btn-sm">
														<i class="icon-refresh"></i>
														Reset
													</button>

													<button type="button" class="width-65 pull-right btn btn-sm btn-success">
														Register
														<i class="icon-arrow-right icon-on-right"></i>
													</button>
												</div>
											</fieldset>
										</form>
									</div>

									<div class="toolbar center">
										<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
											<i class="icon-arrow-left"></i>
											Back to login
										</a>
									</div>
								</div><!-- /widget-body -->
							</div><!-- /signup-box -->
						</div><!-- /position-relative -->
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div>
	</div><!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->

	<script src="/assets/js/jquery-2.0.3.min.js"></script>

	<!-- <![endif]-->

	<!--[if IE]>
<script src="/assets/js/jquery-1.11.2.js"></script>
<![endif]-->

	<!--[if !IE]> -->

	<script type="text/javascript">
		window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
	</script>

	<!-- <![endif]-->

	<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

	<script type="text/javascript">
		if ("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
	</script>

	<!-- inline scripts related to this page -->

	<script type="text/javascript">
		function show_box(id) {
			jQuery('.widget-box.visible').removeClass('visible');
			jQuery('#' + id).addClass('visible');
		}
	</script>
</body>

</html>