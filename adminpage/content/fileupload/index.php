<?php
if (!defined('Execute') || !defined('IsAdmin')) {
    exit();
}

header("Content-Type: text/html;charset=utf-8");

$model =  array();
$id = intval(GetPostParam('Id', 0));
if ($id > 0) {
    include './config.php';
    $sth = $pdo->prepare('select Id, Images from content where Id=:Id;');
    $sth->execute(array('Id' => $id));
    $contents = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($contents as $content) {
        $model = $content;
    }
}
if (empty($model)) {
    $model['Id'] = $id;
    $model['Images'] = '';
}
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">图片上传</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" id="formFileContainer">
                <input type="hidden" id="formId" value="<?php echo $model['Id'] ?>" />
                <input type="hidden" id="formImages" value="<?php echo $model['Images'] ?>" />
                <div class="hidden imagecell">
                    <input type="hidden" class="fromuploadfilename" value="" />
                    <label class="fromuploadfilelabel">
                        <img class="fromuploadfileimg" />
                        <input type="file" class="fromuploadfilefile" />
                        <a class="fromuploadfilereset"><i class="icon-upload"></i></a>
                    </label>
                    <a class="fromuploadfiledelete"><i class="icon-remove"></i></a>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" onclick="btnSaveFileClick(this)">
                <i class="icon-ok bigger-110"></i>
                确定</button>
        </div>
    </div>
</div>