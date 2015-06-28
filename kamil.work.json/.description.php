<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage('NAME_COMPONENT'),
    "DESCRIPTION" => GetMessage('DESCRIPTION_COMPONENT'),
    "ICON" => "/images/news_list.gif",
	"SORT" => 10,
	"SCREENSHOT" => array(
		"/images/screen1.JPG",
		"/images/screen2.JPG",
	),
    "PATH" => array(
        "ID" => "kamil",
		"NAME" => GetMessage('NAME_SECTION'),
		"SORT" => 10,
		"CHILD" => array(
			"ID" => "kamil",
			"NAME" => GetMessage('NAME_SUB_SECTION'),
			"SORT" => 10,
		),
    ),
);
?>