<?php

class D2AConvert
{
    public function action($sFile)
    {
        $aFile = pathinfo($sFile);
        $sFileInP = './convert.inp';
        $sFileInPContent = $aFile['filename'];

        if (!file_exists($sFileInP))
        {
            error_log($sFileInPContent, 3, $sFileInP);
            unlink('convert.log');
            $sCWD = getcwd();
            exec($sCWD . '/dts2ac3.sh ' . $sFile . ' > /dev/null &', $output);
            $sFileNfo = './cache/' . base64_encode($aFile['basename']) . '.inf';
            if (file_exists($sFileNfo)) unlink($sFileNfo);
        }
    }

}
