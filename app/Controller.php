<?php

class Controller
{
    public function list()
    {
        return (new \Services\D2AView)->action(
            $this->getListCollection()
        );
    }

    public function scan()
    {
        $return = (new \Services\D2AScan)->action(base64_decode($_GET['file']));
        $return .= $this->list();
        return $return;
    }

    public function scanAll()
    {
        $return = (new \Services\D2AScan)->actionAll($this->getListCollection());
        $return .= $this->list();
        return $return;
    }

    public function convert()
    {
        $return = (new \Services\D2AConvert)->action(base64_decode($_GET['file']));
        $return .= $this->list();
        return $return;
    }

    private function getListCollection()
    {
        $aList = (new \Services\D2AList)->action($_GET['action']);
        return new \Services\D2ACollection($aList);
    }

}
