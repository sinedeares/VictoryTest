<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="news-list">
    <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?><br/>
    <? endif; ?>

    <?
    $currentUserId = $USER->GetID();
    ?>

    <? foreach ($arResult["ITEMS"] as $arItem): ?>
    <? //элементы только для текущего пользователя ?>
        <? if ($currentUserId == $arItem["DISPLAY_PROPERTIES"]["AUTHOR"]["VALUE"]): ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_DELETE_CONFIRM')));
            ?>

            <div class="news-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>" data-element-id="<?= $arItem['ID']; ?>">
                <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                    <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><img class="preview_picture"
                                                                         src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                                                         width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>"
                                                                         height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>"
                                                                         alt="<?= $arItem["NAME"] ?>"
                                                                         title="<?= $arItem["NAME"] ?>"
                                                                         style="float:left"/></a>
                    <? else: ?>
                        <img class="preview_picture" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                             width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>"
                             height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>" alt="<?= $arItem["NAME"] ?>"
                             title="<?= $arItem["NAME"] ?>" style="float:left"/>
                    <? endif; ?>
                <? endif ?>
             
                <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                    <div class="news-title"><? echo $arItem["NAME"] ?></div>
                <? endif; ?>
                <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                    <div class="news-detail"><? echo $arItem["PREVIEW_TEXT"]; ?></div>
                <? endif; ?>
                <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
                    <div style="clear:both"></div>
                <? endif ?>
                <? foreach ($arItem["FIELDS"] as $code => $value): ?>
                    <small>
                        <?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?= $value; ?>
                    </small><br/>
                <? endforeach; ?>
                <? foreach ($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                    <small>
                        <?= $arProperty["NAME"] ?>:&nbsp;
                        <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
                            <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
                        <? else: ?>
                            <?= $arProperty["DISPLAY_VALUE"]; ?>
                        <? endif ?>
                    </small><br/>
                <? endforeach; ?>
                <a class="news-detail-link" href="<?= $arItem["ID"] ?>/"><?= GetMessage('MEWS_DETAIL_LINK') ?>
                    &rarr;</a>
                <a href="/edit_element.php?CODE=<?= $arItem['ID']; ?>" class="btn-edit">Редактировать</a> </br>
                <button class="btn-delete" data-element-id="<?= $arItem['ID'] ?>">Удалить</button>
                <input type="hidden" name="sessid" value="<?= bitrix_sessid(); ?>">
            </div>
        <? endif; ?>

    <? endforeach; ?>

    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <br/><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>

</div>

