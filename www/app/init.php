<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\SantaController;
use App\Services\EmailSender;

$app = new SantaController(new EmailSender());
$app->run();
