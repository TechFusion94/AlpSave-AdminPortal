<?php

// Base URL — matches WEB_PORT in .env
define('BASEURL', 'http://localhost:4935/');

// Database credentials — match the values in .env / docker-compose
define('DB_SERVER',   'alpsave_portal_db');
define('DB_NAME',     'app_db');
define('DB_USER',     'lucam94');
define('DB_PASSWORD', 'Code123');

// Password rules
define('MIN_PW_LENGTH', 8);
define('MIN_UPPER',     1);
define('MIN_LOWER',     1);
define('MIN_DIGITS',    1);
define('MIN_SPECIAL',   1);