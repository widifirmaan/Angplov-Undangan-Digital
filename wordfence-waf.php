<?php
// Before removing this file, please verify the PHP ini setting `auto_prepend_file` does not point to this.

// This file was the current value of auto_prepend_file during the Wordfence WAF installation (Tue, 12 Mar 2024 14:56:54 +0000)
if (file_exists('/home/u233638437/domains/angplov.my.id/public_html/wordfence-waf.php')) {
	include_once '/home/u233638437/domains/angplov.my.id/public_html/wordfence-waf.php';
}
if (file_exists(__DIR__.'/wp-content/plugins/wordfence/waf/bootstrap.php')) {
	define("WFWAF_LOG_PATH", __DIR__.'/wp-content/wflogs/');
	include_once __DIR__.'/wp-content/plugins/wordfence/waf/bootstrap.php';
}