<?php
if (!defined('Execute')) {
  exit();
}

/**
 * 生成指定长度的流水号
 */
function GenerateNumber($index = 0, $length = 4, $pad_string = '0', $pad_type = STR_PAD_LEFT)
{
  $suffix = $index . '';
  $suffixLen = strlen($suffix);
  if ($suffixLen > $length) {
    $suffix = substr($suffix, $suffixLen - $length);
  } else {
    $suffix = str_pad($suffix, $length, $pad_string, $pad_type);
  }
  return date('YmdHis') . $suffix;
}

/**
 * 生成指定长度的随机码-字母或者数字
 */
function GenerateRandomString($length)
{
  $str = '';
  $strSource = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  for ($i = 0; $i < $length; $i++) {
    $result = rand(0, strlen($strSource) - 1);
    $str = $str . $strSource[$result];
  }
  return $str;
}

/**
 * 根据分隔符分割字符串数组
 */
function ExplodeRemoveEmptyEntries(string $separator, string $string)
{
  $str = explode($separator, $string);
  if (count($str) == 1 && $str[0] === '')
    return [];
  else
    return $str;
}
