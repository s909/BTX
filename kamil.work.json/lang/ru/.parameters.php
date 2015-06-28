<?
$MESS["TEMPLATE_FOR_DATE_MESS"] = "Шаблон для даты";
//$MESS["TEMPLATE_FOR_DATE_TIP"] = "Шаблон для даты";

$MESS["FILE_JSON_MESS"] = "Путь к файлу JSON";
$MESS["FILE_JSON_TIP"] = "Полный путь вида http://site/file.json<br>или<br>dir/file.json";

$MESS["T_IBLOCK_DESC_LIST_TYPE"] = "Тип информационного блока (используется только для проверки)";
$MESS["T_IBLOCK_DESC_LIST_ID"] = "Код информационного блока";
$MESS["IBLOCK_SECTION_ID"] = "ID раздела";
$MESS["IBLOCK_PRICE_CODE"] = "Тип цены";
$MESS["IBLOCK_PRICES"] = "Цены";
$MESS["VAR_JSON_NAME"] = "NAME";
$MESS["VAR_JSON_PRICE"] = "ЦЕНА";
$MESS["JSON_CONFORMITY"] = "Соответсвия полей в JSON";

$MESS["PIECEMEAL_MESS"] = "По частям";
$MESS["PIECEMEAL_TIP"] = '<b>ДА</b>: Если файл большой и не содержит лишних переносов строк. Перенос строк обозначает часть файла. Файл будет читаться пошагово. Имеет вид:<br>
<pre>
[{"number": "9059029033","sale_price": 53000},{"number": "5519029051","sale_price": 222.33}]
[{"number": "9059029033","sale_price": 53000},{"number": "5519029051","sale_price": 222.33}]
</pre>
<br/><b>НЕТ</b>: Данные в файле не одной строкой, а с форматированием. Будет прочитан за один шаг. Файл имеет вид:<br>
<pre>
[{ 
"number": "9059029033",
"sale_price": 53000
},{ 
"number": "5519029051",
"sale_price": 222.33
}]
</pre>
';
?>