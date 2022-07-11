<?php

namespace wtf\schlosser\siemens\s7\DataType;

enum BitLength:int {
    case bit0 = 0;
    case bit1 = 1;
    case bit8 = 8;
    case bit16 = 16;
    case bit32 = 32;
    case bit48 = 48;
    case bit64 = 64;
    case bit80 = 80;
    case bit96 = 96;
    case n2_Byte = 254;
    case n2_Word = 16382;
}