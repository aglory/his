<?php
if (!defined('Execute')) {
  exit();
}

function GetPDO()
{
  return new PDO(
    PDO_DNS,
    PDO_USER,
    PDO_PASSWORD,
    array(PDO::MYSQL_ATTR_FOUND_ROWS => true, PDO::ATTR_STRINGIFY_FETCHES => false, PDO::ATTR_EMULATE_PREPARES => false)
  );
}
