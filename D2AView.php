<?php

class D2AView
{
    public function action(D2ACollection $oD2ACollection)
    {
        $aList = [];

        foreach ($oD2ACollection->A as $aItem)
        {
            $sDub = $this->getDubHtml($aItem);
            $aList[] = $sDub . $aItem['parent'] . '/' . $aItem['file'] . $this->getAdditionalInfo($aItem);
        }

        return $this->getConvertInfo() .
            $this->getMenu(count($oD2ACollection->A)) .
            implode('<br>', $aList);
    }

    private function getDubHtml($aItem)
    {
        $sPath = base64_encode($aItem['path'] . '/' . $aItem['file']);

        if ($aItem['dub'][3] != '0') {
            $sHtml = '
                <span style="color: orange;">
                    [ <a href="/?action=convert&file=' . $sPath .'">CONVERT</a> ]
                </span> ';
        } elseif ($aItem['dub'][2] != '0') {
            $sHtml = '
                <span style="color: green;">
                    [ AC3 ]
                </span> ';
        } else {
            $sHtml = '
                <span style="color: grey;">
                    [ <a href="/?action=scan&file=' . $sPath .'">SCAN</a> ]
                </span> ';
        }

        return $sHtml;
    }

    private function getAdditionalInfo($aItem)
    {
        return $aItem['dub'][1] != '???' ?
            (' (<span style="color: ' . $aItem['dub'][0] . ';">' . $aItem['dub'][1] . '</span>)') :
            '';
    }

    private function getConvertInfo()
    {
        $sFileInP = './convert.inp';
        $sInfo = substr(array_pop(file('./convert.log')), -60);
        if (file_exists($sFileInP))
        {
            echo '
                <span style="color: orange">
                    <b>Convert in progress... </b>
                    ' . file_get_contents($sFileInP) . '<br>
                    ' . $sInfo . '
                </span>
                <br>';
        }
    }

    private function getMenu($iCount)
    {
        return '
            <h4>MOVIES (' . $iCount . ')</h4>
            [ <a href="/?action=list">LIST</a> ] |
            [ <a href="/?action=list_convertables">LIST CONVERTABLES</a> ] |
            [ <a href="/?action=scan_all">SCAN ALL</a> ]
            <br>
            <br>
        ';
    }

}
