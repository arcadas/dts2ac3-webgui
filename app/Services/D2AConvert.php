<?php

namespace Services;

class D2AConvert
{
    public function action($sFile)
    {
        $aFile = pathinfo($sFile);
        $sFileInP = './log/convert.inp';
        $sFileInPContent = $aFile['filename'];

        if (!file_exists($sFileInP))
        {
            error_log($sFileInPContent, 3, $sFileInP);
            @unlink('./log/convert.log');
            $sCWD = getcwd();
	    $sCWD .= '/dts2ac3.sh ' . $sFile . ' > /dev/null &';
            exec($sCWD, $output);
            $sFileNfo = './cache/' . base64_encode($aFile['basename']) . '.inf';
            if (file_exists($sFileNfo)) unlink($sFileNfo);
        }
    }

}
