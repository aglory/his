<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

Render('header');
?>
<div id="manangertoolbar" class="col-xs-12">
	<div class="col-xs-10 text-left">
		<button class="btn btn-info btn-sm" type="button">新增</button>
		<input class="input-sm" type="text" />
		<select class="input-sm">
			<option>-</option>
		</select>
	</div>
	<div class="col-xs-2 text-right">
		<button class="btn btn-success btn-sm" type="button">查询</button>
	</div>
</div>
<div id="manangerbody" class="col-xs-12 manangerbody">
	<table class="table table-striped table-bordered table-hover">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					标题
				</th>
				<th>
					日期
				</th>
				<th>
					排序
				</th>
				<th>
					状态
				</th>
				<th class="text-center">
					操作
				</th>
			</tr>
		</thead>
		<tbody id="manangercontent">
		</tbody>
	</table>
</div>
<?php
Render('footer');
?>