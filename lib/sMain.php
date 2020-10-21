<?php

namespace superBIT;

use Bitrix\Main\Loader;

abstract class sMain
{
    public static function checkModules()
    {
        if (!Loader::includeModule("superbit"))
            throw new \Bitrix\Main\LoaderException("Модуль superBIT не установлен");
    }
}