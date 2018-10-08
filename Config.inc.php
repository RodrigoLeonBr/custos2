<?php

// CONFIGRAÇÕES DO BANCO ####################
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBSA', 'sisplan');

// DEFINE SERVIDOR DE E-MAIL ################
define('MAILUSER', 'informacao@saudeamericana.com.br');
define('MAILPASS', 'senhadoemail');
define('MAILPORT', 'postadeenvio');
define('MAILHOST', 'servidordeenvio');

// DEFINE IDENTIDADE DO SITE ################
define('SITENAME', 'Planejamento - Secretaria de Saúde - Americana');
define('SITEDESC', 'Este site foi desenvolvido pela Secretaria de Saúde de Americana para ajudar no planejamento das ações em saúde.');

// DEFINE A BASE DO SITE ####################
define('HOME', 'custos2.com');
define('THEME', 'cidadeonline');

define('INCLUDE_PATH', HOME . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . THEME);
define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEME);
