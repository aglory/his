<?php

function classLoader($class)
{
  $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
  // 所以的枚举放在了Enum.php中
  $pos = stripos($path, '\Enum');
  if ($pos !== false) {
    $path = substr($path, 0, $pos + strlen('\Enum'));
  }
  $file = __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . $path . '.php';
  if (file_exists($file)) {
    require_once $file;
  }
}
spl_autoload_register('classLoader');
