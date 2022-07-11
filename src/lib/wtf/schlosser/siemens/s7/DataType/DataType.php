<?php

namespace wtf\schlosser\siemens\s7\DataType;

enum DataType:string {
    // Binary
    case BOOL       = 'x';      // 0 to 1
    case BYTE       = 'b';      // 00 to FF
    case WORD       = 'w';      // 0000 to FFFF
    case DWORD      = 'dw';     // 0000 0000 to FFFF FFFF
    #case LWORD      = 'lw';

    // Intiger
    case SINT       = 'si';     // -128 to 127
    case INT        = 'i';      // -32 768 to 32 767
    case DINT       = 'di';     // -2 147 483 648 to 2 147 483 647
    case USINT      = 'usi';    // 0 to 255
    case UINT       = 'ui';     // 0 to 65 535
    case UDINT      = 'udi';    // 0 to 4 294 967 295
    #case LINT       = 'li';
    #case ULINT      = 'uli';

    // Float
    case REAL       = 'r';      // +/-1.18 x 10^-38 to +/-3.40 x 10^38
    case LREAL      = 'lr';     // +/-2.23 x 10^-308 to +/-1.79 x 10^308

    // Time
    #case S5TIME     = 's5t';
    case TIME       = 't';      // T#-24d_20h_31 m_23s_648ms to T#24d_20h_31 m_23s_647ms | Saved as: -2,147,483,648 ms to +2,147,483,647 ms

    #case LTIME      = 'lt';

    // Char
    case CHAR       = 'c';      // 00 to FF (ASCII-Charset)
    #case WCHAR      = 'wc';
    case STRING     = 's';      // 0 to 254 characters in byte size
    #case WSTRING    = 'ws';

    // Date and Time
    #case DATE       = 'd';
    #case TOD        = 'tod'; // Time of Day
    #case LTOD       = 'ltod';
    #case DT         = 'dt';
    #case LDT        = 'ldt';
    #case DTL        = 'dtl';

    // Pointer
    #case POINTER    = 'p';
    #case ANY        = 'any';
    #case VARIANT    = 'var';

    case Array      = 'Array';


    // ENUM-Function's

    function getBithLength(DataType $DataType):BitLength {
        static $BitLength = array(
            // Binary
            DataType::BOOL      => BitLength::bit1,
            DataType::BYTE      => BitLength::bit8,
            DataType::WORD      => BitLength::bit16,
            DataType::DWORD     => BitLength::bit32,
            #DataType::LWORD     => BitLength::bit64,
        
            // Intiger
            DataType::SINT      => BitLength::bit8,
            DataType::INT       => BitLength::bit16,
            DataType::DINT      => BitLength::bit32,
            DataType::USINT     => BitLength::bit8,
            DataType::UINT      => BitLength::bit16,
            DataType::UDINT     => BitLength::bit32,
            #DataType::LINT      => BitLength::bit64,
            #DataType::ULINT     => BitLength::bit64,
        
            // Float
            DataType::REAL      => BitLength::bit32,
            DataType::LREAL     => BitLength::bit64,

            // Time
            #DataType::S5TIME    => BitLength::bit16,
            DataType::TIME      => BitLength::bit32,
            #DataType::LTIME     => BitLength::bit64,

            // Char
            DataType::CHAR      => BitLength::bit8,
            #DataType::WCHAR     => BitLength::bit16,
            DataType::STRING    => BitLength::n2_Byte,
            #DataType::WSTRING   => BitLength::n2_Word,

            // Date and Time
            #DataType::DATE      => BitLength::bit16,
            #DataType::TOD       => BitLength::bit32,
            #DataType::LTOD      => BitLength::bit64,
            #DataType::DT        => BitLength::bit64,
            #DataType::LDT       => BitLength::bit64,
            #DataType::DTL       => BitLength::bit96,

            // Pointer
            #DataType::POINTER   => BitLength::bit48,
            #DataType::ANY       => BitLength::bit80,
            #DataType::VARIANT   => BitLength::bit0,
        );
        return $BitLength[$DataType];
    }
}

?>