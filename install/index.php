<?
require_once( $_SERVER['DOCUMENT_ROOT'] . '/local/modules/superBIT/include.php');
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use superBIT\ORMTEST\OrmTestTable;
use superBIT\RegRuOrmTable;

global $APPLICATION;

Class superbit extends CModule
{
    var $MODULE_ID = "superbit";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;

    function superbit()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = "superBIT – модуль для демонстрации технических навыков";
        $this->MODULE_DESCRIPTION = "Описание для модуля";
    }

    function InstallFiles()
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/superBIT/install/components",
            $_SERVER["DOCUMENT_ROOT"]."/local/components/superBIT", true, true);
        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/local/components/superBIT");
        return true;
    }

    function InstallDB()
    {
        // Созданием таблицу с именем (имя берется из метода getTableName). Сущность таблицы будет взята из метда getMap
        Loader::includeModule($this->MODULE_ID);
        $db = Application::getConnection();
        $storeEntity = OrmTestTable::getEntity();
        if (! $db->isTableExists($storeEntity->getDBTableName())) // проверяем, существует ли таблицы в системе
        {
            $storeEntity->createDbTable();
            OrmTestTable::createTestData(); // Добавляем тестовые записи
        }

        $storeRegRuEntity = RegRuOrmTable::getEntity();
        if (! $db->isTableExists($storeRegRuEntity->getDBTableName())) // проверяем, существует ли таблицы в системе
        {
            $storeRegRuEntity->createDbTable();
        }
    }

    function UnInstallDB()
    {
        // удаляем созданную таблицу
        Loader::includeModule($this->MODULE_ID);

        \Bitrix\Main\Application::getConnection(OrmTestTable::getConnectionName())->
        queryExecute('drop table if exists ' . \Bitrix\Main\Entity\Base::getInstance("\superBIT\ORMTEST\OrmTestTable")->getDBTableName());
        \Bitrix\Main\Config\Option::delete($this->MODULE_ID);

        \Bitrix\Main\Application::getConnection(RegRuOrmTable::getConnectionName())->
        queryExecute('drop table if exists ' . \Bitrix\Main\Entity\Base::getInstance("\superBIT\RegRuOrmTable")->getDBTableName());
        \Bitrix\Main\Config\Option::delete($this->MODULE_ID);

    }

    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->InstallDB();
        $this->InstallFiles();
        \superBIT\sMain::makeUrlRewriteRules();
        RegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Установка модуля superBIT", $DOCUMENT_ROOT."/local/modules/superBIT/install/step.php");
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->UnInstallFiles();
        $this->UnInstallDB();
        UnRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Деинсталляция модуля superBIT", $DOCUMENT_ROOT."/local/modules/superBIT/install/unstep.php");
    }
}
?>