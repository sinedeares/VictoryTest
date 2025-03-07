<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!check_bitrix_sessid()) {
    echo json_encode(['success' => false, 'message' => 'Неверный идентификатор сессии']);
    exit();
}

$elementId = intval($_POST['elementId']);
if ($elementId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Неверный ID элемента']);
    exit();
}

if (!CModule::IncludeModule("iblock")) {
    echo json_encode(['success' => false, 'message' => 'Модуль инфоблоков не подключен']);
    exit();
}

if (Bitrix\Iblock\IblockTable::delete($elementId)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при удалении элемента']);
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>