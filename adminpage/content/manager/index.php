<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}

Render('header');
?>
<link href="/<?php echo SOURCE_DIR ?>/content/manager/index.css" rel="stylesheet" />
<script src="/<?php echo SOURCE_DIR ?>/content/manager/index.js"></script>
<div id="manangertoolbar" class="col-xs-12">
	<input type="hidden" id="hdfPageIndex" value="1" />
	<input type="hidden" id="hdfPageSize" value="20" />
	<input type="hidden" id="hdfPageOrderBy" value="" />
	<input type="hidden" id="hdfType" value="<?php echo intval(GetGetParam('Type', 0)) ?>" />
	<div class="col-xs-10 text-left">
		<a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="btnEditorClick(this,0)">新增</a>
		<select class="input-sm" id="ddlMatchType">
			<option value="1">精确匹配</option>
			<option value="2">匹配开始</option>
			<option value="3">匹配结束</option>
			<option value="4">模糊匹配</option>
		</select>
		<select class="input-sm" id="ddlStatus">
			<option value="0">状态查询</option>
			<?php
			foreach (EnumContentStatus as $key => $val) {
				echo "<option value=\"$key\">$val</option>";
			}
			?>
		</select>
		<input class="input-sm" type="text" id="txtTitle" placeholder="标题查询" />
	</div>
	<div class="col-xs-2 text-right">
		<button class="btn btn-success btn-sm btnquery" type="button">查询</button>
	</div>
</div>
<div id="manangerbody" class="col-xs-12 manangerbody">
	<table class="table table-striped table-bordered table-hover mainTable-head">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					<span class="column-sort">
						<a class="sort-up"><i class="icon-sort-up"></i></a>
						<a class="sort-down"><i class="icon-sort-down"></i></a>
					</span>
					<a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="Title">标题</a>
				</th>
				<th>
					<span class="column-sort">
						<a class="sort-up"><i class="icon-sort-up"></i></a>
						<a class="sort-down"><i class="icon-sort-down"></i></a>
					</span>
					<a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="CreateDate">日期</a>
				</th>
				<th>
					<span class="column-sort">
						<a class="sort-up"><i class="icon-sort-up"></i></a>
						<a class="sort-down"><i class="icon-sort-down"></i></a>
					</span>
					<a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="Index">排序</a>
				</th>
				<th>
					<span class="column-sort">
						<a class="sort-up"><i class="icon-sort-up"></i></a>
						<a class="sort-down"><i class="icon-sort-down"></i></a>
					</span>
					<a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="ViewCount">观看次数</a>
				</th>
				<th>
					<span class="column-sort">
						<a class="sort-up"><i class="icon-sort-up"></i></a>
						<a class="sort-down"><i class="icon-sort-down"></i></a>
					</span>
					<a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="Status">状态</a>
				</th>
				<th>
					操作
				</th>
			</tr>
		</thead>
		<tbody id="manangercontent">
		</tbody>
		<tfoot>
			<tr>
				<td colspan="100">
					<div id="manangerpage" class="page">
					</div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
<?php
Render('footer');
?>