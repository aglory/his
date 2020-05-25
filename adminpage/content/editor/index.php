<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}

header("Content-Type: text/html;charset=utf-8");

$model =  array();
$id = intval(GetPostParam('Id', 0));
$type = intval(GetPostParam('Type', 0));
if ($id > 0) {
    include './config.php';
    $sth = $pdo->prepare('select * from `content` where Id=:Id;');
    $sth->execute(array('Id' => $id));
    $contents = $sth->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($contents))
        $model = $contents[0];
}
if (empty($model)) {
    $model['Id'] = $id;
    $model['Type'] = $type;
    $model['Index'] = 0;
    $model['Title'] = '';
    $model['Content'] = '';
    $model['CreateDate'] = date_format(date_create(), "Y-m-d H:i:s");;
}
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">编辑<?php echo EnumContentTyp[$type] ?></h4>
        </div>
        <div class="modal-body">
            <input type="hidden" id="formId" value="<?php echo $model['Id'] ?>" />
            <input type="hidden" id="formType" value="<?php echo $model['Type'] ?>" />
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="formTitle">标题</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="formTitle" placeholder="请输入标题" value="<?php echo $model['Title'] ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="formIndex">排序</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="formIndex" placeholder="请输入排序" value="<?php echo $model['Index'] ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="formContent">内容</label>
                    <div class="col-sm-9">
                        <textarea class="autosize-transition form-control" id="formContent" placeholder="请输入内容" rows="20"><?php echo $model['Content'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="formCreateDate">时间</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" id="formCreateDate" onfocus="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" placeholder="请输入时间" value="<?php echo $model['CreateDate'] ?>" />
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" onclick="btnSaveClick(this)">
                <i class="icon-ok bigger-110"></i>
                确定</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->