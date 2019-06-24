<?php

require_once 'config.php';
require_once 'D2ACollection.php';
require_once 'D2AList.php';
require_once 'D2AScan.php';
require_once 'D2AConvert.php';
require_once 'D2AView.php';

$aList = (new D2AList)->action($_GET['action']);
$oD2ACollection = new D2ACollection($aList);
//var_dump($oD2ACollection); die();

switch ($_GET['action'])
{
    case 'scan': (new D2AScan)->action(base64_decode($_GET['file']));
        break;
    case 'scan_all': (new D2AScan)->actionAll($oD2ACollection);
        break;
    case 'convert': (new D2AConvert)->action(base64_decode($_GET['file']));
        break;
}

echo (new D2AView)->action($oD2ACollection);
