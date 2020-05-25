<?php
if (!defined('Execute') || !defined('IsAdmin')) {
	exit();
}
header('Content-type: application/json');

include './config.php';
$matchType = GetPostParam('MatchType', 1);
$sqlTableName = '`content`';
$sqlWhereClause = array();
$sqlWhereParams  = array();
$type = intval(GetPostParam('Type', 0));
$sqlWhereClause[] = "`Type` = $type";
$title = GetPostParam('Title', '');
if (!empty($title)) {
	$p = BuildSafeSqlMatchType($matchType, 'Title', $title);
	$sqlWhereClause[] = $p[0];
	$sqlWhereParams['Title'] = $p[1];
}
$status = intval(GetPostParam('Status', ''));
if (in_array($status, array_keys(EnumContentStatus))) {
	$sqlWhereClause[] = 'Status = :Status';
	$sqlWhereParams['Status'] = $status;
}
$sqlTable = "select * from $sqlTableName";
$sqlStatistics = "select count(1) RecordCount from $sqlTableName";
if (!empty($sqlWhereClause)) {
	$sqlTable .= " where ";
	$sqlTable .= implode(" and ", $sqlWhereClause);
	$sqlStatistics .= " where ";
	$sqlStatistics .= implode(" and ", $sqlWhereClause);
}
$pageOrderBy = GetPostParam('PageOrderBy', '');
if (empty($pageOrderBy)) {
	$pageOrderBy = 'Index desc';
}
$pageOrderBy = BuildSafeSqlOrderBy($pdo, $sqlTableName, $pageOrderBy);
if (!empty($pageOrderBy)) {
	$sqlTable .= " order by $pageOrderBy";
}
$pageIndex = intval(GetPostParam('PageIndex', 1));
$pageSize = intval(GetPostParam('PageSize', 20));
$pageStart = ($pageIndex - 1) * $pageSize;
$pageEnd = $pageStart + $pageSize;
$sqlTable .= " limit $pageStart, $pageEnd";
$sthTable = $pdo->prepare($sqlTable);
$sthTable->execute($sqlWhereParams);
$sthTableError = $sthTable->errorInfo();
if (!empty($sthTableError[2])) {
	die(json_encode(array('Success' => false, 'Error' => $sthTableError[2])));
}

$contents = $sthTable->fetchAll(PDO::FETCH_ASSOC);

$html = '';
foreach ($contents as $content) {
	$changeStatus = 3 - $content['Status'];
	$html .= '<tr>
	<td>' . htmlspecialchars($content['Title']) . '</td>
	<td class="text-center">' . date_format(date_create($content['CreateDate']), 'Y-m-d H:i:s') . '	</td>
	<td class="text-right">' . $content['Index'] . '</td>
	<td class="text-right">' . $content['ViewCount'] . '</td>
	<td class="text-center"><span class="status' . ($content['Status']) . '">已' . (EnumContentStatus[$content['Status']]) . '<span></td>
	<td class="text-center">'
		.	' <a class="btn ' . ($content['Status'] == 2 ? 'btn-success' : 'btn-danger') . ' btn-xs" href="javascript:void(0)" onclick="btnChangeStatusClick(this,' . $content['Id'] . ',' . $changeStatus . ')">' . (EnumContentStatus[$changeStatus]) . '</a>'
		.	' <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="btnEditorClick(this,' . $content['Id'] . ')">编辑</a>'
		.	' <a class="btn btn-info btn-xs" href="javascript:void(0)" onclick="btnFileUploadClick(this,' . $content['Id'] . ')">图片</a>'
		. '</td>
	</tr>';
}
$sthStatistics = $pdo->prepare($sqlStatistics);
$sthStatistics->execute($sqlWhereParams);
$statistics = $sthStatistics->fetchAll(PDO::FETCH_ASSOC);
die(json_encode(array('Success' => true, 'Value' => $html, 'Tag' => $statistics[0]['RecordCount'])));
