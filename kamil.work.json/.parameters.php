<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 $day = array(
	"j F, Y",
	"d M Y",
	"d-m-Y",
	"d-m-y (l)",
	"j-m-Y",	
	"d-n-Y",
 );
 
 $piecemeal = array(
	0=>"Нет",
	1=>"Да"
 );
 
 if(!CModule::IncludeModule("iblock"))
	return;

 $boolCatalog = \Bitrix\Main\Loader::includeModule("catalog");
 
 $arPrice = array();
 if ($boolCatalog)
 {
	//$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	$rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
	while($arr=$rsPrice->Fetch()) 
		$arPrice[$arr["ID"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
 }
 else
 {
	$arPrice = $arProperty_N;
 }

 $arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));

 $arIBlocks=Array();
 $db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
 while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];
 
 $select = array();

 foreach ($day as $key => $value){	
	$select[$value] = FormatDate($value, time());	
 }

 $arComponentParameters = array(
	"GROUPS" => array(
		"PRICES" => array(
			"NAME" => GetMessage("IBLOCK_PRICES"),
			"SORT" => "100",
		),
		"JSON" => array(
			"NAME" => GetMessage("JSON_CONFORMITY"),
			"SORT" => "400",
		),
	),
	"PARAMETERS" => array(
		"TEMPLATE_FOR_DATE" => array(
			"PARENT" =>"ADDITIONAL_SETTINGS",
			"NAME" =>GetMessage("TEMPLATE_FOR_DATE_MESS"),
			"TYPE" =>"LIST",
			"MULTIPLE" =>"N",
			"VALUES" => $select,
		),
		"FILE_JSON" => array(
			"PARENT" =>"BASE",
			"NAME" =>GetMessage("FILE_JSON_MESS"),
			"TYPE" =>"STRING",
			"MULTIPLE" =>"N",
			"DEFAULT" => "http://localhost:6448/ttt/json.js",
		),
		"PIECEMEAL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("PIECEMEAL_MESS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $piecemeal,
			"DEFAULT" => '0',
		),
		"IBLOCK_TYPE" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"PARENT_SECTION" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_SECTION_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"JSON_NAME" => array(
			"PARENT" => "JSON",
			"NAME" => GetMessage("VAR_JSON_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => 'number',
		),
		"JSON_PRICE" => array(
			"PARENT" => "JSON",
			"NAME" => GetMessage("VAR_JSON_PRICE"),
			"TYPE" => "STRING",
			"DEFAULT" => 'sale_price',
		),
		"PRICE_ID" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_PRICE_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arPrice,
			"DEFAULT" => '1',
		),		
	),
);
?>