<?php
namespace app\login\trt;
trait Change_taskname {
    function Change_taskname() {
        $dataT['task']=$this->ADT['appID'] ?? 'login';
        $this->ADT['view'] = \lib\html\dom\Dom_s::ChangeData($this->ADT['view'], $dataT );
    }
}