<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("JsonParser");
?><?

$n = 50; //заданная длина

// без рекурсии
$a = array();   
$a[1] = '1';
$a[2] = '1';
echo $a[1].", ";
echo $a[2].", ";
for ($i = 3; $i <= $n; $i++) {
  $a[$i] = $a[$i-1] + $a[$i-2];
  echo $a[$i].", ";
}
echo("...<br /><br />");

 // рекурсия 
function fibonacci($n, $p = 1, $pp = 0)
{   
	echo " ", $p, ", ";   
    if ($n < 2) {
		echo "...<br />";
		return false;
	}
    return fibonacci($n - 1, $p + $pp, $p);
}
fibonacci($n);


?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>