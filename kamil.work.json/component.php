<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$options = Array(				
				"file_json"=>$arParams["FILE_JSON"],
				"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
				"SECTION_ID"=>$arParams["PARENT_SECTION"],
				"PRICE_ID"=>$arParams["PRICE_ID"],
				"piecemeal"=>$arParams["PIECEMEAL"],
				"NAME"=>$arParams["JSON_NAME"],
				"PRICE"=>$arParams["JSON_PRICE"],
				);

$json_import = new JsonParser($options);
$arResult = $json_import->jetJson();

$arResult['DATE'] = FormatDate($arParams["TEMPLATE_FOR_DATE"], time());

$this->IncludeComponentTemplate();
?>