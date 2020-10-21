<?php
// Подключаем здесь все классы из папки lib
Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'superBIT\ORMTEST\OrmTestTable' => '/local/modules/superBIT/lib/OrmTestTable.php',
    'superBIT\sMain' => '/local/modules/superBIT/lib/sMain.php',
    'superBIT\RestApi' => '/local/modules/superBIT/lib/RestApi.php',
]);