<?php
// Подключаем здесь все классы из папки lib
Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'superBIT\ORMTEST\OrmTestTable' => '/local/modules/superBIT/lib/OrmTestTable.php',
    'superBIT\sMain' => '/local/modules/superBIT/lib/sMain.php',
    'superBIT\RestApi' => '/local/modules/superBIT/lib/RestApi.php',
    'superBIT\RegRu' => '/local/modules/superBIT/lib/RegRu.php',
    'superBIT\cUrl' => '/local/modules/superBIT/lib/cUrl.php',
    'superBIT\OrmDefault' => '/local/modules/superBIT/lib/OrmDefault.php',
    'superBIT\RegRuOrmTable' => '/local/modules/superBIT/lib/RegRuOrmTable.php',
]);