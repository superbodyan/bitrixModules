<?php
require ($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use superBIT\ORMTEST\OrmTestTable;
use Bitrix\Main\Loader;
use \Bitrix\Main\Type;

$AJAX = new OrmAjax();
echo $AJAX->AjaxController($_POST);

/**
 * Class OrmAjax
 */
class OrmAjax
{
    /**
     * @throws \Bitrix\Main\LoaderException
     */
    protected function checkModules()
    {
        if (!Loader::includeModule("superbit"))
            throw new \Bitrix\Main\LoaderException("Модуль superBIT не установлен");
    }

    /**
     * @param $data
     * @return false|string
     */
    public function AjaxController($data)
    {
        try {
            $this->checkModules();
            switch ($data['ajax_task']){
                case "addElement":
                    return $this->addElementToOrmTestTable(htmlspecialchars($data['USER']['NAME']), $data['USER']['DATE']);
                case "delElement":
                    return $this->deleteElementToOrmTestTable($data['elementId']);
            }
        } catch (\Bitrix\Main\LoaderException $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @param null $name
     * @param null $date
     * @return false|string
     * @throws Exception
     */
    private function addElementToOrmTestTable($name = null, $date = null)
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

    /**
     * @param $id
     * @return false|string
     * @throws Exception
     */
    private function deleteElementToOrmTestTable($id)
    {
        try {
            OrmTestTable::delete($id);
            return json_encode("Item is deleted");
        } catch (\Bitrix\Main\ObjectException $e) {
            return json_encode($e->getMessage());
        }
    }
}



