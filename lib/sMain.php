<?php

namespace superBIT;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Loader;

abstract class sMain
{
    public static function checkModules()
    {
        if (!Loader::includeModule("superbit"))
            throw new \Bitrix\Main\LoaderException("Модуль superBIT не установлен");
    }

    public static function makeUrlRewriteRules()
    {
        // for RestApi ORM

        $urlRew = array(
            "CONDITION" => "#^/api/rest-api/([0-9]+)/#",
            "RULE" => "ID=$1",
            "ID" => "",
            "PATH" => "/api/rest-api/index.php"
        );

        try {
            \Bitrix\Main\UrlRewriter::add(SITE_ID, $urlRew);
        } catch (ArgumentNullException $e) {
            return $e->getMessage();
        }
    }
}