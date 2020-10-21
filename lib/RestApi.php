<?php

namespace superBIT;

use Bitrix\Main\LoaderException;
use superBIT\sMain;
use superBIT\ORMTEST\OrmTestTable;
use function MongoDB\BSON\toJSON;

class RestApi
{
    public function RestController($params)
    {
        try {
            sMain::checkModules();

            switch ($params['REQUEST_METHOD']) {
                case "GET":
                    return $this->getInfoFromOrmTable();
            }
        } catch (LoaderException $e) {
            return json_encode($e->getMessage());
        }
    }

    private function getInfoFromOrmTable()
    {
        $arResult = [];
        $result = OrmTestTable::getList([]);

        while ($row = $result->fetch()) {
            $arItem = [
                "ID" => $row['ID'],
                "NAME" => $row['NAME'],
                "DATE" => $row['DATE_INSERT']->format('Y-m-d')
            ];
            $arResult[] = $arItem;
        }

        return json_encode($arResult);
    }
}