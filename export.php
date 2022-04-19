<?php
require_once "vendor/autoload.php";

$export = new \Joeriabbo\OrmMigrationsStandalone\Core\Export();

$export->generate();