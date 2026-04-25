<?php
$extraScripts = isset($extraScripts) ? (string) $extraScripts : '';

$isLoginPageLayout = !empty($GLOBALS['isLoginPageLayout']);

if (!$isLoginPageLayout) {
	echo '</main>';
}

echo $extraScripts;
?>
</body>
</html>
