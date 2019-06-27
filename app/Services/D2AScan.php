<?php

namespace Services;

class D2AScan
{
    const DIR = D2A_MEDIA;

    public function action($sFile)
    {
        $this->scan($sFile);
    }

    public function actionAll(D2ACollection $oD2ACollection)
    {
        set_time_limit(0);

        foreach ($oD2ACollection->A as $aItem)
        {
            if ($aItem['dub'][1] == '???')
            {
                $this->scan($aItem['path'] . '/' . $aItem['file'], true);
            }
        }
    }

    private function scan($sFile, $bSilent = false)
    {
        $aFile = pathinfo($sFile);
        $sFileInP = './cache/' . base64_encode($aFile['basename']) . '.inp';
        $sFileNfo = './cache/' . base64_encode($aFile['basename']) . '.inf';

        if (!file_exists($sFileInP))
        {
            $bSilent ?: touch($sFileInP);
            if (file_exists($sFileNfo)) unlink($sFileNfo);

            $sCmdDts = 'ffmpeg -i "' . $sFile . '" 2>&1 | grep Audio | cut -c30- | cut -c-3 | grep dts | wc -l';
            $sResultDts = exec($sCmdDts);
            $sCmdAc3 = 'ffmpeg -i "' . $sFile . '" 2>&1 | grep Audio | cut -c30- | cut -c-3 | grep ac3 | wc -l';
            $sResultAc3 = exec($sCmdAc3);
            $sCmdAc3 = 'ffmpeg -i "' . $sFile . '" 2>&1 | grep Audio | cut -c30- | cut -c-3 | grep eac | wc -l';
            $sResultEAc3 = exec($sCmdAc3);
            $sResultAc3 = $sResultAc3 + $sResultEAc3;

            if ($sResultDts == '0' && $sResultAc3 == '0')
            {
                $sColor = 'red';
                $sMsg = 'Error';
            }
            if ($sResultDts != '0' && $sResultAc3 == '0')
            {
                $sColor = 'orange';
                $sMsg = 'DTS only (' . $sResultDts . ')';
            }
            if ($sResultDts != '0' && $sResultAc3 != '0')
            {
                $sColor = 'orange';
                $sMsg = 'DTS and AC3';
            }
            if ($sResultDts == '0' && $sResultAc3 != '0')
            {
                $sColor = 'green';
                $sMsg = 'AC3 only (' . $sResultAc3 . ')';
            }

            error_log($sColor . ';' . $sMsg . ';' . $sResultAc3 . ';' . $sResultDts . "\n", 3, $sFileNfo);
            error_log($sFile, 3, $sFileNfo);

            $bSilent ?: unlink($sFileInP);

            if (!$bSilent)
            {
                echo '
                    <span style="color: ' . $sColor . '">
                        <b>Scan result: </b>' . $sMsg . '<br>
                        ' . $sFile . '
                    </span>
                    <br>';
            }
        }
        else
        {
            echo '
                <span style="color: orange">
                    <b>Scan in progress... </b>
                    ' . $aFile['basename'] . '
                </span>
                <br>';
        }
    }

}
