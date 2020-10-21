<?php

namespace superBIT;

use Bitrix\Main\LoaderException;
use superBIT\sMain;
use superBIT\ORMTEST\OrmTestTable;
use \Bitrix\Main\Type;

class RestApi
{
    public function RestController($params)
    {
        try {
            sMain::checkModules();

            switch ($params['REQUEST_METHOD']) {
                case "GET":
                    return $this->getInfoFromOrmTable();
                case "POST":
                    $validData = $this->formatRawData($params['RAW_DATA']);
                    return $this->addItemToOrmTable($validData->name, $validData->date);
            }
        } catch (LoaderException $e) {
            return json_encode($e->getMessage());
        }
    }

    private function formatRawData($data)
    {
        return json_decode($data);
    }

    private function addItemToOrmTable($name = null, $date = null)
    {
        if (is_null($name) || is_null($date) || $name == "" || $date == "")
            return json_encode("No input data");

        try {
            $result = OrmTestTable::add([
                "NAME" => $name,
                "DATE_INSERT" => new Type\Date($date, 'Y-m-d')
            ]);
            if ($result->isSuccess()){
                return json_encode("Element added! # " . $result->getId());
            }
        } catch (\Bitrix\Main\ObjectException $e) {
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