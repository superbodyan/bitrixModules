<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use superBIT\ORMTEST\OrmTestTable;

/**
 * Class OrmGetList
 */
class OrmGetList extends CBitrixComponent
{
    /**
     * @throws \Bitrix\Main\LoaderException
     * Проверяем, подключен ли модуль superbit
     */
    protected function checkModules()
    {
        if (!Loader::includeModule("superbit"))
            throw new \Bitrix\Main\LoaderException("Модуль superBIT не установлен");
    }


    /**
     * @return mixed|void|null
     */
    public function executeComponent()
    {

        try {
            $this->checkModules();
            if ($this->startResultCache($this->arParams['CACHE_TIME'])) { // Проверяем, если кеш недействителен, то загружаем данные снова, если действителен, то показываем из кеша
                $this->arResult['ITEMS'] = $this->getListFormOrmTable();
                $this->includeComponentTemplate();
            }
        } catch (\Bitrix\Main\LoaderException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * Получаем весь список записей из ORM таблицы
     */
    private function getListFormOrmTable()
    {
        $arResult = [];
        $result = OrmTestTable::getList([]);

        while ($row = $result->fetch()) {
            $arResult[] = $row;
        }

        return $arResult;
    }
}