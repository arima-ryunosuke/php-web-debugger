<?php

# Don't touch this code. This is auto generated.

namespace ryunosuke\WebDebugger;

# constants
if (!defined("ryunosuke\\WebDebugger\\KEYWORDS")) {
    /** SQL キーワード（全 RDBMS ごちゃまぜ） */
    define("ryunosuke\\WebDebugger\\KEYWORDS", [
        ""  => "",
        0   => "ACCESSIBLE",
        1   => "ACTION",
        2   => "ADD",
        3   => "AFTER",
        4   => "AGAINST",
        5   => "AGGREGATE",
        6   => "ALGORITHM",
        7   => "ALL",
        8   => "ALTER",
        9   => "ALTER TABLE",
        10  => "ANALYSE",
        11  => "ANALYZE",
        12  => "AND",
        13  => "AS",
        14  => "ASC",
        15  => "AUTOCOMMIT",
        16  => "AUTO_INCREMENT",
        17  => "BACKUP",
        18  => "BEGIN",
        19  => "BETWEEN",
        20  => "BINLOG",
        21  => "BOTH",
        22  => "CASCADE",
        23  => "CASE",
        24  => "CHANGE",
        25  => "CHANGED",
        26  => "CHARACTER SET",
        27  => "CHARSET",
        28  => "CHECK",
        29  => "CHECKSUM",
        30  => "COLLATE",
        31  => "COLLATION",
        32  => "COLUMN",
        33  => "COLUMNS",
        34  => "COMMENT",
        35  => "COMMIT",
        36  => "COMMITTED",
        37  => "COMPRESSED",
        38  => "CONCURRENT",
        39  => "CONSTRAINT",
        40  => "CONTAINS",
        41  => "CONVERT",
        42  => "CREATE",
        43  => "CROSS",
        44  => "CURRENT_TIMESTAMP",
        45  => "DATABASE",
        46  => "DATABASES",
        47  => "DAY",
        48  => "DAY_HOUR",
        49  => "DAY_MINUTE",
        50  => "DAY_SECOND",
        51  => "DEFAULT",
        52  => "DEFINER",
        53  => "DELAYED",
        54  => "DELETE",
        55  => "DELETE FROM",
        56  => "DESC",
        57  => "DESCRIBE",
        58  => "DETERMINISTIC",
        59  => "DISTINCT",
        60  => "DISTINCTROW",
        61  => "DIV",
        62  => "DO",
        63  => "DROP",
        64  => "DUMPFILE",
        65  => "DUPLICATE",
        66  => "DYNAMIC",
        67  => "ELSE",
        68  => "ENCLOSED",
        69  => "END",
        70  => "ENGINE",
        71  => "ENGINES",
        72  => "ENGINE_TYPE",
        73  => "ESCAPE",
        74  => "ESCAPED",
        75  => "EVENTS",
        76  => "EXCEPT",
        77  => "EXECUTE",
        78  => "EXISTS",
        79  => "EXPLAIN",
        80  => "EXTENDED",
        81  => "FAST",
        82  => "FIELDS",
        83  => "FILE",
        84  => "FIRST",
        85  => "FIXED",
        86  => "FLUSH",
        87  => "FOR",
        88  => "FORCE",
        89  => "FOREIGN",
        90  => "FROM",
        91  => "FULL",
        92  => "FULLTEXT",
        93  => "FUNCTION",
        94  => "GLOBAL",
        95  => "GRANT",
        96  => "GRANTS",
        97  => "GROUP",
        98  => "GROUP_CONCAT",
        99  => "HAVING",
        100 => "HEAP",
        101 => "HIGH_PRIORITY",
        102 => "HOSTS",
        103 => "HOUR",
        104 => "HOUR_MINUTE",
        105 => "HOUR_SECOND",
        106 => "IDENTIFIED",
        107 => "IF",
        108 => "IFNULL",
        109 => "IGNORE",
        110 => "IN",
        111 => "INDEX",
        112 => "INDEXES",
        113 => "INFILE",
        114 => "INNER",
        115 => "INSERT",
        116 => "INSERT_ID",
        117 => "INSERT_METHOD",
        118 => "INTERSECT",
        119 => "INTERVAL",
        120 => "INTO",
        121 => "INVOKER",
        122 => "IS",
        123 => "ISOLATION",
        124 => "JOIN",
        125 => "JSON_ARRAY",
        126 => "JSON_ARRAY_APPEND",
        127 => "JSON_ARRAY_INSERT",
        128 => "JSON_CONTAINS",
        129 => "JSON_CONTAINS_PATH",
        130 => "JSON_DEPTH",
        131 => "JSON_EXTRACT",
        132 => "JSON_INSERT",
        133 => "JSON_KEYS",
        134 => "JSON_LENGTH",
        135 => "JSON_MERGE_PATCH",
        136 => "JSON_MERGE_PRESERVE",
        137 => "JSON_OBJECT",
        138 => "JSON_PRETTY",
        139 => "JSON_QUOTE",
        140 => "JSON_REMOVE",
        141 => "JSON_REPLACE",
        142 => "JSON_SEARCH",
        143 => "JSON_SET",
        144 => "JSON_STORAGE_SIZE",
        145 => "JSON_TYPE",
        146 => "JSON_UNQUOTE",
        147 => "JSON_VALID",
        148 => "KEY",
        149 => "KEYS",
        150 => "KILL",
        151 => "LAST_INSERT_ID",
        152 => "LEADING",
        153 => "LEFT",
        154 => "LEVEL",
        155 => "LIKE",
        156 => "LIMIT",
        157 => "LINEAR",
        158 => "LINES",
        159 => "LOAD",
        160 => "LOCAL",
        161 => "LOCK",
        162 => "LOCKS",
        163 => "LOGS",
        164 => "LOW_PRIORITY",
        165 => "MARIA",
        166 => "MASTER",
        167 => "MASTER_CONNECT_RETRY",
        168 => "MASTER_HOST",
        169 => "MASTER_LOG_FILE",
        170 => "MATCH",
        171 => "MAX_CONNECTIONS_PER_HOUR",
        172 => "MAX_QUERIES_PER_HOUR",
        173 => "MAX_ROWS",
        174 => "MAX_UPDATES_PER_HOUR",
        175 => "MAX_USER_CONNECTIONS",
        176 => "MEDIUM",
        177 => "MERGE",
        178 => "MINUTE",
        179 => "MINUTE_SECOND",
        180 => "MIN_ROWS",
        181 => "MODE",
        182 => "MODIFY",
        183 => "MONTH",
        184 => "MRG_MYISAM",
        185 => "MYISAM",
        186 => "NAMES",
        187 => "NATURAL",
        188 => "NOT",
        189 => "NOW()",
        190 => "NULL",
        191 => "OFFSET",
        192 => "ON",
        193 => "ON DELETE",
        194 => "ON UPDATE",
        195 => "OPEN",
        196 => "OPTIMIZE",
        197 => "OPTION",
        198 => "OPTIONALLY",
        199 => "OR",
        200 => "ORDER",
        201 => "BY",
        202 => "OUTER",
        203 => "OUTFILE",
        204 => "PACK_KEYS",
        205 => "PAGE",
        206 => "PARTIAL",
        207 => "PARTITION",
        208 => "PARTITIONS",
        209 => "PASSWORD",
        210 => "PRIMARY",
        211 => "PRIVILEGES",
        212 => "PROCEDURE",
        213 => "PROCESS",
        214 => "PROCESSLIST",
        215 => "PURGE",
        216 => "QUICK",
        217 => "RAID0",
        218 => "RAID_CHUNKS",
        219 => "RAID_CHUNKSIZE",
        220 => "RAID_TYPE",
        221 => "RANGE",
        222 => "READ",
        223 => "READ_ONLY",
        224 => "READ_WRITE",
        225 => "REFERENCES",
        226 => "REGEXP",
        227 => "RELOAD",
        228 => "RENAME",
        229 => "REPAIR",
        230 => "REPEATABLE",
        231 => "REPLACE",
        232 => "REPLICATION",
        233 => "RESET",
        234 => "RESTORE",
        235 => "RESTRICT",
        236 => "RETURN",
        237 => "RETURNS",
        238 => "REVOKE",
        239 => "RIGHT",
        240 => "RLIKE",
        241 => "ROLLBACK",
        242 => "ROLLUP",
        243 => "ROW",
        244 => "ROWS",
        245 => "ROW_FORMAT",
        246 => "SECOND",
        247 => "SECURITY",
        248 => "SELECT",
        249 => "SEPARATOR",
        250 => "SERIALIZABLE",
        251 => "SESSION",
        252 => "SET",
        253 => "SHARE",
        254 => "SHOW",
        255 => "SHUTDOWN",
        256 => "SLAVE",
        257 => "SONAME",
        258 => "SOUNDS",
        259 => "SQL",
        260 => "SQL_AUTO_IS_NULL",
        261 => "SQL_BIG_RESULT",
        262 => "SQL_BIG_SELECTS",
        263 => "SQL_BIG_TABLES",
        264 => "SQL_BUFFER_RESULT",
        265 => "SQL_CACHE",
        266 => "SQL_CALC_FOUND_ROWS",
        267 => "SQL_LOG_BIN",
        268 => "SQL_LOG_OFF",
        269 => "SQL_LOG_UPDATE",
        270 => "SQL_LOW_PRIORITY_UPDATES",
        271 => "SQL_MAX_JOIN_SIZE",
        272 => "SQL_NO_CACHE",
        273 => "SQL_QUOTE_SHOW_CREATE",
        274 => "SQL_SAFE_UPDATES",
        275 => "SQL_SELECT_LIMIT",
        276 => "SQL_SLAVE_SKIP_COUNTER",
        277 => "SQL_SMALL_RESULT",
        278 => "SQL_WARNINGS",
        279 => "START",
        280 => "STARTING",
        281 => "STATUS",
        282 => "STOP",
        283 => "STORAGE",
        284 => "STRAIGHT_JOIN",
        285 => "STRING",
        286 => "STRIPED",
        287 => "SUPER",
        288 => "TABLE",
        289 => "TABLES",
        290 => "TEMPORARY",
        291 => "TERMINATED",
        292 => "THEN",
        293 => "TO",
        294 => "TRAILING",
        295 => "TRANSACTIONAL",
        296 => "TRUE",
        297 => "TRUNCATE",
        298 => "TYPE",
        299 => "TYPES",
        300 => "UNCOMMITTED",
        301 => "UNION",
        302 => "UNION ALL",
        303 => "UNIQUE",
        304 => "UNLOCK",
        305 => "UNSIGNED",
        306 => "UPDATE",
        307 => "USAGE",
        308 => "USE",
        309 => "USING",
        310 => "VALUES",
        311 => "VARIABLES",
        312 => "VIEW",
        313 => "WHEN",
        314 => "WHERE",
        315 => "WITH",
        316 => "WORK",
        317 => "WRITE",
        318 => "XOR",
        319 => "YEAR_MONTH",
        320 => "ABS",
        321 => "ACOS",
        322 => "ADDDATE",
        323 => "ADDTIME",
        324 => "AES_DECRYPT",
        325 => "AES_ENCRYPT",
        326 => "AREA",
        327 => "ASBINARY",
        328 => "ASCII",
        329 => "ASIN",
        330 => "ASTEXT",
        331 => "ATAN",
        332 => "ATAN2",
        333 => "AVG",
        334 => "BDMPOLYFROMTEXT",
        335 => "BDMPOLYFROMWKB",
        336 => "BDPOLYFROMTEXT",
        337 => "BDPOLYFROMWKB",
        338 => "BENCHMARK",
        339 => "BIN",
        340 => "BIT_AND",
        341 => "BIT_COUNT",
        342 => "BIT_LENGTH",
        343 => "BIT_OR",
        344 => "BIT_XOR",
        345 => "BOUNDARY",
        346 => "BUFFER",
        347 => "CAST",
        348 => "CEIL",
        349 => "CEILING",
        350 => "CENTROID",
        351 => "CHAR",
        352 => "CHARACTER_LENGTH",
        353 => "CHARSET",
        354 => "CHAR_LENGTH",
        355 => "COALESCE",
        356 => "COERCIBILITY",
        357 => "COLLATION",
        358 => "COMPRESS",
        359 => "CONCAT",
        360 => "CONCAT_WS",
        361 => "CONNECTION_ID",
        362 => "CONTAINS",
        363 => "CONV",
        364 => "CONVERT",
        365 => "CONVERT_TZ",
        366 => "CONVEXHULL",
        367 => "COS",
        368 => "COT",
        369 => "COUNT",
        370 => "CRC32",
        371 => "CROSSES",
        372 => "CURDATE",
        373 => "CURRENT_DATE",
        374 => "CURRENT_TIME",
        375 => "CURRENT_TIMESTAMP",
        376 => "CURRENT_USER",
        377 => "CURTIME",
        378 => "DATABASE",
        379 => "DATE",
        380 => "DATEDIFF",
        381 => "DATE_ADD",
        382 => "DATE_DIFF",
        383 => "DATE_FORMAT",
        384 => "DATE_SUB",
        385 => "DAY",
        386 => "DAYNAME",
        387 => "DAYOFMONTH",
        388 => "DAYOFWEEK",
        389 => "DAYOFYEAR",
        390 => "DECODE",
        391 => "DEFAULT",
        392 => "DEGREES",
        393 => "DES_DECRYPT",
        394 => "DES_ENCRYPT",
        395 => "DIFFERENCE",
        396 => "DIMENSION",
        397 => "DISJOINT",
        398 => "DISTANCE",
        399 => "ELT",
        400 => "ENCODE",
        401 => "ENCRYPT",
        402 => "ENDPOINT",
        403 => "ENVELOPE",
        404 => "EQUALS",
        405 => "EXP",
        406 => "EXPORT_SET",
        407 => "EXTERIORRING",
        408 => "EXTRACT",
        409 => "EXTRACTVALUE",
        410 => "FIELD",
        411 => "FIND_IN_SET",
        412 => "FLOOR",
        413 => "FORMAT",
        414 => "FOUND_ROWS",
        415 => "FROM_DAYS",
        416 => "FROM_UNIXTIME",
        417 => "GEOMCOLLFROMTEXT",
        418 => "GEOMCOLLFROMWKB",
        419 => "GEOMETRYCOLLECTION",
        420 => "GEOMETRYCOLLECTIONFROMTEXT",
        421 => "GEOMETRYCOLLECTIONFROMWKB",
        422 => "GEOMETRYFROMTEXT",
        423 => "GEOMETRYFROMWKB",
        424 => "GEOMETRYN",
        425 => "GEOMETRYTYPE",
        426 => "GEOMFROMTEXT",
        427 => "GEOMFROMWKB",
        428 => "GET_FORMAT",
        429 => "GET_LOCK",
        430 => "GLENGTH",
        431 => "GREATEST",
        432 => "GROUP_CONCAT",
        433 => "GROUP_UNIQUE_USERS",
        434 => "HEX",
        435 => "HOUR",
        436 => "IF",
        437 => "IFNULL",
        438 => "INET_ATON",
        439 => "INET_NTOA",
        440 => "INSERT",
        441 => "INSTR",
        442 => "INTERIORRINGN",
        443 => "INTERSECTION",
        444 => "INTERSECTS",
        445 => "INTERVAL",
        446 => "ISCLOSED",
        447 => "ISEMPTY",
        448 => "ISNULL",
        449 => "ISRING",
        450 => "ISSIMPLE",
        451 => "IS_FREE_LOCK",
        452 => "IS_USED_LOCK",
        453 => "LAST_DAY",
        454 => "LAST_INSERT_ID",
        455 => "LCASE",
        456 => "LEAST",
        457 => "LEFT",
        458 => "LENGTH",
        459 => "LINEFROMTEXT",
        460 => "LINEFROMWKB",
        461 => "LINESTRING",
        462 => "LINESTRINGFROMTEXT",
        463 => "LINESTRINGFROMWKB",
        464 => "LN",
        465 => "LOAD_FILE",
        466 => "LOCALTIME",
        467 => "LOCALTIMESTAMP",
        468 => "LOCATE",
        469 => "LOG",
        470 => "LOG10",
        471 => "LOG2",
        472 => "LOWER",
        473 => "LPAD",
        474 => "LTRIM",
        475 => "MAKEDATE",
        476 => "MAKETIME",
        477 => "MAKE_SET",
        478 => "MASTER_POS_WAIT",
        479 => "MAX",
        480 => "MBRCONTAINS",
        481 => "MBRDISJOINT",
        482 => "MBREQUAL",
        483 => "MBRINTERSECTS",
        484 => "MBROVERLAPS",
        485 => "MBRTOUCHES",
        486 => "MBRWITHIN",
        487 => "MD5",
        488 => "MICROSECOND",
        489 => "MID",
        490 => "MIN",
        491 => "MINUTE",
        492 => "MLINEFROMTEXT",
        493 => "MLINEFROMWKB",
        494 => "MOD",
        495 => "MONTH",
        496 => "MONTHNAME",
        497 => "MPOINTFROMTEXT",
        498 => "MPOINTFROMWKB",
        499 => "MPOLYFROMTEXT",
        500 => "MPOLYFROMWKB",
        501 => "MULTILINESTRING",
        502 => "MULTILINESTRINGFROMTEXT",
        503 => "MULTILINESTRINGFROMWKB",
        504 => "MULTIPOINT",
        505 => "MULTIPOINTFROMTEXT",
        506 => "MULTIPOINTFROMWKB",
        507 => "MULTIPOLYGON",
        508 => "MULTIPOLYGONFROMTEXT",
        509 => "MULTIPOLYGONFROMWKB",
        510 => "NAME_CONST",
        511 => "NULLIF",
        512 => "NUMGEOMETRIES",
        513 => "NUMINTERIORRINGS",
        514 => "NUMPOINTS",
        515 => "OCT",
        516 => "OCTET_LENGTH",
        517 => "OLD_PASSWORD",
        518 => "ORD",
        519 => "OVERLAPS",
        520 => "PASSWORD",
        521 => "PERIOD_ADD",
        522 => "PERIOD_DIFF",
        523 => "PI",
        524 => "POINT",
        525 => "POINTFROMTEXT",
        526 => "POINTFROMWKB",
        527 => "POINTN",
        528 => "POINTONSURFACE",
        529 => "POLYFROMTEXT",
        530 => "POLYFROMWKB",
        531 => "POLYGON",
        532 => "POLYGONFROMTEXT",
        533 => "POLYGONFROMWKB",
        534 => "POSITION",
        535 => "POW",
        536 => "POWER",
        537 => "QUARTER",
        538 => "QUOTE",
        539 => "RADIANS",
        540 => "RAND",
        541 => "RELATED",
        542 => "RELEASE_LOCK",
        543 => "REPEAT",
        544 => "REPLACE",
        545 => "REVERSE",
        546 => "RIGHT",
        547 => "ROUND",
        548 => "ROW_COUNT",
        549 => "RPAD",
        550 => "RTRIM",
        551 => "SCHEMA",
        552 => "SECOND",
        553 => "SEC_TO_TIME",
        554 => "SESSION_USER",
        555 => "SHA",
        556 => "SHA1",
        557 => "SIGN",
        558 => "SIN",
        559 => "SLEEP",
        560 => "SOUNDEX",
        561 => "SPACE",
        562 => "SQRT",
        563 => "SRID",
        564 => "STARTPOINT",
        565 => "STD",
        566 => "STDDEV",
        567 => "STDDEV_POP",
        568 => "STDDEV_SAMP",
        569 => "STRCMP",
        570 => "STR_TO_DATE",
        571 => "SUBDATE",
        572 => "SUBSTR",
        573 => "SUBSTRING",
        574 => "SUBSTRING_INDEX",
        575 => "SUBTIME",
        576 => "SUM",
        577 => "SYMDIFFERENCE",
        578 => "SYSDATE",
        579 => "SYSTEM_USER",
        580 => "TAN",
        581 => "TIME",
        582 => "TIMEDIFF",
        583 => "TIMESTAMP",
        584 => "TIMESTAMPADD",
        585 => "TIMESTAMPDIFF",
        586 => "TIME_FORMAT",
        587 => "TIME_TO_SEC",
        588 => "TOUCHES",
        589 => "TO_DAYS",
        590 => "TRIM",
        591 => "TRUNCATE",
        592 => "UCASE",
        593 => "UNCOMPRESS",
        594 => "UNCOMPRESSED_LENGTH",
        595 => "UNHEX",
        596 => "UNIQUE_USERS",
        597 => "UNIX_TIMESTAMP",
        598 => "UPDATEXML",
        599 => "UPPER",
        600 => "USER",
        601 => "UTC_DATE",
        602 => "UTC_TIME",
        603 => "UTC_TIMESTAMP",
        604 => "UUID",
        605 => "VARIANCE",
        606 => "VAR_POP",
        607 => "VAR_SAMP",
        608 => "VERSION",
        609 => "WEEK",
        610 => "WEEKDAY",
        611 => "WEEKOFYEAR",
        612 => "WITHIN",
        613 => "X",
        614 => "Y",
        615 => "YEAR",
        616 => "YEARWEEK",
    ]);
}

if (!defined("ryunosuke\\WebDebugger\\TOKEN_NAME")) {
    /** parse_php 関数でトークン名変換をするか */
    define("ryunosuke\\WebDebugger\\TOKEN_NAME", 2);
}


# functions
if (!isset($excluded_functions["arrayize"]) && (!function_exists("ryunosuke\\WebDebugger\\arrayize") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\arrayize"))->isInternal()))) {
    /**
     * 引数の配列を生成する。
     *
     * 配列以外を渡すと配列化されて追加される。
     * 連想配列は未対応。あくまで普通の配列化のみ。
     * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
     *
     * Example:
     * ```php
     * that(arrayize(1, 2, 3))->isSame([1, 2, 3]);
     * that(arrayize([1], [2], [3]))->isSame([1, 2, 3]);
     * $object = new \stdClass();
     * that(arrayize($object, false, [1, 2, 3]))->isSame([$object, false, 1, 2, 3]);
     * ```
     *
     * @param mixed $variadic 生成する要素（可変引数）
     * @return array 引数を配列化したもの
     */
    function arrayize(...$variadic)
    {
        $result = [];
        foreach ($variadic as $arg) {
            if (!is_array($arg)) {
                $arg = [$arg];
            }
            $result = array_merge($result, $arg);
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\arrayize") && !defined("ryunosuke\\WebDebugger\\arrayize")) {
    define("ryunosuke\\WebDebugger\\arrayize", "ryunosuke\\WebDebugger\\arrayize");
}

if (!isset($excluded_functions["is_hasharray"]) && (!function_exists("ryunosuke\\WebDebugger\\is_hasharray") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\is_hasharray"))->isInternal()))) {
    /**
     * 配列が連想配列か調べる
     *
     * 空の配列は普通の配列とみなす。
     *
     * Example:
     * ```php
     * that(is_hasharray([]))->isFalse();
     * that(is_hasharray([1, 2, 3]))->isFalse();
     * that(is_hasharray(['x' => 'X']))->isTrue();
     * ```
     *
     * @param array $array 調べる配列
     * @return bool 連想配列なら true
     */
    function is_hasharray(array $array)
    {
        $i = 0;
        foreach ($array as $k => $dummy) {
            if ($k !== $i++) {
                return true;
            }
        }
        return false;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\is_hasharray") && !defined("ryunosuke\\WebDebugger\\is_hasharray")) {
    define("ryunosuke\\WebDebugger\\is_hasharray", "ryunosuke\\WebDebugger\\is_hasharray");
}

if (!isset($excluded_functions["array_map_method"]) && (!function_exists("ryunosuke\\WebDebugger\\array_map_method") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\array_map_method"))->isInternal()))) {
    /**
     * メソッドを指定できるようにした array_map
     *
     * 配列内の要素は全て同一（少なくともシグネチャが同じ $method が存在する）オブジェクトでなければならない。
     * スルーする場合は $ignore=true とする。スルーした場合 map ではなく filter される（結果配列に含まれない）。
     * $ignore=null とすると 何もせずそのまま要素を返す。
     *
     * Example:
     * ```php
     * $exa = new \Exception('a');
     * $exb = new \Exception('b');
     * $std = new \stdClass();
     * // getMessage で map される
     * that(array_map_method([$exa, $exb], 'getMessage'))->isSame(['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
     * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true))->isSame(['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
     * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null))->isSame(['a', 'b', $std, null]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $method メソッド
     * @param array $args メソッドに渡る引数
     * @param bool|null $ignore メソッドが存在しない場合にスルーするか。null を渡すと要素そのものを返す
     * @return array $method が true を返した新しい配列
     */
    function array_map_method($array, $method, $args = [], $ignore = false)
    {
        if ($ignore === true) {
            $array = array_filter(arrayval($array, false), function ($object) use ($method) {
                return is_callable([$object, $method]);
            });
        }
        return array_map(function ($object) use ($method, $args, $ignore) {
            if ($ignore === null && !is_callable([$object, $method])) {
                return $object;
            }
            return ([$object, $method])(...$args);
        }, arrayval($array, false));
    }
}
if (function_exists("ryunosuke\\WebDebugger\\array_map_method") && !defined("ryunosuke\\WebDebugger\\array_map_method")) {
    define("ryunosuke\\WebDebugger\\array_map_method", "ryunosuke\\WebDebugger\\array_map_method");
}

if (!isset($excluded_functions["array_kmap"]) && (!function_exists("ryunosuke\\WebDebugger\\array_kmap") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\array_kmap"))->isInternal()))) {
    /**
     * キーも渡ってくる array_map
     *
     * `array_map($callback, $array, array_keys($array))` とほとんど変わりはない。
     * 違いは下記。
     *
     * - 引数の順番が異なる（$array が先）
     * - キーが死なない（array_map は複数配列を与えるとキーが死ぬ）
     * - 配列だけでなく Traversable も受け入れる
     * - callback の第3引数に 0 からの連番が渡ってくる
     *
     * Example:
     * ```php
     * // キー・値をくっつけるシンプルな例
     * that(array_kmap([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     *     'k3' => 'v3',
     * ], function($v, $k){return "$k:$v";}))->isSame([
     *     'k1' => 'k1:v1',
     *     'k2' => 'k2:v2',
     *     'k3' => 'k3:v3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback を通した新しい配列
     */
    function array_kmap($array, $callback)
    {
        $callback = func_user_func_array($callback);

        $n = 0;
        $result = [];
        foreach ($array as $k => $v) {
            $result[$k] = $callback($v, $k, $n++);
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\array_kmap") && !defined("ryunosuke\\WebDebugger\\array_kmap")) {
    define("ryunosuke\\WebDebugger\\array_kmap", "ryunosuke\\WebDebugger\\array_kmap");
}

if (!isset($excluded_functions["array_each"]) && (!function_exists("ryunosuke\\WebDebugger\\array_each") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\array_each"))->isInternal()))) {
    /**
     * array_reduce の参照版（のようなもの）
     *
     * 配列をループで回し、その途中経過、値、キー、連番をコールバック引数で渡して最終的な結果を返り値として返す。
     * array_reduce と少し似てるが、下記の点が異なる。
     *
     * - いわゆる $carry は返り値で表すのではなく、参照引数で表す
     * - 値だけでなくキー、連番も渡ってくる
     * - 巨大配列の場合でも速度劣化が少ない（array_reduce に巨大配列を渡すと実用にならないレベルで遅くなる）
     *
     * $callback の引数は `($value, $key, $n)` （$n はキーとは関係がない 0 ～ 要素数-1 の通し連番）。
     *
     * 返り値ではなく参照引数なので return する必要はない（ワンライナーが書きやすくなる）。
     * 返り値が空くのでループ制御に用いる。
     * 今のところ $callback が false を返すとそこで break するのみ。
     *
     * 第3引数を省略した場合、**クロージャの第1引数のデフォルト値が使われる**。
     * これは特筆すべき動作で、不格好な第3引数を完全に省略することができる（サンプルコードを参照）。
     * ただし「php の文法違反（今のところエラーにはならないし、全てにデフォルト値をつければ一応回避可能）」「リフレクションを使う（ほんの少し遅くなる）」などの弊害が有るので推奨はしない。
     * （ただ、「意図していることをコードで表す」といった観点ではこの記法の方が正しいとも思う）。
     *
     * Example:
     * ```php
     * // 全要素を文字列的に足し合わせる
     * that(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry .= $v;}, ''))->isSame('12345');
     * // 値をキーにして要素を2乗値にする
     * that(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry[$v] = $v * $v;}, []))->isSame([
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     *     4 => 16,
     *     5 => 25,
     * ]);
     * // 上記と同じ。ただし、3 で break する
     * that(array_each([1, 2, 3, 4, 5], function(&$carry, $v, $k){
     *     if ($k === 3) return false;
     *     $carry[$v] = $v * $v;
     * }, []))->isSame([
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     * ]);
     *
     * // 下記は完全に同じ（第3引数の代わりにデフォルト引数を使っている）
     * that(array_each([1, 2, 3], function(&$carry = [], $v) {
     *         $carry[$v] = $v * $v;
     *     }))->isSame(array_each([1, 2, 3], function(&$carry, $v) {
     *         $carry[$v] = $v * $v;
     *     }, [])
     *     // 個人的に↑のようなぶら下がり引数があまり好きではない（クロージャを最後の引数にしたい）
     * );
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。(&$carry, $key, $value) を受ける
     * @param mixed $default ループの最初や空の場合に適用される値
     * @return mixed each した結果
     */
    function array_each($array, $callback, $default = null)
    {
        if (func_num_args() === 2) {
            /** @var \ReflectionFunction $ref */
            $ref = reflect_callable($callback);
            $params = $ref->getParameters();
            if ($params[0]->isDefaultValueAvailable()) {
                $default = $params[0]->getDefaultValue();
            }
        }

        $n = 0;
        foreach ($array as $k => $v) {
            $return = $callback($default, $v, $k, $n++);
            if ($return === false) {
                break;
            }
        }
        return $default;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\array_each") && !defined("ryunosuke\\WebDebugger\\array_each")) {
    define("ryunosuke\\WebDebugger\\array_each", "ryunosuke\\WebDebugger\\array_each");
}

if (!isset($excluded_functions["array_all"]) && (!function_exists("ryunosuke\\WebDebugger\\array_all") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\array_all"))->isInternal()))) {
    /**
     * 全要素が true になるなら true を返す（1つでも false なら false を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * that(array_all([true, true]))->isTrue();
     * that(array_all([true, false]))->isFalse();
     * that(array_all([false, false]))->isFalse();
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が true なら true
     */
    function array_all($array, $callback = null, $default = true)
    {
        if (is_empty($array)) {
            return $default;
        }

        $callback = func_user_func_array($callback);

        foreach ($array as $k => $v) {
            if (!$callback($v, $k)) {
                return false;
            }
        }
        return true;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\array_all") && !defined("ryunosuke\\WebDebugger\\array_all")) {
    define("ryunosuke\\WebDebugger\\array_all", "ryunosuke\\WebDebugger\\array_all");
}

if (!isset($excluded_functions["array_lookup"]) && (!function_exists("ryunosuke\\WebDebugger\\array_lookup") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\array_lookup"))->isInternal()))) {
    /**
     * キー保存可能な array_column
     *
     * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
     *
     * Example:
     * ```php
     * $array = [
     *     11 => ['id' => 1, 'name' => 'name1'],
     *     12 => ['id' => 2, 'name' => 'name2'],
     *     13 => ['id' => 3, 'name' => 'name3'],
     * ];
     * // 第3引数を渡せば array_column と全く同じ
     * that(array_lookup($array, 'name', 'id'))->isSame(array_column($array, 'name', 'id'));
     * that(array_lookup($array, 'name', null))->isSame(array_column($array, 'name', null));
     * // 省略すればキーが保存される
     * that(array_lookup($array, 'name'))->isSame([
     *     11 => 'name1',
     *     12 => 'name2',
     *     13 => 'name3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|null $column_key 値となるキー
     * @param string|null $index_key キーとなるキー
     * @return array 新しい配列
     */
    function array_lookup($array, $column_key = null, $index_key = null)
    {
        $array = arrayval($array, false);
        if (func_num_args() === 3) {
            return array_column($array, $column_key, $index_key);
        }
        return array_combine(array_keys($array), array_column($array, $column_key));
    }
}
if (function_exists("ryunosuke\\WebDebugger\\array_lookup") && !defined("ryunosuke\\WebDebugger\\array_lookup")) {
    define("ryunosuke\\WebDebugger\\array_lookup", "ryunosuke\\WebDebugger\\array_lookup");
}

if (!isset($excluded_functions["class_loader"]) && (!function_exists("ryunosuke\\WebDebugger\\class_loader") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\class_loader"))->isInternal()))) {
    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * that(class_loader())->isInstanceOf(\Composer\Autoload\ClassLoader::class);
     * ```
     *
     * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return \Composer\Autoload\ClassLoader クラスローダ
     */
    function class_loader($startdir = null)
    {
        $file = cache('path', function () use ($startdir) {
            $cache = dirname_r($startdir ?: __DIR__, function ($dir) {
                if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                    return $file;
                }
            });
            if (!$cache) {
                throw new \DomainException('autoloader is not found.');
            }
            return $cache;
        }, __FUNCTION__);
        return require $file;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\class_loader") && !defined("ryunosuke\\WebDebugger\\class_loader")) {
    define("ryunosuke\\WebDebugger\\class_loader", "ryunosuke\\WebDebugger\\class_loader");
}

if (!isset($excluded_functions["class_shorten"]) && (!function_exists("ryunosuke\\WebDebugger\\class_shorten") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\class_shorten"))->isInternal()))) {
    /**
     * クラスの名前空間部分を除いた短い名前を取得する
     *
     * Example:
     * ```php
     * that(class_shorten('vendor\\namespace\\ClassName'))->isSame('ClassName');
     * ```
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの短い名前
     */
    function class_shorten($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        return array_pop($parts);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\class_shorten") && !defined("ryunosuke\\WebDebugger\\class_shorten")) {
    define("ryunosuke\\WebDebugger\\class_shorten", "ryunosuke\\WebDebugger\\class_shorten");
}

if (!isset($excluded_functions["class_replace"]) && (!function_exists("ryunosuke\\WebDebugger\\class_replace") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\class_replace"))->isInternal()))) {
    /**
     * 既存（未読み込みに限る）クラスを強制的に置換する
     *
     * 例えば継承ツリーが下記の場合を考える。
     *
     * classA <- classB <- classC
     *
     * この場合、「classC は classB に」「classB は classA に」それぞれ依存している、と考えることができる。
     * これは静的に決定的であり、この依存を壊したり注入したりする手段は存在しない。
     * 例えば classA の実装を差し替えたいときに、いかに classA を継承した classAA を定義したとしても classB の親は classA で決して変わらない。
     *
     * この関数を使うと本当に classA そのものを弄るので、継承ツリーを下記のように変えることができる。
     *
     * classA <- classAA <- classB <- classC
     *
     * つまり、classA を継承した classAA を定義してそれを classA とみなすことが可能になる。
     * ただし、内部的には class_alias を使用して実現しているので厳密には異なるクラスとなる。
     *
     * 実際のところかなり強力な機能だが、同時にかなり黒魔術的なので乱用は控えたほうがいい。
     *
     * Example:
     * ```php
     * // Y1 extends X1 だとしてクラス定義でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X1', function() {
     *     // アンスコがついたクラスが定義されるのでそれを継承して定義する
     *     class X1d extends \ryunosuke\Test\Package\Classobj\X1_
     *     {
     *         function method(){return 'this is X1d';}
     *         function newmethod(){return 'this is newmethod';}
     *     }
     *     // このように匿名クラスを返しても良い。ただし、混在せずにどちらか一方にすること
     *     return new class() extends \ryunosuke\Test\Package\Classobj\X1_
     *     {
     *         function method(){return 'this is X1d';}
     *         function newmethod(){return 'this is newmethod';}
     *     };
     * });
     * // X1 を継承している Y1 にまで影響が出ている（X1 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y1())->method())->isSame('this is X1d');
     * that((new \ryunosuke\Test\Package\Classobj\Y1())->newmethod())->isSame('this is newmethod');
     *
     * // Y2 extends X2 だとしてクロージャ配列でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X2', function() {
     *     return [
     *         'method'    => function(){return 'this is X2d';},
     *         'newmethod' => function(){return 'this is newmethod';},
     *     ];
     * });
     * // X2 を継承している Y2 にまで影響が出ている（X2 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y2())->method())->isSame('this is X2d');
     * that((new \ryunosuke\Test\Package\Classobj\Y2())->newmethod())->isSame('this is newmethod');
     *
     * // メソッド定義だけであればクロージャではなく配列指定でも可能。さらに trait 配列を渡すとそれらを use できる
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X3', [
     *     [\ryunosuke\Test\Package\Classobj\XTrait::class],
     *     'method' => function(){return 'this is X3d';},
     * ]);
     * // X3 を継承している Y3 にまで影響が出ている（X3 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y3())->method())->isSame('this is X3d');
     * // トレイトのメソッドも生えている
     * that((new \ryunosuke\Test\Package\Classobj\Y3())->traitMethod())->isSame('this is XTrait::traitMethod');
     * ```
     *
     * @param string $class 対象クラス名
     * @param \Closure|array $register 置換クラスを定義 or 返すクロージャ or 定義メソッド配列
     */
    function class_replace($class, $register)
    {
        $class = ltrim($class, '\\');

        // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
        if (class_exists($class, false)) {
            throw new \DomainException("'$class' is already declared.");
        }

        // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
        $classfile = class_loader()->findFile($class);
        $fname = cachedir() . '/' . rawurlencode(__FUNCTION__ . '-' . $class) . '.php';
        if (!file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            file_put_contents($fname, $content, LOCK_EX);
        }
        require_once $fname;

        $classess = get_declared_classes();
        if ($register instanceof \Closure) {
            $newclass = $register();
        }
        else {
            $newclass = $register;
        }

        // クロージャ内部でクラス定義した場合（増えたクラスでエイリアスする）
        if ($newclass === null) {
            $classes = array_diff(get_declared_classes(), $classess);
            if (count($classes) !== 1) {
                throw new \DomainException('declared multi classes.' . implode(',', $classes));
            }
            $newclass = reset($classes);
        }
        // php7.0 から無名クラスが使えるのでそのクラス名でエイリアスする
        if (is_object($newclass)) {
            $newclass = get_class($newclass);
        }
        // 配列はメソッド定義のクロージャ配列とする
        if (is_array($newclass)) {
            $content = file_get_contents($fname);
            $origspace = parse_php($content, [
                'begin' => T_NAMESPACE,
                'end'   => ';',
            ]);
            array_shift($origspace);
            array_pop($origspace);

            $origclass = parse_php($content, [
                'begin'  => T_CLASS,
                'end'    => T_STRING,
                'offset' => count($origspace),
            ]);
            array_shift($origclass);

            $origspace = trim(implode('', array_column($origspace, 1)));
            $origclass = trim(implode('', array_column($origclass, 1)));

            $classcode = '';
            foreach ($newclass as $name => $member) {
                if (is_array($member)) {
                    foreach ($member as $trait) {
                        $classcode .= "use \\" . trim($trait, '\\') . ";\n";
                    }
                }
                else {
                    [$declare, $codeblock] = callable_code($member);
                    $parentclass = new \ReflectionClass("\\$origspace\\$origclass");
                    // 元クラスに定義されているならオーバーライドとして特殊な処理を行う
                    if ($parentclass->hasMethod($name)) {
                        /** @var \ReflectionFunctionAbstract $refmember */
                        $refmember = reflect_callable($member);
                        $refmethod = $parentclass->getMethod($name);
                        // 指定クロージャに引数が無くて、元メソッドに有るなら継承
                        if (!$refmember->getNumberOfParameters() && $refmethod->getNumberOfParameters()) {
                            $declare = 'function (' . implode(', ', function_parameter($refmethod)) . ')';
                        }
                        // 同上。返り値版
                        if (!$refmember->hasReturnType() && $refmethod->hasReturnType()) {
                            /** @var \ReflectionNamedType $rtype */
                            $rtype = $refmethod->getReturnType();
                            $declare .= ':' . ($rtype->allowsNull() ? '?' : '') . ($rtype->isBuiltin() ? '' : '\\') . $rtype->getName();
                        }
                    }
                    $mname = preg_replaces('#function(\\s*)\\(#u', " $name", $declare);
                    $classcode .= "public $mname $codeblock\n";
                }
            }

            $newclass = "\\$origspace\\{$origclass}_";
            evaluate("namespace $origspace;\nclass {$origclass}_ extends {$origclass}\n{\n$classcode}");
        }

        class_alias($newclass, $class);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\class_replace") && !defined("ryunosuke\\WebDebugger\\class_replace")) {
    define("ryunosuke\\WebDebugger\\class_replace", "ryunosuke\\WebDebugger\\class_replace");
}

if (!isset($excluded_functions["get_object_properties"]) && (!function_exists("ryunosuke\\WebDebugger\\get_object_properties") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\get_object_properties"))->isInternal()))) {
    /**
     * オブジェクトのプロパティを可視・不可視を問わず取得する
     *
     * get_object_vars + no public プロパティを返すイメージ。
     *
     * Example:
     * ```php
     * $object = new \Exception('something', 42);
     * $object->oreore = 'oreore';
     *
     * // get_object_vars はそのスコープから見えないプロパティを取得できない
     * // var_dump(get_object_vars($object));
     *
     * // array キャストは全て得られるが null 文字を含むので扱いにくい
     * // var_dump((array) $object);
     *
     * // この関数を使えば不可視プロパティも取得できる
     * that(get_object_properties($object))->arraySubset([
     *     'message' => 'something',
     *     'code'    => 42,
     *     'oreore'  => 'oreore',
     * ]);
     * ```
     *
     * @param object $object オブジェクト
     * @return array 全プロパティの配列
     */
    function get_object_properties($object)
    {
        if (function_exists('get_mangled_object_vars')) {
            get_mangled_object_vars($object); // @codeCoverageIgnore
        }

        static $refs = [];
        $class = get_class($object);
        if (!isset($refs[$class])) {
            // var_export や var_dump で得られるものは「親が優先」となっているが、不具合的動作だと思うので「子を優先」とする
            $refs[$class] = [];
            $ref = new \ReflectionClass($class);
            do {
                $refs[$ref->name] = array_each($ref->getProperties(), function (&$carry, \ReflectionProperty $rp) {
                    if (!$rp->isStatic()) {
                        $rp->setAccessible(true);
                        $carry[$rp->getName()] = $rp;
                    }
                }, []);
                $refs[$class] += $refs[$ref->name];
            } while ($ref = $ref->getParentClass());
        }

        // 配列キャストだと private で ヌル文字が出たり static が含まれたりするのでリフレクションで取得して勝手プロパティで埋める
        $vars = array_map_method($refs[$class], 'getValue', [$object]);
        $vars += get_object_vars($object);

        return $vars;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\get_object_properties") && !defined("ryunosuke\\WebDebugger\\get_object_properties")) {
    define("ryunosuke\\WebDebugger\\get_object_properties", "ryunosuke\\WebDebugger\\get_object_properties");
}

if (!isset($excluded_functions["file_set_contents"]) && (!function_exists("ryunosuke\\WebDebugger\\file_set_contents") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\file_set_contents"))->isInternal()))) {
    /**
     * ディレクトリも掘る file_put_contents
     *
     * 書き込みは一時ファイルと rename を使用してアトミックに行われる。
     *
     * Example:
     * ```php
     * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
     * that(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'))->isSame('hoge');
     * ```
     *
     * @param string $filename 書き込むファイル名
     * @param string $data 書き込む内容
     * @param int $umask ディレクトリを掘る際の umask
     * @return int 書き込まれたバイト数
     */
    function file_set_contents($filename, $data, $umask = 0002)
    {
        if (func_num_args() === 2) {
            $umask = umask();
        }

        $filename = path_normalize($filename);

        if (!is_dir($dirname = dirname($filename))) {
            if (!@mkdir_p($dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }

        $tempnam = tempnam($dirname, 'tmp');
        if (($result = file_put_contents($tempnam, $data)) !== false) {
            if (rename($tempnam, $filename)) {
                @chmod($filename, 0666 & ~$umask);
                return $result;
            }
            unlink($tempnam);
        }
        return false;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\file_set_contents") && !defined("ryunosuke\\WebDebugger\\file_set_contents")) {
    define("ryunosuke\\WebDebugger\\file_set_contents", "ryunosuke\\WebDebugger\\file_set_contents");
}

if (!isset($excluded_functions["mkdir_p"]) && (!function_exists("ryunosuke\\WebDebugger\\mkdir_p") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\mkdir_p"))->isInternal()))) {
    /**
     * ディレクトリを再帰的に掘る
     *
     * 既に存在する場合は何もしない（エラーも出さない）。
     *
     * @param string $dirname ディレクトリ名
     * @param int $umask ディレクトリを掘る際の umask
     * @return bool 作成したら true
     */
    function mkdir_p($dirname, $umask = 0002)
    {
        if (func_num_args() === 1) {
            $umask = umask();
        }

        if (file_exists($dirname)) {
            return false;
        }

        return mkdir($dirname, 0777 & (~$umask), true);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\mkdir_p") && !defined("ryunosuke\\WebDebugger\\mkdir_p")) {
    define("ryunosuke\\WebDebugger\\mkdir_p", "ryunosuke\\WebDebugger\\mkdir_p");
}

if (!isset($excluded_functions["dirname_r"]) && (!function_exists("ryunosuke\\WebDebugger\\dirname_r") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\dirname_r"))->isInternal()))) {
    /**
     * コールバックが true 相当を返すまで親ディレクトリを辿り続ける
     *
     * コールバックには親ディレクトリが引数として渡ってくる。
     *
     * Example:
     * ```php
     * // //tmp/a/b/file.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/a/b/file.txt", 'hoge');
     * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
     * $callback = function($path){return realpath("$path/file.txt");};
     * that(dirname_r("$tmp/a/b/c/d/e/f", $callback))->isSame(realpath("$tmp/a/b/file.txt"));
     * ```
     *
     * @param string $path パス名
     * @param callable $callback コールバック
     * @return mixed $callback の返り値。頂上まで辿ったら false
     */
    function dirname_r($path, $callback)
    {
        $return = $callback($path);
        if ($return) {
            return $return;
        }

        $dirname = dirname($path);
        if ($dirname === $path) {
            return false;
        }
        return dirname_r($dirname, $callback);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\dirname_r") && !defined("ryunosuke\\WebDebugger\\dirname_r")) {
    define("ryunosuke\\WebDebugger\\dirname_r", "ryunosuke\\WebDebugger\\dirname_r");
}

if (!isset($excluded_functions["path_normalize"]) && (!function_exists("ryunosuke\\WebDebugger\\path_normalize") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\path_normalize"))->isInternal()))) {
    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_normalize('/path/to/something'))->isSame("{$DS}path{$DS}to{$DS}something");
     * that(path_normalize('/path/through/../something'))->isSame("{$DS}path{$DS}something");
     * that(path_normalize('./path/current/./through/../something'))->isSame("path{$DS}current{$DS}something");
     * ```
     *
     * @param string $path パス文字列
     * @return string 正規化されたパス
     */
    function path_normalize($path)
    {
        $ds = '/';
        if (DIRECTORY_SEPARATOR === '\\') {
            $ds .= '\\\\';
        }

        $result = [];
        foreach (preg_split("#[$ds]#u", $path) as $n => $part) {
            if ($n > 0 && $part === '') {
                continue;
            }
            if ($part === '.') {
                continue;
            }
            if ($part === '..') {
                if (empty($result)) {
                    throw new \InvalidArgumentException("'$path' is invalid as path string.");
                }
                array_pop($result);
                continue;
            }
            $result[] = $part;
        }
        return implode(DIRECTORY_SEPARATOR, $result);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\path_normalize") && !defined("ryunosuke\\WebDebugger\\path_normalize")) {
    define("ryunosuke\\WebDebugger\\path_normalize", "ryunosuke\\WebDebugger\\path_normalize");
}

if (!isset($excluded_functions["delegate"]) && (!function_exists("ryunosuke\\WebDebugger\\delegate") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\delegate"))->isInternal()))) {
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param int $arity 引数の数
     * @return callable $callable を実行するクロージャ
     */
    function delegate($invoker, $callable, $arity = null)
    {
        $arity = $arity ?? parameter_length($callable, true, true);

        if (reflect_callable($callable)->isInternal()) {
            static $cache = [];
            $cache[$arity] = $cache[$arity] ?? evaluate('return new class()
            {
                private $invoker, $callable;

                public function spawn($invoker, $callable)
                {
                    $that = clone($this);
                    $that->invoker = $invoker;
                    $that->callable = $callable;
                    return $that;
                }

                public function __invoke(' . implode(',', is_infinite($arity)
                        ? ['...$_']
                        : array_map(function ($v) { return '$_' . $v; }, array_keys(array_fill(1, $arity, null)))
                    ) . ')
                {
                    return ($this->invoker)($this->callable, func_get_args());
                }
            };');
            return $cache[$arity]->spawn($invoker, $callable);
        }

        switch (true) {
            case $arity === 0:
                return function () use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 1:
                return function ($_1) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 2:
                return function ($_1, $_2) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 3:
                return function ($_1, $_2, $_3) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 4:
                return function ($_1, $_2, $_3, $_4) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case $arity === 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            case is_infinite($arity):
                return function (...$_) use ($invoker, $callable) { return $invoker($callable, func_get_args()); };
            default:
                $args = implode(',', array_map(function ($v) { return '$_' . $v; }, array_keys(array_fill(1, $arity, null))));
                $stmt = 'return function (' . $args . ') use ($invoker, $callable) { return $invoker($callable, func_get_args()); };';
                return eval($stmt);
        }
    }
}
if (function_exists("ryunosuke\\WebDebugger\\delegate") && !defined("ryunosuke\\WebDebugger\\delegate")) {
    define("ryunosuke\\WebDebugger\\delegate", "ryunosuke\\WebDebugger\\delegate");
}

if (!isset($excluded_functions["reflect_callable"]) && (!function_exists("ryunosuke\\WebDebugger\\reflect_callable") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\reflect_callable"))->isInternal()))) {
    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * ```php
     * that(reflect_callable('sprintf'))->isInstanceOf(\ReflectionFunction::class);
     * that(reflect_callable('\Closure::bind'))->isInstanceOf(\ReflectionMethod::class);
     * ```
     *
     * @param callable $callable 対象 callable
     * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
     */
    function reflect_callable($callable)
    {
        // callable チェック兼 $call_name 取得
        if (!is_callable($callable, true, $call_name)) {
            throw new \InvalidArgumentException("'$call_name' is not callable");
        }

        if ($callable instanceof \Closure || strpos($call_name, '::') === false) {
            return new \ReflectionFunction($callable);
        }
        else {
            [$class, $method] = explode('::', $call_name, 2);
            // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
            if (strpos($method, 'parent::') === 0) {
                [, $method] = explode('::', $method);
                return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
            }
            return new \ReflectionMethod($class, $method);
        }
    }
}
if (function_exists("ryunosuke\\WebDebugger\\reflect_callable") && !defined("ryunosuke\\WebDebugger\\reflect_callable")) {
    define("ryunosuke\\WebDebugger\\reflect_callable", "ryunosuke\\WebDebugger\\reflect_callable");
}

if (!isset($excluded_functions["callable_code"]) && (!function_exists("ryunosuke\\WebDebugger\\callable_code") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\callable_code"))->isInternal()))) {
    /**
     * callable のコードブロックを返す
     *
     * 返り値は2値の配列。0番目の要素が定義部、1番目の要素が処理部を表す。
     *
     * Example:
     * ```php
     * list($meta, $body) = callable_code(function(...$args){return true;});
     * that($meta)->isSame('function(...$args)');
     * that($body)->isSame('{return true;}');
     *
     * // ReflectionFunctionAbstract を渡しても動作する
     * list($meta, $body) = callable_code(new \ReflectionFunction(function(...$args){return true;}));
     * that($meta)->isSame('function(...$args)');
     * that($body)->isSame('{return true;}');
     * ```
     *
     * @param callable|\ReflectionFunctionAbstract $callable コードを取得する callable
     * @return array ['定義部分', '{処理コード}']
     */
    function callable_code($callable)
    {
        $ref = $callable instanceof \ReflectionFunctionAbstract ? $callable : reflect_callable($callable);
        $contents = file($ref->getFileName());
        $start = $ref->getStartLine();
        $end = $ref->getEndLine();
        $codeblock = implode('', array_slice($contents, $start - 1, $end - $start + 1));

        $meta = parse_php("<?php $codeblock", [
            'begin' => T_FUNCTION,
            'end'   => '{',
        ]);
        array_pop($meta);

        $body = parse_php("<?php $codeblock", [
            'begin'  => '{',
            'end'    => '}',
            'offset' => count($meta),
        ]);

        return [trim(implode('', array_column($meta, 1))), trim(implode('', array_column($body, 1)))];
    }
}
if (function_exists("ryunosuke\\WebDebugger\\callable_code") && !defined("ryunosuke\\WebDebugger\\callable_code")) {
    define("ryunosuke\\WebDebugger\\callable_code", "ryunosuke\\WebDebugger\\callable_code");
}

if (!isset($excluded_functions["parameter_length"]) && (!function_exists("ryunosuke\\WebDebugger\\parameter_length") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\parameter_length"))->isInternal()))) {
    /**
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * ```php
     * // trim の引数は2つ
     * that(parameter_length('trim'))->isSame(2);
     * // trim の必須引数は1つ
     * that(parameter_length('trim', true))->isSame(1);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param bool $require_only true を渡すと必須パラメータの数を返す
     * @param bool $thought_variadic 可変引数を考慮するか。 true を渡すと可変引数の場合に無限長を返す
     * @return int 引数の数
     */
    function parameter_length($callable, $require_only = false, $thought_variadic = false)
    {
        // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
        if ($callable instanceof \Closure) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = reflect_callable($callable);
            if ($thought_variadic && $ref->isVariadic()) {
                return INF;
            }
            elseif ($require_only) {
                return $ref->getNumberOfRequiredParameters();
            }
            else {
                return $ref->getNumberOfParameters();
            }
        }

        // $call_name 取得
        is_callable($callable, false, $call_name);

        $cache = cache($call_name, function () use ($callable) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = reflect_callable($callable);
            return [
                '00' => $ref->getNumberOfParameters(),
                '01' => $ref->isVariadic() ? INF : $ref->getNumberOfParameters(),
                '10' => $ref->getNumberOfRequiredParameters(),
                '11' => $ref->isVariadic() ? INF : $ref->getNumberOfRequiredParameters(),
            ];
        }, __FUNCTION__);
        return $cache[(int) $require_only . (int) $thought_variadic];
    }
}
if (function_exists("ryunosuke\\WebDebugger\\parameter_length") && !defined("ryunosuke\\WebDebugger\\parameter_length")) {
    define("ryunosuke\\WebDebugger\\parameter_length", "ryunosuke\\WebDebugger\\parameter_length");
}

if (!isset($excluded_functions["func_user_func_array"]) && (!function_exists("ryunosuke\\WebDebugger\\func_user_func_array") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\func_user_func_array"))->isInternal()))) {
    /**
     * パラメータ定義数に応じて呼び出し引数を可変にしてコールする
     *
     * デフォルト引数はカウントされない。必須パラメータの数で呼び出す。
     *
     * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
     *
     * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
     *
     * Example:
     * ```php
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * that($strlen('abc', null))->isSame(3);
     * ```
     *
     * @param callable $callback 呼び出すクロージャ
     * @return callable 引数ぴったりで呼び出すクロージャ
     */
    function func_user_func_array($callback)
    {
        // null は第1引数を返す特殊仕様
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        // クロージャはユーザ定義しかありえないので調べる必要がない
        if ($callback instanceof \Closure) {
            // と思ったが、\Closure::fromCallable で作成されたクロージャは内部属性が伝播されるようなので除外
            if (reflect_callable($callback)->isUserDefined()) {
                return $callback;
            }
        }

        // 上記以外は「引数ぴったりで削ぎ落としてコールするクロージャ」を返す
        $plength = parameter_length($callback, true, true);
        return delegate(function ($callback, $args) use ($plength) {
            if (is_infinite($plength)) {
                return $callback(...$args);
            }
            return $callback(...array_slice($args, 0, $plength));
        }, $callback, $plength);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\func_user_func_array") && !defined("ryunosuke\\WebDebugger\\func_user_func_array")) {
    define("ryunosuke\\WebDebugger\\func_user_func_array", "ryunosuke\\WebDebugger\\func_user_func_array");
}

if (!isset($excluded_functions["function_parameter"]) && (!function_exists("ryunosuke\\WebDebugger\\function_parameter") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\function_parameter"))->isInternal()))) {
    /**
     * 関数/メソッドの引数定義を取得する
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \ReflectionFunctionAbstract|callable $eitherReffuncOrCallable 関数/メソッドリフレクション or callable
     * @return array [引数名 => 引数宣言] の配列
     */
    function function_parameter($eitherReffuncOrCallable)
    {
        $reffunc = $eitherReffuncOrCallable instanceof \ReflectionFunctionAbstract
            ? $eitherReffuncOrCallable
            : reflect_callable($eitherReffuncOrCallable);

        $result = [];
        foreach ($reffunc->getParameters() as $parameter) {
            $declare = '';

            if ($parameter->hasType()) {
                /** @var \ReflectionNamedType $type */
                $type = $parameter->getType();
                $declare .= ($type->allowsNull() ? '?' : '') . ($type->isBuiltin() ? '' : '\\') . $type->getName() . ' ';
            }

            $declare .= ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();

            if ($parameter->isVariadic()) {
                $declare = '...' . $declare;
            }
            elseif ($parameter->isOptional()) {
                // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                if ($parameter->isDefaultValueAvailable()) {
                    // 修飾なしでデフォルト定数が使われているとその名前空間で解決してしまうので場合分けが必要
                    if ($parameter->isDefaultValueConstant() && strpos($parameter->getDefaultValueConstantName(), '\\') === false) {
                        $defval = $parameter->getDefaultValueConstantName();
                    }
                    else {
                        $defval = var_export2($parameter->getDefaultValue(), true);
                    }
                }
                // 「オプショナルだけどデフォルト値がないって有り得るのか？」と思ったが、上記の通り組み込み関数だと普通に有り得るようだ
                // notice が出るので記述せざるを得ないがその値を得る術がない。が、どうせ与えられないので null でいい
                else {
                    $defval = 'null';
                }
                $declare .= ' = ' . $defval;
            }

            $name = ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();
            $result[$name] = $declare;
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\function_parameter") && !defined("ryunosuke\\WebDebugger\\function_parameter")) {
    define("ryunosuke\\WebDebugger\\function_parameter", "ryunosuke\\WebDebugger\\function_parameter");
}

if (!isset($excluded_functions["sql_format"]) && (!function_exists("ryunosuke\\WebDebugger\\sql_format") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\sql_format"))->isInternal()))) {
    /**
     * ものすごく雑に SQL を整形する
     *
     * 非常に荒くアドホックに実装しているのでこの関数で得られた SQL を**実際に実行してはならない**。
     * あくまでログ出力やデバッグ用途で視認性を高める目的である。
     *
     * JOIN 句は FROM 句とみなさず、別句として処理する。
     * AND と && は微妙に処理が異なる。 AND は改行されるが && は改行されない（OR と || も同様）。
     *
     * @param string $sql 整形する SQL
     * @param array $options 整形オプション
     * @return string 整形された SQL
     */
    function sql_format($sql, $options = [])
    {
        static $keywords;
        $keywords = $keywords ?? array_flip(KEYWORDS);

        $options += [
            // インデント文字
            'indent'    => "  ",
            // 括弧の展開レベル
            'nestlevel' => 1,
            // キーワードの大文字/小文字可変換（true だと大文字化。false だと小文字化。あるいは 'ucfirst' 等の文字列関数を直接指定する。クロージャでも良い）
            'case'      => null,
            // シンタックス装飾（true だと SAPI に基づいてよしなに。"html", "cli" だと SAPI を明示的に指定。クロージャだと直接コール）
            'highlight' => null,
            // 最大折返し文字数（未実装）
            'wrapsize'  => false,
        ];
        if ($options['case'] === true) {
            $options['case'] = 'strtoupper';
        }
        elseif ($options['case'] === false) {
            $options['case'] = 'strtolower';
        }

        if ($options['highlight'] === true) {
            $options['highlight'] = php_sapi_name() === 'cli' ? 'cli' : 'html';
        }
        if (is_string($options['highlight'])) {
            $rules = [
                'cli'  => [
                    'KEYWORD' => function ($token) { return "\e[1m" . $token . "\e[m"; },
                    'COMMENT' => function ($token) { return "\e[33m" . $token . "\e[m"; },
                    'STRING'  => function ($token) { return "\e[31m" . $token . "\e[m"; },
                    'NUMBER'  => function ($token) { return "\e[36m" . $token . "\e[m"; },
                ],
                'html' => [
                    'KEYWORD' => function ($token) { return "<span style='font-weight:bold;'>" . htmlspecialchars($token) . "</span>"; },
                    'COMMENT' => function ($token) { return "<span style='color:#FF8000;'>" . htmlspecialchars($token) . "</span>"; },
                    'STRING'  => function ($token) { return "<span style='color:#DD0000;'>" . htmlspecialchars($token) . "</span>"; },
                    'NUMBER'  => function ($token) { return "<span style='color:#0000BB;'>" . htmlspecialchars($token) . "</span>"; },
                ],
            ];
            $rule = $rules[$options['highlight']] ?? throws(new \InvalidArgumentException('highlight must be "cli" or "html".'));
            $options['highlight'] = function ($token, $ttype) use ($keywords, $rule) {
                switch (true) {
                    case isset($keywords[strtoupper($token)]):
                        return $rule['KEYWORD']($token);
                    case in_array($ttype, [T_COMMENT, T_DOC_COMMENT]):
                        return $rule['COMMENT']($token);
                    case in_array($ttype, [T_CONSTANT_ENCAPSED_STRING, T_ENCAPSED_AND_WHITESPACE]):
                        return $rule['STRING']($token);
                    case in_array($ttype, [T_LNUMBER, T_DNUMBER]):
                        return $rule['NUMBER']($token);
                }
                return $token;
            };
        }
        $options['syntaxer'] = function ($token, $ttype) use ($options, $keywords) {
            if ($options['case'] && isset($keywords[strtoupper($token)])) {
                $token = $options['case']($token);
            }
            if ($options['highlight']) {
                $token = $options['highlight']($token, $ttype);
            }
            return $token;
        };

        // 構文解析も先読みもない素朴な実装なので、特定文字列をあとから置換するための目印文字列
        $MARK = "{:RM";
        while (strpos($sql, $MARK) !== false) {
            $MARK .= rand(1000, 9999);
        }
        $MARK_R = "{$MARK}_R:}";   // \r マーク
        $MARK_N = "{$MARK}_N:}";   // \n マーク
        $MARK_BR = "{$MARK}_BR:}"; // 改行マーク
        $MARK_CS = "{$MARK}_CS:}"; // コメント開始マーク
        $MARK_CE = "{$MARK}_CE:}"; // コメント終了マーク
        $MARK_NT = "{$MARK}_NT:}"; // インデントマーク
        $MARK_SP = "{$MARK}_SP:}"; // スペースマーク
        $MARK_PT = "{$MARK}_PT:}"; // 括弧ネストマーク

        // 字句にバラす（シンタックスが php に似ているので token_get_all で大幅にサボることができる）
        $tokens = [];
        $comment = '';
        foreach (token_get_all("<?php $sql") as $token) {
            // トークンは配列だったり文字列だったりするので -1 トークンとして配列に正規化
            if (is_string($token)) {
                $token = [-1, $token];
            }

            // パースのために無理やり <?php を付けているので無視
            if ($token[0] === T_OPEN_TAG) {
                continue;
            }
            // '--' は php ではデクリメントだが sql ではコメントなので特別扱いする
            elseif ($token[0] === T_DEC) {
                $comment = $token[1];
            }
            // 改行は '--' コメントの終わり
            elseif ($comment && in_array($token[0], [T_WHITESPACE, T_COMMENT], true) && strpos($token[1], "\n") !== false) {
                $tokens[] = [T_COMMENT, $comment . $token[1]];
                $comment = '';
            }
            // コメント中はコメントに格納する
            elseif ($comment) {
                $comment .= $token[1];
            }
            // 上記以外はただのトークンとして格納する
            else {
                // `string` のような文字列は T_ENCAPSED_AND_WHITESPACE として得られる（ただし ` がついていないので付与）
                if ($token[0] === T_ENCAPSED_AND_WHITESPACE) {
                    $tokens[] = [$token[0], "`{$token[1]}`"];
                }
                elseif ($token[0] !== T_WHITESPACE && $token[1] !== '`') {
                    $tokens[] = [$token[0], $token[1]];
                }
            }
        }

        // コメント以外の前後のトークンを返すクロージャ
        $seek = function ($start, $step) use ($tokens) {
            $comments = [];
            for ($n = 1; ; $n++) {
                $index = $start + $n * $step;
                if (!isset($tokens[$index])) {
                    break;
                }
                $token = $tokens[$index];
                if ($token[0] === T_COMMENT || $token[0] === T_DOC_COMMENT) {
                    $comments[] = trim($token[1]);
                }
                else {
                    return [$index, trim($token[1]), $comments];
                }
            }
            return [$start, '', $comments];
        };

        $interpret = function (&$index = -1) use (&$interpret, $MARK_R, $MARK_N, $MARK_BR, $MARK_CS, $MARK_CE, $MARK_NT, $MARK_SP, $MARK_PT, $tokens, $options, $seek) {
            $index++;
            $beginning = true; // クエリの冒頭か
            $context = '';     // SELECT, INSERT などの大分類
            $subcontext = '';  // SET, VALUES などのサブ分類
            $modifier = '';    // RIGHT などのキーワード修飾語
            $firstcol = null;  // SELECT における最初の列か

            $result = [];
            for ($token_length = count($tokens); $index < $token_length; $index++) {
                $ttype = $tokens[$index][0];
                $token = trim($tokens[$index][1]);

                $virttoken = $options['syntaxer']($token, $ttype);
                $uppertoken = strtoupper($token);

                // 最終的なインデントは「改行＋スペース」で行うのでリテラル内に改行があるとそれもインデントされてしまうので置換して逃がす
                $token = strtr($token, [
                    "\r" => $MARK_R,
                    "\n" => $MARK_N,
                ]);

                // SELECT の直後には DISTINCT などのオプションが来ることがあるので特別扱い
                if ($context === 'SELECT' && $firstcol) {
                    if (!in_array($uppertoken, ['DISTINCT', 'DISTINCTROW', 'STRAIGHT_JOIN'], true) && !preg_match('#^SQL_#i', $uppertoken)) {
                        $firstcol = false;
                        $result[] = $MARK_BR;
                    }
                }

                // コメントは特別扱いでただ付け足すだけ
                if ($ttype === T_COMMENT || $ttype === T_DOC_COMMENT) {
                    $result[] = ($beginning ? '' : $MARK_CS) . $virttoken . $MARK_CE . $MARK_BR;
                    continue;
                }
                $beginning = false;

                switch ($uppertoken) {
                    default:
                        _DEFAULT:
                        $prev = $seek($index, -1)[1];
                        $next = $seek($index, +1)[1];

                        // "tablename. columnname" になってしまう
                        // "@ var" になってしまう
                        // ": holder" になってしまう
                        if ($prev !== '.' && $prev !== '@' && $prev !== ':') {
                            $result[] = $MARK_SP;
                        }

                        $result[] = $virttoken;

                        // "tablename .columnname" になってしまう
                        // "columnname ," になってしまう
                        // mysql において関数呼び出し括弧の前に空白は許されない
                        // ただし、関数呼び出しではなく記号の場合はスペースを入れたい（ colname = (SELECT ～) など）
                        if (($next !== '.' && $next !== ',' && $next !== '(') || ($next === '(' && !preg_match('#^[a-z0-9_"\'`]+$#i', $token))) {
                            $result[] = $MARK_SP;
                        }
                        break;
                    case "@":
                    case ":":
                        $result[] = $MARK_SP . $virttoken;
                        break;
                    case ";":
                        $result[] = $MARK_BR . $virttoken . $MARK_BR;
                        break;
                    case ".":
                        $result[] = $virttoken;
                        break;
                    case ",":
                        $result[] = $virttoken . $MARK_BR;
                        break;
                    case "WITH":
                        $result[] = $MARK_BR . $virttoken . $MARK_SP;
                        $subcontext = $uppertoken;
                        break;
                    /** @noinspection PhpMissingBreakStatementInspection */
                    case "BETWEEN":
                        $subcontext = $uppertoken;
                        goto _DEFAULT;
                    case "CREATE":
                    case "ALTER":
                    case "DROP":
                        $result[] = $MARK_SP . $virttoken . $MARK_SP;
                        $context = $uppertoken;
                        break;
                    case "TABLE":
                        // CREATE TABLE tablename は括弧があるので何もしなくて済むが、
                        // ALTER TABLE tablename は括弧がなく ADD などで始まるので特別分岐
                        [$index, $name, $comments] = $seek($index, +1);
                        $result[] = $MARK_SP . $virttoken . $MARK_SP . ($MARK_SP . implode('', $comments) . $MARK_CE) . $name . $MARK_SP;
                        if ($context !== 'CREATE' && $context !== 'DROP') {
                            $result[] = $MARK_BR;
                        }
                        break;
                    /** @noinspection PhpMissingBreakStatementInspection */
                    case "AND":
                        // BETWEEN A AND B と論理演算子の AND が競合するので分岐後にフォールスルー
                        if ($subcontext === 'BETWEEN') {
                            $result[] = $MARK_SP . $virttoken . $MARK_SP;
                            $subcontext = '';
                            break;
                        }
                    case "OR":
                    case "XOR":
                        $result[] = $MARK_SP . $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                        break;
                    case "UNION":
                    case "EXCEPT":
                    case "INTERSECT":
                        $result[] = $MARK_BR . $virttoken . $MARK_SP;
                        $result[] = $MARK_BR;
                        break;
                    case "BY":
                    case "ALL":
                        $result[] = $MARK_SP . $virttoken . array_pop($result);
                        break;
                    case "SELECT":
                        if ($context === 'INSERT') {
                            $result[] = $MARK_BR;
                        }
                        $result[] = $virttoken;
                        $context = $uppertoken;
                        $firstcol = true;
                        break;
                    case "LEFT":
                        /** @noinspection PhpMissingBreakStatementInspection */
                    case "RIGHT":
                        // 例えば LEFT や RIGHT は関数呼び出しの場合もあるので分岐後にフォールスルー
                        if ($seek($index, +1)[1] === '(') {
                            goto _DEFAULT;
                        }
                    case "CROSS":
                    case "INNER":
                    case "OUTER":
                        $modifier .= $virttoken . $MARK_SP;
                        break;
                    case "FROM":
                    case "JOIN":
                    case "WHERE":
                    case "HAVING":
                    case "GROUP":
                    case "ORDER":
                    case "LIMIT":
                    case "OFFSET":
                        $result[] = $MARK_BR . $modifier . $virttoken;
                        $result[] = $MARK_BR; // のちの BY のために結合はせず後ろに入れるだけにする
                        $modifier = '';
                        break;
                    case "FOR":
                    case "LOCK":
                        $result[] = $MARK_BR . $virttoken . $MARK_SP;
                        break;
                    case "ON":
                        // ON は ON でも mysql の ON DUPLICATED かもしれない（pgsql の ON CONFLICT も似たようなコンテキスト）
                        $name = $seek($index, +1)[1];
                        if (in_array(strtoupper($name), ['DUPLICATE', 'CONFLICT'], true)) {
                            $result[] = $MARK_BR;
                            $subcontext = '';
                        }
                        else {
                            $result[] = $MARK_SP;
                        }
                        $result[] = $virttoken . $MARK_SP;
                        break;
                    case "SET":
                        $result[] = $MARK_BR . $virttoken . $MARK_BR;
                        $subcontext = $uppertoken;
                        break;
                    case "INSERT":
                    case "REPLACE":
                        $result[] = $virttoken . $MARK_SP;
                        $context = "INSERT"; // 構文的には INSERT と同じ
                        break;
                    case "INTO":
                        $result[] = $virttoken;
                        if ($context === "INSERT") {
                            $result[] = $MARK_BR;
                        }
                        break;
                    case "VALUES":
                        if ($context === "UPDATE") {
                            $result[] = $MARK_SP . $virttoken;
                        }
                        else {
                            $result[] = $MARK_BR . $virttoken . $MARK_BR;
                        }
                        break;
                    case "REFERENCES":
                        $result[] = $MARK_SP . $virttoken . $MARK_SP;
                        $subcontext = $uppertoken;
                        break;
                    case "UPDATE":
                    case "DELETE":
                        $result[] = $MARK_SP . $virttoken;
                        if ($subcontext !== 'REFERENCES') {
                            $result[] = $MARK_BR;
                            $context = $uppertoken;
                        }
                        break;
                    case "WHEN":
                    case "ELSE":
                        $result[] = $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                        break;
                    case "CASE":
                        $parts = $interpret($index);
                        $parts = str_replace($MARK_BR, $MARK_BR . $MARK_NT, $parts);
                        $result[] = $MARK_NT . $virttoken . $MARK_SP . $parts;
                        break;
                    case "END":
                        $result[] = $MARK_BR . $virttoken;
                        break 2;
                    case "(":
                        $current = $index;
                        $parts = $MARK_BR . $interpret($index);

                        // コメントを含まない指定ネストレベル以下なら改行とインデントを吹き飛ばす
                        if (strpos($parts, $MARK_CE) === false && substr_count($parts, $MARK_PT) < $options['nestlevel']) {
                            $parts = strtr($parts, [
                                $MARK_BR => "",
                                $MARK_NT => "",
                            ]);
                            $parts = preg_replace("#^($MARK_SP)|($MARK_SP)+$#u", '', $parts);
                        }
                        elseif ($context === 'CREATE') {
                            $parts = $parts . $MARK_BR;
                        }
                        else {
                            $brnt = $MARK_BR . $MARK_NT;
                            if ($subcontext !== 'WITH' && strtoupper($seek($current, +1)[1]) === 'SELECT') {
                                $brnt .= $MARK_NT;
                            }
                            $parts = preg_replace("#($MARK_BR)+#u", $brnt, $parts) . $MARK_BR . $MARK_NT;
                            $parts = preg_replace("#$MARK_CS#u", "", $parts);
                        }

                        // IN や数式はネストとみなさない
                        $prev = $seek($current, -1)[1];
                        $suffix = $MARK_PT;
                        if (strtoupper($prev) === 'IN' || !preg_match('#^[a-z0-9_]+$#i', $prev)) {
                            $suffix = '';
                        }
                        if ($subcontext === 'WITH') {
                            $suffix .= $MARK_BR;
                        }

                        $result[] = $MARK_NT . "($parts)" . $suffix;
                        break;
                    case ")":
                        break 2;
                }
            }
            return implode('', $result);
        };

        $result = $interpret();
        $result = preg_replaces("#" . implode('|', [
                // 改行文字＋インデント文字をインデントとみなす（改行＋連続スペースもついでに）
                "(?<indent>$MARK_BR(($MARK_NT|$MARK_SP)+))",
                // 行末コメントと単一コメント
                "(?<cs1>$MARK_BR$MARK_CS)",
                "(?<cs2>$MARK_CS)",
                // 連続改行は1つに集約
                "(?<br>$MARK_BR(($MARK_NT|$MARK_SP)*)($MARK_BR)*)",
                // 連続スペースは1つに集約
                "(?<sp>($MARK_SP)+)",
                // 下記はマーカ文字が現れないように単純置換
                "(?<ce>$MARK_CE)",
                "(?<nt>$MARK_NT)",
                "(?<pt>$MARK_PT)",
                "(?<R>$MARK_R)",
                "(?<N>$MARK_N)",
            ]) . "#u", [
            'indent' => function ($str) use ($options, $MARK_NT, $MARK_SP) {
                return "\n" . str_repeat($options['indent'], (substr_count($str, $MARK_NT) + substr_count($str, $MARK_SP)));
            },
            'cs1'    => "\n" . $options['indent'],
            'cs2'    => "",
            'br'     => "\n",
            'sp'     => ' ',
            'ce'     => "",
            'nt'     => "",
            'pt'     => "",
            'R'      => "\r",
            'N'      => "\n",
        ], $result);

        return trim($result);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\sql_format") && !defined("ryunosuke\\WebDebugger\\sql_format")) {
    define("ryunosuke\\WebDebugger\\sql_format", "ryunosuke\\WebDebugger\\sql_format");
}

if (!isset($excluded_functions["multiexplode"]) && (!function_exists("ryunosuke\\WebDebugger\\multiexplode") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\multiexplode"))->isInternal()))) {
    /**
     * explode の配列対応と $limit の挙動を変えたもの
     *
     * $delimiter には配列が使える。いわゆる「複数文字列での分割」の動作になる。
     *
     * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
     * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
     *
     * Example:
     * ```php
     * // 配列を与えると複数文字列での分割
     * that(multiexplode([',', ' ', '|'], 'a,b c|d'))->isSame(['a', 'b', 'c', 'd']);
     * // 負数を与えると前詰め
     * that(multiexplode(',', 'a,b,c,d', -2))->isSame(['a,b,c', 'd']);
     * // もちろん上記2つは共存できる
     * that(multiexplode([',', ' ', '|'], 'a,b c|d', -2))->isSame(['a,b c', 'd']);
     * ```
     *
     * @param string|array $delimiter 分割文字列。配列可
     * @param string $string 対象文字列
     * @param int $limit 分割数
     * @return array 分割された配列
     */
    function multiexplode($delimiter, $string, $limit = \PHP_INT_MAX)
    {
        $limit = (int) $limit;
        if ($limit < 0) {
            // 下手に php で小細工するよりこうやって富豪的にやるのが一番速かった
            return array_reverse(array_map('strrev', multiexplode($delimiter, strrev($string), -$limit)));
        }
        // explode において 0 は 1 と等しい
        if ($limit === 0) {
            $limit = 1;
        }
        $delimiter = array_map(function ($v) { return preg_quote($v, '#'); }, arrayize($delimiter));
        return preg_split('#' . implode('|', $delimiter) . '#', $string, $limit);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\multiexplode") && !defined("ryunosuke\\WebDebugger\\multiexplode")) {
    define("ryunosuke\\WebDebugger\\multiexplode", "ryunosuke\\WebDebugger\\multiexplode");
}

if (!isset($excluded_functions["preg_replaces"]) && (!function_exists("ryunosuke\\WebDebugger\\preg_replaces") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\preg_replaces"))->isInternal()))) {
    /**
     * パターン番号を指定して preg_replace する
     *
     * パターン番号を指定してそれのみを置換する。
     * 名前付きキャプチャを使用している場合はキーに文字列も使える。
     * 値にクロージャを渡した場合はコールバックされて置換される。
     *
     * $replacements に単一文字列を渡した場合、 `[1 => $replacements]` と等しくなる（第1キャプチャを置換）。
     *
     * Example:
     * ```php
     * // a と z に囲まれた数字を XXX に置換する
     * that(preg_replaces('#a(\d+)z#', [1 => 'XXX'], 'a123z'))->isSame('aXXXz');
     * // 名前付きキャプチャも指定できる
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => 'XXX'], 'a123z'))->isSame('aXXXz');
     * // クロージャを渡すと元文字列を引数としてコールバックされる
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => function($src){return $src * 2;}], 'a123z'))->isSame('a246z');
     * // 複合的なサンプル（a タグの href と target 属性を書き換える）
     * that(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
     *     'href'   => function($href){return strtoupper($href);},
     *     'target' => function($target){return strtoupper($target);},
     * ], '<a href="hoge" target="fuga">inner text</a>'))->isSame('<a href="HOGE" target="FUGA">inner text</a>');
     * ```
     *
     * @param string $pattern 正規表現
     * @param array|string $replacements 置換文字列
     * @param string $subject 対象文字列
     * @param int $limit 置換回数
     * @param null $count 置換回数格納変数
     * @return string 置換された文字列
     */
    function preg_replaces($pattern, $replacements, $subject, $limit = -1, &$count = null)
    {
        $offset = 0;
        $count = 0;
        if (!is_arrayable($replacements)) {
            $replacements = [1 => $replacements];
        }

        preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($matches as $match) {
            if ($limit-- === 0) {
                break;
            }
            $count++;

            foreach ($match as $index => $m) {
                if ($m[1] >= 0 && $index !== 0 && isset($replacements[$index])) {
                    $src = $m[0];
                    $dst = $replacements[$index];
                    if ($dst instanceof \Closure) {
                        $dst = $dst($src);
                    }

                    $srclen = strlen($src);
                    $dstlen = strlen($dst);

                    $subject = substr_replace($subject, $dst, $offset + $m[1], $srclen);
                    $offset += $dstlen - $srclen;
                }
            }
        }
        return $subject;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\preg_replaces") && !defined("ryunosuke\\WebDebugger\\preg_replaces")) {
    define("ryunosuke\\WebDebugger\\preg_replaces", "ryunosuke\\WebDebugger\\preg_replaces");
}

if (!isset($excluded_functions["evaluate"]) && (!function_exists("ryunosuke\\WebDebugger\\evaluate") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\evaluate"))->isInternal()))) {
    /**
     * eval のプロキシ関数
     *
     * 一度ファイルに吐いてから require した方が opcache が効くので抜群に速い。
     * また、素の eval は ParseError が起こったときの表示がわかりにくすぎるので少し見やすくしてある。
     *
     * 関数化してる以上 eval におけるコンテキストの引き継ぎはできない。
     * ただし、引数で変数配列を渡せるようにしてあるので get_defined_vars を併用すれば基本的には同じ（$this はどうしようもない）。
     *
     * 短いステートメントだと opcode が少ないのでファイルを経由せず直接 eval したほうが速いことに留意。
     * 一応引数で指定できるようにはしてある。
     *
     * Example:
     * ```php
     * $a = 1;
     * $b = 2;
     * $phpcode = ';
     * $c = $a + $b;
     * return $c * 3;
     * ';
     * that(evaluate($phpcode, get_defined_vars()))->isSame(9);
     * ```
     *
     * @param string $phpcode 実行する php コード
     * @param array $contextvars コンテキスト変数配列
     * @param int $cachesize キャッシュするサイズ
     * @return mixed eval の return 値
     */
    function evaluate($phpcode, $contextvars = [], $cachesize = 256)
    {
        $cachefile = null;
        if ($cachesize && strlen($phpcode) >= $cachesize) {
            $cachefile = cachedir() . '/' . rawurlencode(__FUNCTION__) . '-' . sha1($phpcode) . '.php';
            if (!file_exists($cachefile)) {
                file_put_contents($cachefile, "<?php $phpcode", LOCK_EX);
            }
        }

        try {
            if ($cachefile) {
                return (static function () {
                    extract(func_get_arg(1));
                    return require func_get_arg(0);
                })($cachefile, $contextvars);
            }
            else {
                return (static function () {
                    extract(func_get_arg(1));
                    return eval(func_get_arg(0));
                })($phpcode, $contextvars);
            }
        }
        catch (\ParseError $ex) {
            $errline = $ex->getLine();
            $errline_1 = $errline - 1;
            $codes = preg_split('#\\R#u', $phpcode);
            $codes[$errline_1] = '>>> ' . $codes[$errline_1];

            $N = 5; // 前後の行数
            $message = $ex->getMessage();
            $message .= "\n" . implode("\n", array_slice($codes, max(0, $errline_1 - $N), $N * 2 + 1));
            if ($cachefile) {
                $message .= "\n in " . realpath($cachefile) . " on line " . $errline . "\n";
            }
            throw new \ParseError($message, $ex->getCode(), $ex);
        }
    }
}
if (function_exists("ryunosuke\\WebDebugger\\evaluate") && !defined("ryunosuke\\WebDebugger\\evaluate")) {
    define("ryunosuke\\WebDebugger\\evaluate", "ryunosuke\\WebDebugger\\evaluate");
}

if (!isset($excluded_functions["parse_php"]) && (!function_exists("ryunosuke\\WebDebugger\\parse_php") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\parse_php"))->isInternal()))) {
    /**
     * php のコード断片をパースする
     *
     * 結果配列は token_get_all したものだが、「字句の場合に文字列で返す」仕様は適用されずすべて配列で返す。
     * つまり必ず `[TOKENID, TOKEN, LINE]` で返す。
     *
     * Example:
     * ```php
     * $phpcode = 'namespace Hogera;
     * class Example
     * {
     *     // something
     * }';
     *
     * // namespace ～ ; を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_NAMESPACE,
     *     'end'   => ';',
     * ]);
     * that(implode('', array_column($part, 1)))->isSame('namespace Hogera;');
     *
     * // class ～ { を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_CLASS,
     *     'end'   => '{',
     * ]);
     * that(implode('', array_column($part, 1)))->isSame("class Example\n{");
     * ```
     *
     * @param string $phpcode パースする php コード
     * @param array|int $option パースオプション
     * @return array トークン配列
     */
    function parse_php($phpcode, $option = [])
    {
        if (is_int($option)) {
            $option = ['flags' => $option];
        }

        $default = [
            'begin'      => [],   // 開始トークン
            'end'        => [],   // 終了トークン
            'offset'     => 0,    // 開始トークン位置
            'flags'      => 0,    // token_get_all の $flags. TOKEN_PARSE を与えると ParseError が出ることがあるのでデフォルト 0
            'cache'      => true, // キャッシュするか否か
            'nest_token' => [
                ')' => '(',
                '}' => '{',
                ']' => '[',
            ],
        ];
        $option += $default;

        static $cache = [];
        $tokens = $cache[$phpcode] ?? array_map(function ($token) use ($option) {
                // token_get_all の結果は微妙に扱いづらいので少し調整する（string/array だったり、名前変換の必要があったり）
                if (is_array($token)) {
                    // for debug
                    if ($option['flags'] & TOKEN_NAME) {
                        $token[] = token_name($token[0]);
                    }
                    return $token;
                }
                else {
                    // string -> [TOKEN, CHAR, LINE]
                    return [null, $token, 0];
                }
            }, token_get_all("<?php $phpcode", $option['flags']));
        if ($option['cache']) {
            $cache[$phpcode] = $tokens;
        }

        $begin_tokens = (array) $option['begin'];
        $end_tokens = (array) $option['end'];
        $nest_tokens = $option['nest_token'];

        $result = [];
        $starting = !$begin_tokens;
        $nesting = 0;
        for ($i = $option['offset'], $l = count($tokens); $i < $l; $i++) {
            $token = $tokens[$i];

            foreach ($begin_tokens as $t) {
                if ($t === $token[0] || $t === $token[1]) {
                    $starting = true;
                    break;
                }
            }
            if (!$starting) {
                continue;
            }

            $result[$i] = $token;

            foreach ($end_tokens as $t) {
                if (isset($nest_tokens[$t])) {
                    $nest_token = $nest_tokens[$t];
                    if ($token[0] === $nest_token || $token[1] === $nest_token) {
                        $nesting++;
                    }
                }
                if ($t === $token[0] || $t === $token[1]) {
                    $nesting--;
                    if ($nesting <= 0) {
                        break 2;
                    }
                    break;
                }
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\parse_php") && !defined("ryunosuke\\WebDebugger\\parse_php")) {
    define("ryunosuke\\WebDebugger\\parse_php", "ryunosuke\\WebDebugger\\parse_php");
}

if (!isset($excluded_functions["throws"]) && (!function_exists("ryunosuke\\WebDebugger\\throws") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\throws"))->isInternal()))) {
    /**
     * throw の関数版
     *
     * hoge() or throw などしたいことがまれによくあるはず。
     *
     * Example:
     * ```php
     * try {
     *     throws(new \Exception('throws'));
     * }
     * catch (\Exception $ex) {
     *     that($ex->getMessage())->isSame('throws');
     * }
     * ```
     *
     * @param \Exception $ex 投げる例外
     * @return mixed （`return hoge or throws` のようなコードで警告が出るので抑止用）
     */
    function throws($ex)
    {
        throw $ex;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\throws") && !defined("ryunosuke\\WebDebugger\\throws")) {
    define("ryunosuke\\WebDebugger\\throws", "ryunosuke\\WebDebugger\\throws");
}

if (!isset($excluded_functions["get_uploaded_files"]) && (!function_exists("ryunosuke\\WebDebugger\\get_uploaded_files") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\get_uploaded_files"))->isInternal()))) {
    /**
     * $_FILES の構造を組み替えて $_POST などと同じにする
     *
     * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
     * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
     *
     * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
     *
     * @param array $files $_FILES の同じ構造の配列。省略時は $_FILES
     * @return array $_FILES を $_POST などと同じ構造にした配列
     */
    function get_uploaded_files($files = null)
    {
        $result = [];
        foreach (($files ?: $_FILES) as $name => $file) {
            if (is_array($file['name'])) {
                $file = get_uploaded_files(array_each($file['name'], function (&$carry, $dummy, $subkey) use ($file) {
                    $carry[$subkey] = array_lookup($file, $subkey);
                }, []));
            }
            $result[$name] = $file;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\get_uploaded_files") && !defined("ryunosuke\\WebDebugger\\get_uploaded_files")) {
    define("ryunosuke\\WebDebugger\\get_uploaded_files", "ryunosuke\\WebDebugger\\get_uploaded_files");
}

if (!isset($excluded_functions["cachedir"]) && (!function_exists("ryunosuke\\WebDebugger\\cachedir") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\cachedir"))->isInternal()))) {
    /**
     * 本ライブラリで使用するキャッシュディレクトリを設定する
     *
     * @param string|null $dirname キャッシュディレクトリ。省略時は返すのみ
     * @return string 設定前のキャッシュディレクトリ
     */
    function cachedir($dirname = null)
    {
        static $cachedir;
        if ($cachedir === null) {
            $cachedir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . strtr(__NAMESPACE__, ['\\' => '%']);
            cachedir($cachedir); // for mkdir
        }

        if ($dirname === null) {
            return $cachedir;
        }

        if (!file_exists($dirname)) {
            @mkdir($dirname, 0777 & (~umask()), true);
        }
        $result = $cachedir;
        $cachedir = realpath($dirname);
        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\cachedir") && !defined("ryunosuke\\WebDebugger\\cachedir")) {
    define("ryunosuke\\WebDebugger\\cachedir", "ryunosuke\\WebDebugger\\cachedir");
}

if (!isset($excluded_functions["cache"]) && (!function_exists("ryunosuke\\WebDebugger\\cache") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\cache"))->isInternal()))) {
    /**
     * シンプルにキャッシュする
     *
     * この関数は get/set/delete を兼ねる。
     * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
     *
     * $provider に null を与えるとキャッシュの削除となる。
     *
     * Example:
     * ```php
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * that($rand1)->isSame($rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * that($rand1)->isNotSame($rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param string $namespace 名前空間
     * @return mixed キャッシュ
     */
    function cache($key, $provider, $namespace = null)
    {
        static $cacheobject;
        $cacheobject = $cacheobject ?? new class(cachedir()) {
                const CACHE_EXT = '.php-cache';

                /** @var string キャッシュディレクトリ */
                private $cachedir;

                /** @var array 内部キャッシュ */
                private $cache;

                /** @var array 変更感知配列 */
                private $changed;

                public function __construct($cachedir)
                {
                    $this->cachedir = $cachedir;
                    $this->cache = [];
                    $this->changed = [];
                }

                public function __destruct()
                {
                    // 変更されているもののみ保存
                    foreach ($this->changed as $namespace => $dummy) {
                        $filepath = $this->cachedir . '/' . rawurlencode($namespace) . self::CACHE_EXT;
                        $content = "<?php\nreturn " . var_export($this->cache[$namespace], true) . ";\n";

                        $temppath = tempnam(sys_get_temp_dir(), 'cache');
                        if (file_put_contents($temppath, $content) !== false) {
                            @chmod($temppath, 0644);
                            if (!@rename($temppath, $filepath)) {
                                @unlink($temppath);
                            }
                        }
                    }
                }

                public function has($namespace, $key)
                {
                    // ファイルから読み込む必要があるので get しておく
                    $this->get($namespace, $key);
                    return array_key_exists($key, $this->cache[$namespace]);
                }

                public function get($namespace, $key)
                {
                    // 名前空間自体がないなら作る or 読む
                    if (!isset($this->cache[$namespace])) {
                        $nsarray = [];
                        $cachpath = $this->cachedir . '/' . rawurldecode($namespace) . self::CACHE_EXT;
                        if (file_exists($cachpath)) {
                            $nsarray = require $cachpath;
                        }
                        $this->cache[$namespace] = $nsarray;
                    }

                    return $this->cache[$namespace][$key] ?? null;
                }

                public function set($namespace, $key, $value)
                {
                    // 新しい値が来たら変更フラグを立てる
                    if (!isset($this->cache[$namespace]) || !array_key_exists($key, $this->cache[$namespace]) || $this->cache[$namespace][$key] !== $value) {
                        $this->changed[$namespace] = true;
                    }

                    $this->cache[$namespace][$key] = $value;
                }

                public function delete($namespace, $key)
                {
                    $this->changed[$namespace] = true;
                    unset($this->cache[$namespace][$key]);
                }

                public function clear()
                {
                    // インメモリ情報をクリアして・・・
                    $this->cache = [];
                    $this->changed = [];

                    // ファイルも消す
                    foreach (glob($this->cachedir . '/*' . self::CACHE_EXT) as $file) {
                        unlink($file);
                    }
                }
            };

        // flush (for test)
        if ($key === null) {
            if ($provider === null) {
                $cacheobject->clear();
            }
            $cacheobject = null;
            return;
        }

        $namespace = $namespace ?? __FILE__;

        $exist = $cacheobject->has($namespace, $key);
        if ($provider === null) {
            $cacheobject->delete($namespace, $key);
            return $exist;
        }
        if (!$exist) {
            $cacheobject->set($namespace, $key, $provider());
        }
        return $cacheobject->get($namespace, $key);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\cache") && !defined("ryunosuke\\WebDebugger\\cache")) {
    define("ryunosuke\\WebDebugger\\cache", "ryunosuke\\WebDebugger\\cache");
}

if (!isset($excluded_functions["is_ansi"]) && (!function_exists("ryunosuke\\WebDebugger\\is_ansi") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\is_ansi"))->isInternal()))) {
    /**
     * リソースが ansi color に対応しているか返す
     *
     * パイプしたりリダイレクトしていると false を返す。
     *
     * @see https://github.com/symfony/console/blob/v4.2.8/Output/StreamOutput.php#L98
     *
     * @param resource $stream 調べるリソース
     * @return bool ansi color に対応しているなら true
     */
    function is_ansi($stream)
    {
        // テスト用に隠し引数で DS を取っておく
        $DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;
        assert(!!$DIRECTORY_SEPARATOR = func_num_args() > 1 ? func_get_arg(1) : $DIRECTORY_SEPARATOR);

        if ('Hyper' === getenv('TERM_PROGRAM')) {
            return true;
        }

        if ($DIRECTORY_SEPARATOR === '\\') {
            return (\function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support($stream))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        return @stream_isatty($stream);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\is_ansi") && !defined("ryunosuke\\WebDebugger\\is_ansi")) {
    define("ryunosuke\\WebDebugger\\is_ansi", "ryunosuke\\WebDebugger\\is_ansi");
}

if (!isset($excluded_functions["ansi_colorize"]) && (!function_exists("ryunosuke\\WebDebugger\\ansi_colorize") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\ansi_colorize"))->isInternal()))) {
    /**
     * 文字列に ANSI Color エスケープシーケンスを埋め込む
     *
     * - "blue" のような小文字色名は文字色
     * - "BLUE" のような大文字色名は背景色
     * - "bold" のようなスタイル名は装飾
     *
     * となる。その区切り文字は現在のところ厳密に定めていない（`fore+back|bold` のような形式で定めることも考えたけどメリットがない）。
     * つまり、アルファベット以外で分割するので、
     *
     * - `blue|WHITE@bold`: 文字青・背景白・太字
     * - `blue WHITE bold underscore`: 文字青・背景白・太字・下線
     * - `italic|bold,blue+WHITE  `: 文字青・背景白・太字・斜体
     *
     * という動作になる（記号で区切られていれば形式はどうでも良いということ）。
     * ただ、この指定方法は変更が入る可能性が高いのでスペースあたりで区切っておくのがもっとも無難。
     *
     * @param string $string 対象文字列
     * @param string $color 色とスタイル文字列
     * @return string エスケープシーケンス付きの文字列
     */
    function ansi_colorize($string, $color)
    {
        // see https://en.wikipedia.org/wiki/ANSI_escape_code#SGR_parameters
        // see https://misc.flogisoft.com/bash/tip_colors_and_formatting
        $ansicodes = [
            // forecolor
            'default'    => [39, 39],
            'black'      => [30, 39],
            'red'        => [31, 39],
            'green'      => [32, 39],
            'yellow'     => [33, 39],
            'blue'       => [34, 39],
            'magenta'    => [35, 39],
            'cyan'       => [36, 39],
            'white'      => [97, 39],
            'gray'       => [90, 39],
            // backcolor
            'DEFAULT'    => [49, 49],
            'BLACK'      => [40, 49],
            'RED'        => [41, 49],
            'GREEN'      => [42, 49],
            'YELLOW'     => [43, 49],
            'BLUE'       => [44, 49],
            'MAGENTA'    => [45, 49],
            'CYAN'       => [46, 49],
            'WHITE'      => [47, 49],
            'GRAY'       => [100, 49],
            // style
            'bold'       => [1, 22],
            'faint'      => [2, 22], // not working ?
            'italic'     => [3, 23],
            'underscore' => [4, 24],
            'blink'      => [5, 25],
            'reverse'    => [7, 27],
            'conceal'    => [8, 28],
        ];

        $names = array_flip(preg_split('#[^a-z]#i', $color));
        $styles = array_intersect_key($ansicodes, $names);
        $setters = implode(';', array_column($styles, 0));
        $unsetters = implode(';', array_column($styles, 1));
        return "\033[{$setters}m{$string}\033[{$unsetters}m";
    }
}
if (function_exists("ryunosuke\\WebDebugger\\ansi_colorize") && !defined("ryunosuke\\WebDebugger\\ansi_colorize")) {
    define("ryunosuke\\WebDebugger\\ansi_colorize", "ryunosuke\\WebDebugger\\ansi_colorize");
}

if (!isset($excluded_functions["stacktrace"]) && (!function_exists("ryunosuke\\WebDebugger\\stacktrace") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\stacktrace"))->isInternal()))) {
    /**
     * スタックトレースを文字列で返す
     *
     * `(new \Exception())->getTraceAsString()` と実質的な役割は同じ。
     * ただし、 getTraceAsString は引数が Array になったりクラス名しか取れなかったり微妙に使い勝手が悪いのでもうちょっと情報量を増やしたもの。
     *
     * 第1引数 $traces はトレース的配列を受け取る（`(new \Exception())->getTrace()` とか）。
     * 未指定時は debug_backtrace() で採取する。
     *
     * 第2引数 $option は文字列化する際の設定を指定する。
     * 情報量が増える分、機密も含まれる可能性があるため、 mask オプションで塗りつぶすキーや引数名を指定できる（クロージャの引数までは手出ししないため留意）。
     * limit と format は比較的指定頻度が高いかつ互換性維持のため配列オプションではなく直に渡すことが可能になっている。
     *
     * @param array $traces debug_backtrace 的な配列
     * @param int|string|array $option オプション
     * @return string|array トレース文字列（delimiter オプションに null を渡すと配列で返す）
     */
    function stacktrace($traces = null, $option = [])
    {
        if (is_int($option)) {
            $option = ['limit' => $option];
        }
        elseif (is_string($option)) {
            $option = ['format' => $option];
        }

        $option += [
            'format'    => '%s:%s %s', // 文字列化するときの sprintf フォーマット
            'args'      => true,       // 引数情報を埋め込むか否か
            'limit'     => 16,         // 配列や文字列を千切る長さ
            'delimiter' => "\n",       // スタックトレースの区切り文字（null で配列になる）
            'mask'      => ['#^password#', '#^secret#', '#^credential#', '#^credit#'],
        ];
        $limit = $option['limit'];
        $maskregexs = (array) $option['mask'];
        $mask = static function ($key, $value) use ($maskregexs) {
            if (!is_string($value)) {
                return $value;
            }
            foreach ($maskregexs as $regex) {
                if (preg_match($regex, $key)) {
                    return str_repeat('*', strlen($value));
                }
            }
            return $value;
        };

        $stringify = static function ($value) use ($limit, $mask) {
            // 再帰用クロージャ
            $export = static function ($value, $nest = 0, $parents = []) use (&$export, $limit, $mask) {
                // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
                foreach ($parents as $parent) {
                    if ($parent === $value) {
                        return var_export('*RECURSION*', true);
                    }
                }
                // 配列は連想判定したり再帰したり色々
                if (is_array($value)) {
                    $parents[] = $value;
                    $flat = $value === array_values($value);
                    $kvl = [];
                    foreach ($value as $k => $v) {
                        if (count($kvl) >= $limit) {
                            $kvl[] = sprintf('...(more %d length)', count($value) - $limit);
                            break;
                        }
                        $kvl[] = ($flat ? '' : $k . ':') . $export(call_user_func($mask, $k, $v), $nest + 1, $parents);
                    }
                    return ($flat ? '[' : '{') . implode(', ', $kvl) . ($flat ? ']' : '}');
                }
                // オブジェクトは単にプロパティを配列的に出力する
                elseif (is_object($value)) {
                    $parents[] = $value;
                    return get_class($value) . $export(get_object_properties($value), $nest, $parents);
                }
                // 文字列は改行削除
                elseif (is_string($value)) {
                    $value = str_replace(["\r\n", "\r", "\n"], '\n', $value);
                    if (($strlen = strlen($value)) > $limit) {
                        $value = substr($value, 0, $limit) . sprintf('...(more %d length)', $strlen - $limit);
                    }
                    return '"' . addcslashes($value, "\"\0\\") . '"';
                }
                // それ以外は stringify
                else {
                    return stringify($value);
                }
            };

            return $export($value);
        };

        $traces = $traces ?? array_slice(debug_backtrace(), 1);
        $result = [];
        foreach ($traces as $i => $trace) {
            // メソッド内で関数定義して呼び出したりすると file が無いことがある（かなりレアケースなので無視する）
            if (!isset($trace['file'])) {
                continue; // @codeCoverageIgnore
            }

            $file = $trace['file'];
            $line = $trace['line'];
            if (strpos($trace['file'], "eval()'d code") !== false && ($traces[$i + 1]['function'] ?? '') === 'eval') {
                $file = $traces[$i + 1]['file'];
                $line = $traces[$i + 1]['line'] . "." . $trace['line'];
            }

            if (isset($trace['type'])) {
                $callee = $trace['class'] . $trace['type'] . $trace['function'];
                if ($option['args'] && $maskregexs && method_exists($trace['class'], $trace['function'])) {
                    $ref = new \ReflectionMethod($trace['class'], $trace['function']);
                }
            }
            else {
                $callee = $trace['function'];
                if ($option['args'] && $maskregexs && function_exists($callee)) {
                    $ref = new \ReflectionFunction($trace['function']);
                }
            }
            $args = [];
            if ($option['args']) {
                $args = $trace['args'] ?? [];
                if (isset($ref)) {
                    $params = $ref->getParameters();
                    foreach ($params as $n => $param) {
                        if (array_key_exists($n, $args)) {
                            $args[$n] = $mask($param->getName(), $args[$n]);
                        }
                    }
                }
            }
            $callee .= '(' . implode(', ', array_map($stringify, $args)) . ')';

            $result[] = sprintf($option['format'], $file, $line, $callee);
        }
        if ($option['delimiter'] === null) {
            return $result;
        }
        return implode($option['delimiter'], $result);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\stacktrace") && !defined("ryunosuke\\WebDebugger\\stacktrace")) {
    define("ryunosuke\\WebDebugger\\stacktrace", "ryunosuke\\WebDebugger\\stacktrace");
}

if (!isset($excluded_functions["backtrace"]) && (!function_exists("ryunosuke\\WebDebugger\\backtrace") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\backtrace"))->isInternal()))) {
    /**
     * 特定条件までのバックトレースを取得する
     *
     * 第2引数 $options を満たすトレース以降を返す。
     * $options は ['$trace の key' => "条件"] を渡す。
     * 条件は文字列かクロージャで、文字列の場合は緩い一致、クロージャの場合は true を返した場合にそれ以降を返す。
     *
     * Example:
     * ```php
     * function f001 () {return backtrace(0, ['function' => __NAMESPACE__ . '\\f002', 'limit' => 2]);}
     * function f002 () {return f001();}
     * function f003 () {return f002();}
     * $traces = f003();
     * // limit 指定してるので2個
     * that($traces)->count(2);
     * // 「function が f002 以降」を返す
     * that($traces[0])->arraySubset([
     *     'function' => __NAMESPACE__ . '\\f002'
     * ]);
     * that($traces[1])->arraySubset([
     *     'function' => __NAMESPACE__ . '\\f003'
     * ]);
     * ```
     *
     * @param int $flags debug_backtrace の引数
     * @param array $options フィルタ条件
     * @return array バックトレース
     */
    function backtrace($flags = \DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = [])
    {
        $result = [];
        $traces = debug_backtrace($flags);
        foreach ($traces as $n => $trace) {
            foreach ($options as $key => $val) {
                if (!isset($trace[$key])) {
                    continue;
                }

                if ($val instanceof \Closure) {
                    $break = $val($trace[$key]);
                }
                else {
                    $break = $trace[$key] == $val;
                }
                if ($break) {
                    $result = array_slice($traces, $n);
                    break 2;
                }
            }
        }

        // offset, limit は特別扱いで千切り指定
        if (isset($options['offset']) || isset($options['limit'])) {
            $result = array_slice($result, $options['offset'] ?? 0, $options['limit'] ?? count($result));
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\backtrace") && !defined("ryunosuke\\WebDebugger\\backtrace")) {
    define("ryunosuke\\WebDebugger\\backtrace", "ryunosuke\\WebDebugger\\backtrace");
}

if (!isset($excluded_functions["profiler"]) && (!function_exists("ryunosuke\\WebDebugger\\profiler") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\profiler"))->isInternal()))) {
    /**
     * 外部ツールに頼らない pure php なプロファイラを返す
     *
     * file プロトコル上書きと ticks と debug_backtrace によるかなり無理のある実装なので動かない環境・コードは多い。
     * その分お手軽だが下記の注意点がある。
     *
     * - file プロトコルを上書きするので、既に読み込み済みのファイルは計上されない
     * - tick されないステートメントは計上されない
     *     - 1行メソッドなどでありがち
     * - A->B->C という呼び出しで C が 3秒、B が 2秒、A が1秒かかった場合、 A は 6 秒、B は 5秒、C は 3 秒といて計上される
     *     - つまり、配下の呼び出しも重複して計上される
     *
     * この関数を呼んだ時点で計測は始まる。
     * 返り値としてイテレータを返すので、foreach で回せばコールスタック・回数・時間などが取得できる。
     * 配列で欲しい場合は直に呼べば良い。
     *
     * @param array $options オプション配列
     * @return \Traversable|callable プロファイライテレータ
     */
    function profiler($options = [])
    {
        $declareProtocol = new
        /**
         * @method opendir($path, $context = null)
         * @method touch($filename, $time = null, $atime = null)
         * @method chmod($filename, $mode)
         * @method chown($filename, $user)
         * @method chgrp($filename, $group)
         * @method fopen($filename, $mode, $use_include_path = false, $context = null)
         */
        class {
            /** @var int https://github.com/php/php-src/blob/php-7.2.11/main/php_streams.h#L528-L529 */
            private const STREAM_OPEN_FOR_INCLUDE = 0x00000080;

            /** @var resource https://www.php.net/manual/class.streamwrapper.php */
            public $context;

            private $require;
            private $handle;

            public function __call($name, $arguments)
            {
                $fname = preg_replace(['#^dir_#', '#^stream_#'], ['', 'f'], $name, 1, $count);
                if ($count) {
                    // flock は特別扱い（file_put_contents (LOCK_EX) を呼ぶと 0 で来ることがある）
                    // __call で特別扱いもおかしいけど、個別に定義するほうが逆にわかりにくい
                    if ($fname === 'flock' && ($arguments[0] ?? null) === 0) {
                        return true;
                    }
                    return $fname($this->handle, ...$arguments);
                }

                stream_wrapper_restore('file');
                try {
                    switch ($name) {
                        default:
                            // mkdir, rename, unlink, ...
                            return $name(...$arguments);
                        case 'rmdir':
                            [$path, $options] = $arguments + [1 => 0];
                            assert(isset($options)); // @todo It is used?
                            return rmdir($path, $this->context);
                        case 'url_stat':
                            [$path, $flags] = $arguments + [1 => 0];
                            if ($flags & STREAM_URL_STAT_LINK) {
                                $func = 'lstat';
                            }
                            else {
                                $func = 'stat';
                            }
                            if ($flags & STREAM_URL_STAT_QUIET) {
                                return @$func($path);
                            }
                            else {
                                return $func($path);
                            }
                    }
                }
                finally {
                    stream_wrapper_unregister('file');
                    stream_wrapper_register('file', get_class($this));
                }
            }

            public function dir_opendir($path, $options)
            {
                return !!$this->handle = $this->opendir(...$this->context ? [$path, $this->context] : [$path]);
            }

            public function stream_open($path, $mode, $options, &$opened_path)
            {
                $use_path = $options & STREAM_USE_PATH;
                $this->require = $options & self::STREAM_OPEN_FOR_INCLUDE;
                if ($options & STREAM_REPORT_ERRORS) {
                    $this->handle = $this->fopen($path, $mode, $use_path); // @codeCoverageIgnore
                }
                else {
                    $this->handle = @$this->fopen($path, $mode, $use_path);
                }
                if ($use_path && $this->handle) {
                    $opened_path = stream_get_meta_data($this->handle)['uri']; // @codeCoverageIgnore
                }
                return !!$this->handle;
            }

            public function stream_read($count)
            {
                $DECLARE = "<?php declare(ticks=1) ?>";

                $pos = ftell($this->handle);
                $return = fread($this->handle, $count - strlen($DECLARE));
                if ($return === false) {
                    return false; // @codeCoverageIgnore
                }

                $prefix = '';
                if ($pos === 0 && $this->require) {
                    $prefix = $DECLARE;
                }
                return $prefix . $return;
            }

            public function stream_set_option($option, $arg1, $arg2)
            {
                // Windows の file スキームでは呼ばれない？（確かにブロッキングやタイムアウトは無縁そう）
                // @codeCoverageIgnoreStart
                switch ($option) {
                    default:
                        throw new \Exception();
                    case STREAM_OPTION_BLOCKING:
                        return stream_set_blocking($this->handle, $arg1);
                    case STREAM_OPTION_READ_TIMEOUT:
                        return stream_set_timeout($this->handle, $arg1, $arg2);
                    case STREAM_OPTION_WRITE_BUFFER:
                        return stream_set_write_buffer($this->handle, $arg2); // @todo $arg1 is used?
                }
                // @codeCoverageIgnoreEnd
            }

            public function stream_metadata($path, $option, $value)
            {
                switch ($option) {
                    default:
                        throw new \Exception(); // @codeCoverageIgnore
                    case STREAM_META_TOUCH:
                        return $this->touch($path, ...$value);
                    case STREAM_META_ACCESS:
                        return $this->chmod($path, $value);
                    case STREAM_META_OWNER_NAME:
                    case STREAM_META_OWNER:
                        return $this->chown($path, $value);
                    case STREAM_META_GROUP_NAME:
                    case STREAM_META_GROUP:
                        return $this->chgrp($path, $value);
                }
            }

            public function stream_cast($cast_as) { /* @todo I'm not sure */ }
        };

        $profiler = new class(get_class($declareProtocol), $options) implements \IteratorAggregate {
            private $wrapper;
            private $options;
            private $last_trace;
            private $result;

            public function __construct($wrapper, $options = [])
            {
                $this->wrapper = $wrapper;
                $this->options = array_replace([
                    'callee'   => null,
                    'location' => null,
                ], $options);

                $this->last_trace = [];
                $this->result = [];

                stream_wrapper_unregister('file');
                stream_wrapper_register('file', $this->wrapper);

                register_tick_function([$this, 'tick']);
                opcache_reset();
            }

            public function __destruct()
            {
                unregister_tick_function([$this, 'tick']);

                stream_wrapper_restore('file');
            }

            public function __invoke()
            {
                return $this->result;
            }

            public function getIterator()
            {
                return yield from $this->result;
            }

            public function tick()
            {
                $now = microtime(true);
                $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                $last_count = count($this->last_trace);
                $current_count = count($traces);

                // スタック数が変わってない（=同じメソッドを処理している？）
                if ($current_count === $last_count) {
                    // dummy
                    assert($current_count === $last_count);
                }
                // スタック数が増えた（=新しいメソッドが開始された？）
                elseif ($current_count > $last_count) {
                    foreach (array_slice($traces, 1, $current_count - $last_count) as $last) {
                        $last['time'] = $now;
                        $last['callee'] = (isset($last['class'], $last['type']) ? $last['class'] . $last['type'] : '') . $last['function'];
                        $last['location'] = isset($last['file'], $last['line']) ? $last['file'] . '#' . $last['line'] : null;
                        array_unshift($this->last_trace, $last);
                    }
                }
                // スタック数が減った（=処理してたメソッドを抜けた？）
                elseif ($current_count < $last_count) {
                    $prev = null; // array_map などの内部関数はスタックが一気に2つ増減する
                    foreach (array_splice($this->last_trace, 0, $last_count - $current_count) as $last) {
                        $time = $now - $last['time'];
                        $callee = $last['callee'];
                        $location = $last['location'] ?? ($prev['file'] ?? '') . '#' . ($prev['line'] ?? '');
                        $prev = $last;

                        foreach (['callee', 'location'] as $key) {
                            $condition = $this->options[$key];
                            $value = $$key;
                            if ($condition !== null) {
                                if ($condition instanceof \Closure) {
                                    if (!$condition($value)) {
                                        continue 2;
                                    }
                                }
                                else {
                                    if (preg_match($condition, $value) === false) {
                                        continue 2;
                                    }
                                }
                            }
                        }
                        $this->result[$callee][$location][] = $time;
                    }
                }
            }
        };

        return $profiler;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\profiler") && !defined("ryunosuke\\WebDebugger\\profiler")) {
    define("ryunosuke\\WebDebugger\\profiler", "ryunosuke\\WebDebugger\\profiler");
}

if (!isset($excluded_functions["stringify"]) && (!function_exists("ryunosuke\\WebDebugger\\stringify") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\stringify"))->isInternal()))) {
    /**
     * 値を何とかして文字列化する
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $var 文字列化する値
     * @return string $var を文字列化したもの
     */
    function stringify($var)
    {
        $type = gettype($var);
        switch ($type) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return $var ? 'true' : 'false';
            case 'array':
                return var_export2($var, true);
            case 'object':
                if (method_exists($var, '__toString')) {
                    return (string) $var;
                }
                if ($var instanceof \Serializable) {
                    return serialize($var);
                }
                if ($var instanceof \JsonSerializable) {
                    return get_class($var) . ':' . json_encode($var, JSON_UNESCAPED_UNICODE);
                }
                return get_class($var);

            default:
                return (string) $var;
        }
    }
}
if (function_exists("ryunosuke\\WebDebugger\\stringify") && !defined("ryunosuke\\WebDebugger\\stringify")) {
    define("ryunosuke\\WebDebugger\\stringify", "ryunosuke\\WebDebugger\\stringify");
}

if (!isset($excluded_functions["arrayval"]) && (!function_exists("ryunosuke\\WebDebugger\\arrayval") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\arrayval"))->isInternal()))) {
    /**
     * array キャストの関数版
     *
     * intval とか strval とかの array 版。
     * ただキャストするだけだが、関数なのでコールバックとして使える。
     *
     * $recursive を true にすると再帰的に適用する（デフォルト）。
     * 入れ子オブジェクトを配列化するときなどに使える。
     *
     * Example:
     * ```php
     * // キャストなので基本的には配列化される
     * that(arrayval(123))->isSame([123]);
     * that(arrayval('str'))->isSame(['str']);
     * that(arrayval([123]))->isSame([123]); // 配列は配列のまま
     *
     * // $recursive = false にしない限り再帰的に適用される
     * $stdclass = stdclass(['key' => 'val']);
     * that(arrayval([$stdclass], true))->isSame([['key' => 'val']]); // true なので中身も配列化される
     * that(arrayval([$stdclass], false))->isSame([$stdclass]);       // false なので中身は変わらない
     * ```
     *
     * @param mixed $var array 化する値
     * @param bool $recursive 再帰的に行うなら true
     * @return array array 化した配列
     */
    function arrayval($var, $recursive = true)
    {
        // return json_decode(json_encode($var), true);

        // 無駄なループを回したくないので非再帰で配列の場合はそのまま返す
        if (!$recursive && is_array($var)) {
            return $var;
        }

        if (is_primitive($var)) {
            return (array) $var;
        }

        $result = [];
        foreach ($var as $k => $v) {
            if ($recursive && !is_primitive($v)) {
                $v = arrayval($v, $recursive);
            }
            $result[$k] = $v;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\arrayval") && !defined("ryunosuke\\WebDebugger\\arrayval")) {
    define("ryunosuke\\WebDebugger\\arrayval", "ryunosuke\\WebDebugger\\arrayval");
}

if (!isset($excluded_functions["is_empty"]) && (!function_exists("ryunosuke\\WebDebugger\\is_empty") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\is_empty"))->isInternal()))) {
    /**
     * 値が空か検査する
     *
     * `empty` とほぼ同じ。ただし
     *
     * - string: "0"
     * - countable でない object
     * - countable である object で count() > 0
     *
     * は false 判定する。
     * ただし、 $empty_stcClass に true を指定すると「フィールドのない stdClass」も true を返すようになる。
     * これは stdClass の立ち位置はかなり特殊で「フィールドアクセスできる組み込み配列」のような扱いをされることが多いため。
     * （例えば `json_decode('{}')` は stdClass を返すが、このような状況は空判定したいことが多いだろう）。
     *
     * なお、関数の仕様上、未定義変数を true 判定することはできない。
     * 未定義変数をチェックしたい状況は大抵の場合コードが悪いが `$array['key1']['key2']` を調べたいことはある。
     * そういう時には使えない（?? する必要がある）。
     *
     * 「 `if ($var) {}` で十分なんだけど "0" が…」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // この辺は empty と全く同じ
     * that(is_empty(null))->isTrue();
     * that(is_empty(false))->isTrue();
     * that(is_empty(0))->isTrue();
     * that(is_empty(''))->isTrue();
     * // この辺だけが異なる
     * that(is_empty('0'))->isFalse();
     * // 第2引数に true を渡すと空の stdClass も empty 判定される
     * $stdclass = new \stdClass();
     * that(is_empty($stdclass, true))->isTrue();
     * // フィールドがあれば empty ではない
     * $stdclass->hoge = 123;
     * that(is_empty($stdclass, true))->isFalse();
     * ```
     *
     * @param mixed $var 判定する値
     * @param bool $empty_stdClass 空の stdClass を空とみなすか
     * @return bool 空なら true
     */
    function is_empty($var, $empty_stdClass = false)
    {
        // object は is_countable 次第
        if (is_object($var)) {
            // が、 stdClass だけは特別扱い（stdClass は継承もできるので、クラス名で判定する（継承していたらそれはもう stdClass ではないと思う））
            if ($empty_stdClass && get_class($var) === 'stdClass') {
                return !(array) $var;
            }
            if (is_countable($var)) {
                return !count($var);
            }
            return false;
        }

        // "0" は false
        if ($var === '0') {
            return false;
        }

        // 上記以外は empty に任せる
        return empty($var);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\is_empty") && !defined("ryunosuke\\WebDebugger\\is_empty")) {
    define("ryunosuke\\WebDebugger\\is_empty", "ryunosuke\\WebDebugger\\is_empty");
}

if (!isset($excluded_functions["is_primitive"]) && (!function_exists("ryunosuke\\WebDebugger\\is_primitive") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\is_primitive"))->isInternal()))) {
    /**
     * 値が複合型でないか検査する
     *
     * 「複合型」とはオブジェクトと配列のこと。
     * つまり
     *
     * - is_scalar($var) || is_null($var) || is_resource($var)
     *
     * と同義（!is_array($var) && !is_object($var) とも言える）。
     *
     * Example:
     * ```php
     * that(is_primitive(null))->isTrue();
     * that(is_primitive(false))->isTrue();
     * that(is_primitive(123))->isTrue();
     * that(is_primitive(STDIN))->isTrue();
     * that(is_primitive(new \stdClass))->isFalse();
     * that(is_primitive(['array']))->isFalse();
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 複合型なら false
     */
    function is_primitive($var)
    {
        return is_scalar($var) || is_null($var) || is_resource($var);
    }
}
if (function_exists("ryunosuke\\WebDebugger\\is_primitive") && !defined("ryunosuke\\WebDebugger\\is_primitive")) {
    define("ryunosuke\\WebDebugger\\is_primitive", "ryunosuke\\WebDebugger\\is_primitive");
}

if (!isset($excluded_functions["is_arrayable"]) && (!function_exists("ryunosuke\\WebDebugger\\is_arrayable") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\is_arrayable"))->isInternal()))) {
    /**
     * 変数が配列アクセス可能か調べる
     *
     * Example:
     * ```php
     * that(is_arrayable([]))->isTrue();
     * that(is_arrayable(new \ArrayObject()))->isTrue();
     * that(is_arrayable(new \stdClass()))->isFalse();
     * ```
     *
     * @param array $var 調べる値
     * @return bool 配列アクセス可能なら true
     */
    function is_arrayable($var)
    {
        return is_array($var) || $var instanceof \ArrayAccess;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\is_arrayable") && !defined("ryunosuke\\WebDebugger\\is_arrayable")) {
    define("ryunosuke\\WebDebugger\\is_arrayable", "ryunosuke\\WebDebugger\\is_arrayable");
}

if (!isset($excluded_functions["is_countable"]) && (!function_exists("ryunosuke\\WebDebugger\\is_countable") || (!true && (new \ReflectionFunction("ryunosuke\\WebDebugger\\is_countable"))->isInternal()))) {
    /**
     * 変数が count でカウントできるか調べる
     *
     * 要するに {@link http://php.net/manual/function.is-countable.php is_countable} の polyfill。
     *
     * Example:
     * ```php
     * that(is_countable([1, 2, 3]))->isTrue();
     * that(is_countable(new \ArrayObject()))->isTrue();
     * that(is_countable((function () { yield 1; })()))->isFalse();
     * that(is_countable(1))->isFalse();
     * that(is_countable(new \stdClass()))->isFalse();
     * ```
     *
     * @polyfill
     *
     * @param mixed $var 調べる値
     * @return bool count でカウントできるなら true
     */
    function is_countable($var)
    {
        return is_array($var) || $var instanceof \Countable;
    }
}
if (function_exists("ryunosuke\\WebDebugger\\is_countable") && !defined("ryunosuke\\WebDebugger\\is_countable")) {
    define("ryunosuke\\WebDebugger\\is_countable", "ryunosuke\\WebDebugger\\is_countable");
}

if (!isset($excluded_functions["var_export2"]) && (!function_exists("ryunosuke\\WebDebugger\\var_export2") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\var_export2"))->isInternal()))) {
    /**
     * 組み込みの var_export をいい感じにしたもの
     *
     * 下記の点が異なる。
     *
     * - 配列は 5.4 以降のショートシンタックス（[]）で出力
     * - インデントは 4 固定
     * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
     * - 文字列はダブルクオート
     * - null は null（小文字）
     * - 再帰構造を渡しても警告がでない（さらに NULL ではなく `'*RECURSION*'` という文字列になる）
     * - 配列の再帰構造の出力が異なる（Example参照）
     *
     * Example:
     * ```php
     * // 単純なエクスポート
     * that(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true))->isSame('[
     *     "array" => [1, 2, 3],
     *     "hash"  => [
     *         "a" => "A",
     *         "b" => "B",
     *         "c" => "C",
     *     ],
     * ]');
     * // 再帰構造を含むエクスポート（標準の var_export は形式が異なる。 var_export すれば分かる）
     * $rarray = [];
     * $rarray['a']['b']['c'] = &$rarray;
     * $robject = new \stdClass();
     * $robject->a = new \stdClass();
     * $robject->a->b = new \stdClass();
     * $robject->a->b->c = $robject;
     * that(var_export2(compact('rarray', 'robject'), true))->isSame('[
     *     "rarray"  => [
     *         "a" => [
     *             "b" => [
     *                 "c" => "*RECURSION*",
     *             ],
     *         ],
     *     ],
     *     "robject" => stdClass::__set_state([
     *         "a" => stdClass::__set_state([
     *             "b" => stdClass::__set_state([
     *                 "c" => "*RECURSION*",
     *             ]),
     *         ]),
     *     ]),
     * ]');
     * ```
     *
     * @param mixed $value 出力する値
     * @param bool $return 返すなら true 出すなら false
     * @return string|null $return=true の場合は出力せず結果を返す
     */
    function var_export2($value, $return = false)
    {
        // インデントの空白数
        $INDENT = 4;

        // 再帰用クロージャ
        $export = function ($value, $nest = 0, $parents = []) use (&$export, $INDENT) {
            // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return $export('*RECURSION*');
                }
            }
            // 配列は連想判定したり再帰したり色々
            if (is_array($value)) {
                $spacer1 = str_repeat(' ', ($nest + 1) * $INDENT);
                $spacer2 = str_repeat(' ', $nest * $INDENT);

                $hashed = is_hasharray($value);

                // スカラー値のみで構成されているならシンプルな再帰
                if (!$hashed && array_all($value, is_primitive)) {
                    return '[' . implode(', ', array_map($export, $value)) . ']';
                }

                // 連想配列はキーを含めて桁あわせ
                if ($hashed) {
                    $keys = array_map($export, array_combine($keys = array_keys($value), $keys));
                    $maxlen = max(array_map('strlen', $keys));
                }
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    /** @noinspection PhpUndefinedVariableInspection */
                    $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                    $kvl .= $spacer1 . $keystr . $export($v, $nest + 1, $parents) . ",\n";
                }
                return "[\n{$kvl}{$spacer2}]";
            }
            // オブジェクトは単にプロパティを __set_state する文字列を出力する
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . '::__set_state(' . $export(get_object_properties($value), $nest, $parents) . ')';
            }
            // 文字列はダブルクオート
            elseif (is_string($value)) {
                return '"' . addcslashes($value, "\$\"\0\\") . '"';
            }
            // null は小文字で居て欲しい
            elseif (is_null($value)) {
                return 'null';
            }
            // それ以外は標準に従う
            else {
                return var_export($value, true);
            }
        };

        // 結果を返したり出力したり
        $result = $export($value);
        if ($return) {
            return $result;
        }
        echo $result, "\n";
    }
}
if (function_exists("ryunosuke\\WebDebugger\\var_export2") && !defined("ryunosuke\\WebDebugger\\var_export2")) {
    define("ryunosuke\\WebDebugger\\var_export2", "ryunosuke\\WebDebugger\\var_export2");
}

if (!isset($excluded_functions["var_pretty"]) && (!function_exists("ryunosuke\\WebDebugger\\var_pretty") || (!false && (new \ReflectionFunction("ryunosuke\\WebDebugger\\var_pretty"))->isInternal()))) {
    /**
     * var_dump の出力を見やすくしたもの
     *
     * var_dump はとても縦に長い上見づらいので色や改行・空白を調整して見やすくした。
     * sapi に応じて自動で色分けがなされる（$context で指定もできる）。
     * また、 xdebug のように呼び出しファイル:行数が先頭に付与される。
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * Example:
     * ```php
     * // 下記のように出力される（実際は色付きで出力される）
     * $using = 123;
     * var_pretty([
     *     "array"   => [1, 2, 3],
     *     "hash"    => [
     *         "a" => "A",
     *         "b" => "B",
     *         "c" => "C",
     *     ],
     *     "object"  => new \Exception(),
     *     "closure" => function () use($using) { },
     * ]);
     * ?>
     * {
     *   array: [1, 2, 3],
     *   hash: {
     *     a: 'A',
     *     b: 'B',
     *     c: 'C',
     *   },
     *   object: Exception#1 {
     *     message: '',
     *     string: '',
     *     code: 0,
     *     file: '...',
     *     line: 19,
     *     trace: [],
     *     previous: null,
     *   },
     *   closure: Closure#0(static) use {
     *     using: 123,
     *   },
     * }
     * <?php
     * ```
     *
     * @param mixed $value 出力する値
     * @param string|null $context 出力コンテキスト（[null, "plain", "cli", "html"]）。 null を渡すと自動判別される
     * @param bool $return 出力するのではなく値を返すなら true
     * @return string $return: true なら値の出力結果
     */
    function var_pretty($value, $context = null, $return = false)
    {
        // インデントの空白数
        $INDENT = 2;

        if ($context === null) {
            $context = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
            if (PHP_SAPI === 'cli') {
                $context = is_ansi(STDOUT) && !$return ? 'cli' : 'plain';
            }
        }

        $colorAdapter = static function ($value, $style) use ($context) {
            switch ($context) {
                default:
                    throw new \InvalidArgumentException("'$context' is not supported.");
                case 'plain':
                    return $value;
                case 'cli':
                    return ansi_colorize($value, $style);
                case 'html':
                    // 今のところ bold しか使っていないのでこれでよい
                    $style = $style === 'bold' ? 'font-weight:bold' : "color:$style";
                    return "<span style='$style'>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
            }
        };

        $colorKey = static function ($value) use ($colorAdapter) {
            if (is_int($value)) {
                return $colorAdapter($value, 'bold');
            }
            return $colorAdapter($value, 'red');
        };
        $colorVal = static function ($value) use ($colorAdapter) {
            switch (true) {
                case is_null($value):
                    return $colorAdapter('null', 'bold');
                case is_object($value):
                    return $colorAdapter(get_class($value), 'green') . "#" . spl_object_id($value);
                case is_bool($value):
                    return $colorAdapter(var_export($value, true), 'bold');
                case is_int($value) || is_float($value) || is_string($value):
                    return $colorAdapter(var_export($value, true), 'magenta');
                case is_resource($value):
                    return $colorAdapter(sprintf('%s of type (%s)', $value, get_resource_type($value)), 'bold');
            }
        };

        // 再帰用クロージャ
        $export = function ($value, $nest = 0, $parents = []) use (&$export, $INDENT, $colorKey, $colorVal) {
            // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return $export('*RECURSION*');
                }
            }
            if (is_array($value)) {
                // スカラー値のみで構成されているならシンプルな再帰
                if (!is_hasharray($value) && array_all($value, is_primitive)) {
                    return '[' . implode(', ', array_map($export, $value)) . ']';
                }

                $spacer1 = str_repeat(' ', ($nest + 1) * $INDENT);
                $spacer2 = str_repeat(' ', $nest * $INDENT);

                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    $keystr = $colorKey($k) . ': ';
                    $kvl .= $spacer1 . $keystr . $export($v, $nest + 1, $parents) . ",\n";
                }
                return "{\n{$kvl}{$spacer2}}";
            }
            elseif ($value instanceof \Closure) {
                /** @var \ReflectionFunctionAbstract $ref */
                $ref = reflect_callable($value);
                $that = $ref->getClosureThis();
                $thatT = $that ? $colorVal($that) : 'static';
                $properties = $ref->getStaticVariables();
                $propT = $properties ? $export($properties, $nest, $parents) : '{}';
                return $colorVal($value) . "($thatT) use $propT";
            }
            elseif (is_object($value)) {
                $parents[] = $value;
                $properties = get_object_properties($value);
                return $colorVal($value) . ' ' . ($properties ? $export($properties, $nest, $parents) : '{}');
            }
            else {
                return $colorVal($value);
            }
        };

        // 結果を返したり出力したり
        $result = ($return ? '' : implode("\n", array_reverse(stacktrace(null, ['format' => "%s:%s", 'args' => false, 'delimiter' => null]))) . "\n") . $export($value);
        if ($context === 'html') {
            $result = "<pre>$result</pre>";
        }
        if ($return) {
            return $result;
        }
        echo $result, "\n";
    }
}
if (function_exists("ryunosuke\\WebDebugger\\var_pretty") && !defined("ryunosuke\\WebDebugger\\var_pretty")) {
    define("ryunosuke\\WebDebugger\\var_pretty", "ryunosuke\\WebDebugger\\var_pretty");
}