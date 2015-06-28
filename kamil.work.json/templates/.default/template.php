<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<div id="slider_kamil" class="slider_kamil" style="padding:20px;">
<br />
<?if($arResult['ERROR']):?>
	<strong><?=$arResult['ERROR']?></strong><br />
<?endif;?>
<?if($arResult['ADD']):?>
	Добавленно новых элементов: <strong><?=$arResult['ADD']?></strong><br />
<?endif;?>
<?if($arResult['UPD']):?>
Обновлено элементов (активны): <strong><?=$arResult['UPD']?></strong><br />
<?endif;?>
<?if($arResult['COUNT_PRICE']):?>
Изменена цена: <strong><?=$arResult['COUNT_PRICE']?></strong> элементов<br />
<?endif;?>
<?if($arResult['TOTAL_ACTIVE']):?>
Количество активных элементов в базе: <strong><?=$arResult['TOTAL_ACTIVE']?></strong><br />
<?endif;?>
<br />
<?=$arResult['DATE']?>
</div>




