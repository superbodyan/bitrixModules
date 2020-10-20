<?php

namespace superBIT\ORMTEST;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;


/**
 * Class OrmTestTable
 * @package superBIT\ORMTEST
 */
class OrmTestTable extends Entity\DataManager
{
    /**
     * @return string|null
     * Возвращает имя ORM таблицы
     */
    public static function getTableName()
    {
        return 'orm_test_table';
    }

    /**
     * @return array
     * @throws \Bitrix\Main\SystemException
     * Создаем необходимые поля для таблицы
     */
    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                "autocomplete" => true
            )),
            new Entity\StringField("NAME"),
            new Entity\DatetimeField("DATE_INSERT", array(
                "default_value" => new Type\DateTime,
            )),
        );
    }

    public static function createTestData()
    {
        self::add(array(
            "NAME" => "Artem",
            "DATE_INSERT" => new Type\Date('1999-06-16', 'Y-m-d')
        ));
    }
}