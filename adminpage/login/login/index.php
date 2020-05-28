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
														<input id="inputName" value="<?php if (isDebug()) echo "admin"; ?>" type="text" class="form-control" placeholder="帐号" />
														<i class="icon-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-left">
														<input id="inputPassword" type="password" value="<?php if (isDebug()) echo "123456"; ?>" class="form-control" placeholder="密码" />
														<i class="icon-lock"></i>
													</span>
												</label>

												<label class="block clearfix">
													<img id="verifyCodeImage" class="verifyCodeImage" src="<?php ActionLink('verifycode', 'login') ?>" onclick="btnChangeVerifyCodeClick(this)" alt="刷新">
													<input type="text" id="inputVerifyCode" value="<?php if (isDebug()) echo "1234"; ?>" maxlength="4" placeholder="" style="width:80px" />
													<button type="button" id="btnLogin" onclick="btnLoginClick(this);" class="width-35 pull-right btn btn-sm btn-primary">
														<i class="icon-user"></i>
														登录
													</button>
												</label>
												<div class="space-4"></div>
											</fieldset>
										</form>
									</div><!-- /widget-main -->
								</div><!-- /widget-body -->
							</div><!-- /login-box -->
						</div><!-- /position-relative -->
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div>
	</div><!-- /.main-container -->
</body>

</html>