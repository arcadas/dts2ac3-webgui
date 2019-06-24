<?php

class D2AList
{
    const DIR = D2A_MEDIA;

    private $aList = [];

    public function action($sAction)
    {
        $this->listFolderFiles(self::DIR);
        ksort($this->aList);
        $this->filter($sAction);
        return $this->aList;
    }

    private function listFolderFiles($sDir)
    {
        $aFiles = scandir($sDir);

        unset($aFiles[array_search('.', $aFiles, true)]);
        unset($aFiles[array_search('..', $aFiles, true)]);

        if (count($aFiles) < 1) return;

        $sParent = @array_pop(explode('/', $sDir));
        foreach($aFiles as $sFile)
        {
            if (strpos($sFile, '.mkv') !== false &&
                strpos($sFile, 'sample') === false &&
                strpos($sFile, 'Sample') === false &&
                strpos($sFile, 'SAMPLE') === false &&
                $this->skipByConfig($sParent) &&
                !is_dir($sDir.'/'.$sFile) &&
                $sFile[0] != '.')
            {
                $sKey = $sParent . '/' . $sFile;

                $this->aList[$sKey] = [
                    'parent' => $sParent,
                    'path' => $sDir,
                    'file' => $sFile,
                    'filename' => @array_pop(explode('.', $sFile)),
                ];

                $sFileNfo = './cache/' . base64_encode($sFile) . '.inf';
                if (file_exists($sFileNfo))
                {
                    $aFileNfo = explode("\n", file_get_contents($sFileNfo), 2);
                    $this->aList[$sKey]['dub'] = explode(';', $aFileNfo[0]);
                }
                else
                {
                    $this->aList[$sKey]['dub'] = ['grey', '???', '0', '0'];
                }
            }

            if (is_dir($sDir.'/'.$sFile)) $this->listFolderFiles($sDir.'/'.$sFile);
        }
    }

    private function skipByConfig($sParent)
    {
        foreach(D2A_SKIP as $sName)
        {
            if (strpos($sParent, $sName) !== false)
            {
                return false;
            }
        }
        return true;
    }

    private function filter($sAction)
    {
        if ($sAction == 'list_convertables')
        {
            foreach ($this->aList as $sKey => $aItem)
            {
                if ($aItem['dub'][0] != 'orange')
                {
                    unset($this->aList[$sKey]);
                }
            }
        }
    }

}
