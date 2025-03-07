<?php

namespace Sprint\Migration;


class CreatePECreateUpdateIBElement20250307135019 extends Version
{
    protected $author = "admin";

    protected $description = "Почтовое событие  \"Уведомление о добавлении/обновлении элемента\"";

    protected $moduleVersion = "4.18.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Event()->saveEventType('IBLOCK_ELEMENT_NOTIFICATION', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Уведомление о добавлении/обновлении элемента',
  'DESCRIPTION' => 'Уведомление о добавлении/обновлении элемента',
  'SORT' => '150',
));
            $helper->Event()->saveEventType('IBLOCK_ELEMENT_NOTIFICATION', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => '',
  'DESCRIPTION' => '',
  'SORT' => '150',
));
            $helper->Event()->saveEventMessage('IBLOCK_ELEMENT_NOTIFICATION', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => 'sined.rustam1999@mail.ru',
  'SUBJECT' => 'Новый элемент инфоблока на сайте #SITE_NAME#',
  'MESSAGE' => 'Новый элемент добавлен:
- ID: #ELEMENT_ID#
- Название: #ELEMENT_NAME#
- Описание: #ELEMENT_PREVIEW_TEXT#',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ IBLOCK_ELEMENT_NOTIFICATION ] Уведомление о добавлении/обновлении элемента',
));
        }
}
