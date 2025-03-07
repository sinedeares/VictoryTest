<?php

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
    "iblock",
    "OnAfterIBlockElementAdd",
    ["FormEventHandler", "onAfterIBlockElementAdd"]
);

$eventManager->addEventHandler(
    "iblock",
    "OnAfterIBlockElementUpdate",
    ["FormEventHandler", "onAfterIBlockElementUpdate"]
);

class FormEventHandler
{
    const IBLOCK_CODE = 'tasks';

    private static function getIblockIdByCode($code)
    {
        $iblock = Bitrix\Iblock\IblockTable::getList([
            'filter' => ['CODE' => $code],
            'select' => ['ID'],
        ])->fetch();

        return $iblock ? $iblock['ID'] : null;
    }

    public static function onAfterIBlockElementAdd($arFields): void
    {
        $iblockId = self::getIblockIdByCode(self::IBLOCK_CODE);
        if ($arFields["IBLOCK_ID"] == $iblockId) { // Проверяем, что это нужный инфоблок
            self::sendNotification($arFields, "Новый элемент добавлен");
        }
    }

    public static function onAfterIBlockElementUpdate($arFields): void
    {
        $iblockId = self::getIblockIdByCode(self::IBLOCK_CODE);
        if ($arFields["IBLOCK_ID"] == $iblockId) { // Проверяем, что это нужный инфоблок
            self::sendNotification($arFields, "Элемент обновлен");
        }
    }

    private static function sendNotification($arFields, $message): void
    {
        $emailTo = "sined.rustam1999@mail.ru";
        $elementId = $arFields["ID"];
        $elementName = $arFields["NAME"];
        $elementDateActiveTo = $arFields["DATE_ACTIVE_TO"];
        $elementPreviewText = $arFields["PREVIEW_TEXT"];
        $siteId = defined('SITE_ID') ? SITE_ID : 's1';

        $eventFields = array(
            "EMAIL_TO" => $emailTo,
            "MESSAGE" => $message,
            "ELEMENT_ID" => $elementId,
            "ELEMENT_NAME" => $elementName,
            "ELEMENT_DATE_ACTIVE_TO" => $elementDateActiveTo,
            "ELEMENT_PREVIEW_TEXT" => $elementPreviewText,
        );
        // Отправляем уведомление
        \Bitrix\Main\Mail\Event::send(array(
            "EVENT_NAME" => "IBLOCK_ELEMENT_NOTIFICATION",
            "LID" => $siteId,
            "C_FIELDS" => $eventFields,
        ));
    }
}