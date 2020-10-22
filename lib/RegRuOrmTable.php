<?php

namespace superBIT;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;


/**
 * Class OrmTestTable
 * @package superBIT\ORMTEST
 */
class RegRuOrmTable extends Entity\DataManager
{
    /**
     * @return string|null
     * Возвращает имя ORM таблицы
     */
    public static function getTableName()
    {
        return 'orm_reg_ru';
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
            new Entity\IntegerField("SERVICE_ID"),
            new Entity\StringField("DNAME"),
            new Entity\DatetimeField("EXPIRATION_DATE"),
            new Entity\DatetimeField("CREATION_DATE"),
            new Entity\StringField("SERVTYPE"),
            new Entity\StringField("STATE"),
            new Entity\IntegerField("UPLINK_SERVICE_ID"),
            new Entity\StringField("SUBTYPE")
        );
    }
}