<?
if (!check_bitrix_sessid()) {
    return;
} ?>
<?
echo CAdminMessage::ShowNote("Модуль " . Loc::getMessage("CORE_MODULE_ALTDEV") . " успешно удален из системы");
?>