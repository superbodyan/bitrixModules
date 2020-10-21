<?php

namespace superBIT;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use superBIT\sMain;
use superBIT\ORMTEST\OrmTestTable;
use \Bitrix\Main\Type;

class RestApi
{
    public function RestController($params)
    {
        try {
            sMain::checkModules();
            $validData = $this->formatRawData($params['RAW_DATA']);
            switch ($params['REQUEST_METHOD']) {
                case "GET":
                    return $this->getInfoFromOrmTable();
                case "POST":
                    return $this->addItemToOrmTable($validData->name, $validData->date);
                case "PUT":
                    return $this->updateItemData($validData);
                case "DELETE":
                    return $this->deleteItemFromOrmTable();
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
            if ($result->isSuccess()) {
                return json_encode("Element added! # " . $result->getId());
            }
        } catch (\Bitrix\Main\ObjectException $e) {
            return json_encode($e->getMessage());
        }
    }

    private function updateItemData($fields = [])
    {
        if (!isset($_REQUEST['ID']))
            return json_encode("NO INPUT ID");


        try {
            $idItems = $this->findIdOnItems();
            $result = OrmTestTable::update($_REQUEST['ID'], array(
                "NAME" => $fields->name,
                "DATE_INSERT" => new Type\Date($fields->date, 'Y-m-d')
            ));
            if (!$result->isSuccess())
                return json_encode($result->getErrorMessages());
            else {
                if (in_array($result->getId(), $idItems))
                    return json_encode("ITEM UPDATE #" . $result->getId());
                else
                    return json_encode("ITEM NOT FOUND");
            }
        } catch (ObjectException $e) {
            return json_encode($e->getMessage());
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }

    }

    private function findIdOnItems()
    {
        $allItems = json_decode($this->getInfoFromOrmTable());
        $arResult = [];
        foreach ($allItems as $arItem){
            $arResult[] = $arItem->ID;
        }
        return $arResult;
    }

    private function deleteItemFromOrmTable()
    {
        $itemIds = $this->findIdOnItems();

        if (!in_array($_REQUEST['ID'], $itemIds))
            return json_encode("ITEM NOT FOUND");
        else {
            try {
                $result = OrmTestTable::delete($_REQUEST['ID']);
                if (!$result->isSuccess())
                    return json_encode($result->getErrorMessages());
                else
                    return json_encode("ITEM IS DELETED");
            } catch (\Exception $e) {
                return json_encode($e->getMessage());
            }
        }
    }

    private function getInfoFromOrmTable()
    {
        $arResult = [];
        try {
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
        } catch (ObjectPropertyException $e) {
            return json_encode($e->getMessage());
        } catch (ArgumentException $e) {
            return json_encode($e->getMessage());
        } catch (SystemException $e) {
            return json_encode($e->getMessage());
        }
    }
}