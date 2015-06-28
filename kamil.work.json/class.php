<?
header ("Content-Type: text/html; charset=utf-8");
//error_reporting(-1);
set_time_limit(0);
//ini_set("memory_limit","4048M");
class JsonParser
{		
	/* const IBLOCK_ID = 4;
	const SECTION_ID = 39;	
	const PRICE_TYPE_ID = 1; */
	private $json_decode;
	private $price_catalog_group;
	private $is_no_active = false;
	private $options = Array();
	protected $result = Array();
	
	function __construct($options) {
       $this->options = $options;
       $this->price_catalog_group = $options['PRICE_ID'];
   }
	
	public function jetJson()
    {
		if(IntVal($this->options["piecemeal"])) {
			$handle = @fopen($this->options["file_json"], "r");
			if ($handle) {
				while (($buffer = fgets($handle)) !== false) {
					if($this->json_decode = json_decode($buffer, true)){
						if(!$this->is_no_active){
							$this->getListElements();
							$this->is_no_active = true;
						}
						$res = $this->updateElements();
					}else{
						$this->result["ERROR"] = GetMessage("ERROR_JSON");
						return $this->result;
					}
				}
				if (!feof($handle)) {
					$this->result["ERROR"] = "Error: unexpected fgets() fail\n";
					return $this->result;
				}
				fclose($handle);
				return $res;
			}
			else{
				$this->result["ERROR"] = GetMessage("ERROR_FILE");
				return $this->result;
			}
		}else {
			if($file = file_get_contents($this->options["file_json"])){
				if($this->json_decode = json_decode($file, true)){
					$this->getListElements();
					return $this->updateElements();
				}else{
					$this->result["ERROR"] = GetMessage("ERROR_JSON");
					return $this->result;
				}
			}else{
				$this->result["ERROR"] = GetMessage("ERROR_FILE");
				return $this->result;
			}			
		}
	}
	
	protected function getListElements()
    {
		CModule::IncludeModule('iblock');
		CModule::IncludeModule('catalog');
		
		$arOrder = Array("ID"=>"ASC"); 
		$arFilter = Array("IBLOCK_ID"=>IntVal($this->options["IBLOCK_ID"]), "SECTION_ID"=>IntVal($this->options["SECTION_ID"]), "ACTIVE"=>"Y");
		$arGroupBy = false;
		$arNavStartParams = false;
		$arSelectFields = Array("ID", "NAME"); 

		$res = CIBlockElement::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelectFields);

		while($ob = $res->GetNextElement())
		{
		 $arFields = $ob->GetFields();
		 $arElements[] = $arFields;
		}
		$this->updateElementsNoActive($arElements);
		
	}
	
	protected function updateElementsNoActive($arElements)
    {		
		foreach ($arElements as &$elem)
		{	
			global $USER;
			
			$arLoadProductArray = Array(
			  "MODIFIED_BY"    => $USER->GetID(),
			  "ACTIVE"         => "N",
			  );
			$el = new CIBlockElement;
			$el->Update($elem["ID"], $arLoadProductArray);
		}
	}
	
	protected function updateElements()
	{
		$el = new CIBlockElement;
		
		$upd = 0;
		$add = 0;
		$upd_price = 0;
		
		global $USER;
		foreach ($this->json_decode as &$elem)
		{	
			$res = CIBlockElement::GetList(Array("ID"=>"ASC"), Array("IBLOCK_ID"=>IntVal($this->options["IBLOCK_ID"]), "SECTION_ID"=>IntVal($this->options["SECTION_ID"]), "NAME"=>$elem[$this->options["NAME"]]), false, false, Array("ID", "NAME", "CATALOG_GROUP_".$this->price_catalog_group));
			if($ob = $res->GetNextElement()){
				$arFields = $ob->GetFields();
				$arLoadProductArray = Array(
				  "MODIFIED_BY"    => $USER->GetID(),
				  "ACTIVE"         => "Y", 
				  );
				if($el->Update($arFields["ID"], $arLoadProductArray))
				{
					$upd++;
					if($arFields["CATALOG_PRICE_".$this->price_catalog_group] != $elem[$this->options["PRICE"]]){
						if($this->updatePriceElement($arFields["ID"], $elem[$this->options["PRICE"]])){
							$upd_price++;
						}
					}					
				}else{
					echo "Error Update: ".$elem["ID"];
				}
			}
			else{
				$arLoadProductArray = Array(
				  "MODIFIED_BY"    => $USER->GetID(),
				  "IBLOCK_SECTION_ID" => IntVal($this->options["SECTION_ID"]),
				  "IBLOCK_ID"      => IntVal($this->options["IBLOCK_ID"]),
				  "NAME"           => $elem["number"],
				  "ACTIVE"         => "Y",
				  "CODE" 		   => $elem["number"]
				  );
				if($PRODUCT_ID = $el->Add($arLoadProductArray)){
				  $add++;
				  $this->updatePriceElement($PRODUCT_ID, $elem[$this->options["PRICE"]]);
				}
				else{
				  echo "Error: ".$el->LAST_ERROR."<br/>";
				}
			}
		}
		unset($this->json_decode);
		$this->result['ADD'] += $add;
		$this->result['UPD'] += $upd;
		$this->result['COUNT_PRICE'] += $upd_price;
		$total = $add+$upd;
		$this->result['TOTAL_ACTIVE'] += $total;
		
		return $this->result;
	}
	
	
	protected function updatePriceElement($elementID, $price)
    {
		$PRODUCT_ID = $elementID;
		$PRICE_TYPE_ID = $this->options["PRICE_ID"];
		
		$arFieldsPrice = Array(
			"PRODUCT_ID" => $PRODUCT_ID,
			"CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
			"PRICE" => $price,
			"CURRENCY" => "RUB",
			"QUANTITY_FROM" => false,
			"QUANTITY_TO" => false
		);
		
		$arFields = array(
			"ID" => $PRODUCT_ID, 
			"QUANTITY" => 1
		);
		
		$res_price = CPrice::GetList(
			array(),
			array(
					"PRODUCT_ID" => $PRODUCT_ID,
					"CATALOG_GROUP_ID" => $PRICE_TYPE_ID
				)
		);

		if ($arr = $res_price->Fetch())
		{
			if(CPrice::Update($arr["ID"], $arFieldsPrice)){
				return true;
			}
		}
		else
		{
			CPrice::Add($arFieldsPrice);
			CCatalogProduct::Add($arFields);
		}		
	}
	
	static function delElements()
	{
		$el = new CIBlockElement;
		
		global $USER;
		$res = CIBlockElement::GetList(Array("ID"=>"ASC"), Array("IBLOCK_ID"=>IntVal($this->options["IBLOCK_ID"]), "SECTION_ID"=>IntVal($this->options["SECTION_ID"]), "NAME"=>$elem["number"]), false, false, Array("ID", "NAME"));
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			
			if(CIBlock::GetPermission(IntVal($this->options["IBLOCK_ID"]))>='W')
			{
				CIBlockElement::Delete($arFields["ID"]);			
			}	
		}
	}
	
}


?>