<?php

namespace superBIT;

use Bitrix\Main\Type;

class RegRu
{
    use cURL, OrmDefault;

    private $regUrls = [
        "AUTH" => "https://api.reg.ru/api/regru2/nop",
        "SERVICE" => "https://api.reg.ru/api/regru2/service/get_list"
    ];
    private $userConfig = [
        "username" => "",
        "password" => ""
    ];
    private $services = [];

    public function __construct($login, $password)
    {
        $this->userConfig['username'] = $login;
        $this->userConfig['password'] = $password;
    }

    public function authRegService()
    {
        $result = $this->initPostRequest(['URL' => $this->regUrls['AUTH'], "FIELDS" => $this->userConfig]);
        $result = json_decode($result);
        return $result->result == "success" ? "Y" : json_encode($result->error_text);
    }

    private function setServices()
    {
        $result = json_decode($this->initPostRequest(['URL' => $this->regUrls['SERVICE'], "FIELDS" => $this->userConfig]));
        foreach ($result->answer->services as $arService) {
            $arItem = [
                "SERVICE_ID" => (int) $arService->service_id,
                "DNAME" => $arService->dname,
                "EXPIRATION_DATE" => new Type\Date($arService->expiration_date, 'Y-m-d'),
                "CREATION_DATE" => new Type\Date($arService->creation_date, 'Y-m-d'),
                "SERVTYPE" => (string) $arService->servtype,
                "STATE" => (string) $arService->state,
                "UPLINK_SERVICE_ID" => (int) $arService->uplink_service_id,
                "SUBTYPE" => (string) $arService->subtype
            ];
            $this->services[] = $arItem;
            $this->addItemsToOrmTable(RegRuOrmTable::class, $arItem);
        }
    }

    public function getServices()
    {
        $this->setServices();
        return $this->services;
    }
}