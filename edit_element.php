<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Получаем ID элемента из параметра CODE
$elementCode = intval($_GET['CODE']);
if ($elementCode <= 0) {
    die('Неверный CODE элемента');
}

$APPLICATION->IncludeComponent(
    "bitrix:iblock.element.add.form",
    "",
    array(
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => "5",
        "PROPERTY_CODES" => array("9","NAME","DATE_ACTIVE_TO","PREVIEW_TEXT"),
        "PROPERTY_CODES_REQUIRED" => array(),
        "GROUPS" => array("3"),
        "STATUS_NEW" => "N",
        "STATUS" => "ANY",
        "LIST_URL" => "/tasks/",
        "SEF_MODE" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "Y",
    ),
    false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>