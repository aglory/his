<?php
if (!defined('Execute')) {
  exit();
}

$loginName = '';
$password = '';

$content = file_get_contents('php://input');
if ($content && strlen($content) > 0) {
  $json_data = json_decode($content);
  if ($json_data != null && isset($json_data->LoginName))
    $loginName = $json_data->LoginName;

  if ($json_data != null && isset($json_data->Password))
    $password = $json_data->Password;
}

header('Content-Type:application/json;');
if (empty($loginName)) {
}

include './lib/pdo.php';
if (empty($pdomysql))
  $pdomysql = GetPDO();

$sth = $pdomysql->prepare("select * from Account where LoginName = :LoginName;");
$sth->execute(array('LoginName' => $loginName));
$account = $sth->fetch(PDO::FETCH_ASSOC);

if ($account !== false && $account['Password'] == md5($password)) {
  if (!$account['IsLocked']) {
    $data = array(
      'Id' => $account['Id'],
      'LoginName' => $account['LoginName'],
      'RealName' => $account['RealName'],
      'Type' => $account['Type'],
    );

    $permissions = array();
    if (!empty($account['Role'])) {
      $sth = $pdomysql->prepare("select Permission from Role where Id in ({$account['Role']});");
      $sth->execute();
      $roleList = $sth->fetchAll(PDO::FETCH_ASSOC);
      foreach ($roleList as $item) {
        if (!empty($item['Permission'])) {
          foreach (explode(',', $item['Permission']) as $permission) {
            $permissions[] = $permission;
          }
        }
      }
    }
    $data['Permission'] = implode(',', $permissions);
    $data['Token'] = md5(implode('', $data));
    $data['Permission'] = $permissions;
    echo json_encode(array('Result' => true, 'Data' =>$data));
  } else {
    echo json_encode(array('Result' => false, 'Message' => '帐号已经被冻结了'));
  }
} else {
  echo json_encode(array('Result' => false, 'Message' => '帐号错误或者密码'));
}
