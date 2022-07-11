<?php

namespace wtf\schlosser\siemens\s7\DataType;

interface DataTypeInterface {
    public function getBitLength():BitLength;
    public function getPHPDataType():bool|int;
}

?>