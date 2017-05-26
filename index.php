<?php
/**
 * Created by PhpStorm.
 * User: jesusslim
 * Date: 2017/5/26
 * Time: 上午10:44
 */

require "Lib/vendor/autoload.php";
require "Src/MobileLocation.php";

$inj = new \Inject\Injector();
$map = [
    'mobile' => \MobileLocation\Src\MobileLocation::class,
    'hello' => function(){return 'world';}
];
$server = new \gwyn\src\Server($inj,$map);
$server->run();