<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
const IBLOCK_CODE = 'tasks';

try {
    if (!Bitrix\Main\Loader::includeModule('iblock')) {
        throw new \Exception("Не удалось подключить модуль 'iblock'");
    }

    global $USER;
    $userId = $USER->GetID();

    if (!$userId) {
        throw new \Exception("Пользователь не авторизован.");
    }

    // Получаем ID инфоблока по его символьному коду
    $iblockId = Bitrix\Iblock\IblockTable::getList([
        'filter' => ['CODE' => IBLOCK_CODE],
        'select' => ['ID'],
    ])->fetch()['ID'];

    if (!$iblockId) {
        throw new \Exception("Инфоблок с кодом '" . IBLOCK_CODE . "' не найден.");
    }

    $elementClass = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();

    if (!$elementClass) {
        throw new \Exception("Не удалось получить класс данных для инфоблока с ID: {$iblockId}. Возможно, не заполнен Символьный код API.");
    }

    $res = $elementClass::getList([
        'select' => [
            'ID',
            'NAME',
            'ACTIVE_TO',
            'PREVIEW_TEXT',
            'AUTHOR_' => 'AUTHOR',
            'STATUS_' => 'STATUS',
        ],
        'filter' => [
            'AUTHOR_VALUE' => $userId, // Фильтр по автору
        ],
    ]);

    $tasks = $res->fetchAll();

    // Создаем XML-структуру
    $xml = new SimpleXMLElement('<tasks/>');

    foreach ($tasks as $task) {
        $taskNode = $xml->addChild('task');
        $taskNode->addChild('id', $task['ID']);
        $taskNode->addChild('name', $task['NAME']);
        $taskNode->addChild('date_active_to', $task['ACTIVE_TO']);
        $taskNode->addChild('preview_text', $task['PREVIEW_TEXT']);
        $taskNode->addChild('author', $task['AUTHOR_VALUE']);
        $taskNode->addChild('status', $task['STATUS_VALUE']);
    }

    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="tasks_export.xml"');
    echo $xml->asXML();
    exit();

} catch (\Exception $e) {
    // Обработка ошибок
    echo "Ошибка: " . $e->getMessage();
}

