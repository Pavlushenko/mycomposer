<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>php4_3</title>
</head>
<body>
<p>Населенный пункт</p>

<?php

class apartment{
	
	public $area;	
	public $tenants;
	public $balcony;
	public $balconyNumber;	
	public $tariffHeating;
	public $tariffHotWater;
	public $tariffWater;
	public $tariffWaterOut;
	public $tariffGas;
	public $tariffTrash;
	public $tariffElectric;
	public $tariffRent;
	public $tenantsDifferent;
	
	function __construct($tariffHeating, $area, $tariffHotWater, $tenants, $tariffWater, $tariffWaterOut, $tariffGas, $tariffTrash, $tariffElectric, $tariffRent, $balcony, $balconyNumber, $tenantsDifferent) {                   //конструктор установливает значения свойств
      $this->tariffHeating = $tariffHeating;
      $this->area = $area;
	  $this->tariffHotWater = $tariffHotWater;
	  $this->tenants = $tenants;
	  $this->tariffWater = $tariffWater;
	  $this->tariffWaterOut = $tariffWaterOut;
	  $this->tariffGas = $tariffGas;
	  $this->tariffTrash = $tariffTrash;
	  $this->tariffElectric = $tariffElectric;
	  $this->tariffRent = $tariffRent;
	  $this->balcony = $balcony;
	  $this->balconyNumber = $balconyNumber;
	  $this->tenantsDifferent = $tenantsDifferent;
    }
	
	public function heating(){                                       //расчет стоимости отопления
		return $this->tariffHeating * $this->area;	
	}
	
	public function hotWater(){                                      //расчет стоимости горячей воды
		return $this->tariffHotWater * ($this->tenants + $this->tenantsDifferent);	
	}
	
	public function water(){                                         //расчет стоимости холодной воды
		return $this->tariffWater * ($this->tenants + $this->tenantsDifferent);	
	}
	
	public function waterOut(){                                      //расчет стоимости водоотведения
		return $this->tariffWaterOut * ($this->tenants + $this->tenantsDifferent);	
	}
	
	public function gas(){                                           //расчет стоимости за газ
		return $this->tariffGas * ($this->tenants + $this->tenantsDifferent);	
	}
	
	public function trash(){                                         //расчет стоимости за вывоз мусора
		return $this->tariffTrash * ($this->tenants + $this->tenantsDifferent);	
	}
	
	public function electric(){                                      //расчет стоимости за электроэнергию		
		return $this->tariffElectric * 0.3084;		
	}
	
	public function rent(){                                          //расчет стоимости квартплаты		
		return $this->tariffRent * ($this->area + $this->balcony * $this->balconyNumber);		
	}
	
	public function sum(){                                          //расчет стоимости всех услуг		
		return $this->heating() + $this->hotWater() + $this->water() + $this->waterOut() + $this->gas() + $this->trash() + $this->electric() + $this->rent();		
	}
	
	public function tenantsNum(){                                 //удаление/добавление жителя		
		return $this->tenants = $this->tenants + $this->tenantsDifferent;		
	}
}

$obj = new apartment(9.5, 65, 25.93, 1, 41.89, 24.59, 12.73, 11.54, 200, 1.5, 3, 2, 1);            //созданием объект и передаем ему аргументы

class home extends apartment{
	
	public $floors;
	public $porches;
	public $apartments = array();
	public $territory;
	
	function __construct($porches, $floors, $territory) {                   //конструктор установливает значения свойств
      $this->porches = $porches;
	  $this->floors = $floors;
      $this->territory = $territory;
    }
	
	public function electricForPorches(){                                   //расчет объема потреблемой электроэнергии в подъездах		
		return $this->porches * $this->floors * 60;		
	}
	
	public function tax(){                                                  //налог на землю 		
		return $this->territory * 400;		
	}
	
	public function communal(){
		$tenants = rand(1, 5);
		$sumServ = 0;
		for($i = 1; $i <= 24; $i++){	
			if($i < 9){
				$areaA = 35;
				$balconyNumberA = 1;
			}
			else if($i >= 9 && $i < 17){
				$areaA = 51;
				$balconyNumberA = 1;
			}
			else{
				$areaA = 65;
				$balconyNumberA = 2;
			}	
		$apartments[$i] = new apartment(9.5, $areaA, 25.93, $tenants, 41.89, 24.59, 12.73, 11.54, rand(50, 250), 1.5, 3, $balconyNumberA, 0); 
		$sumServ = $sumServ + $apartments[$i]->sum();	
		}
		return round($sumServ, 2);
	}
}

$objHome = new home(3, 4, 272);

class street extends home{

	public $nameStreet = "Коцарская";
	public $homes;
	
	function __construct($homes, $territory) {                         //конструктор установливает значения свойств
      $this->homes = $homes;
	  $this->territory = $territory;	  
    }
	
	public function windshields(){                                      //расчет кол-ва дворников		
		return round($this->homes * $this->territory / 500);		
	}
	
	public function communalAllHomes($com){                             //расчет коммунальных платежей со всех домов
		$sumServHomes = 0;
		for($j = 1; $j <= $this->homes; $j++){
			$sumServHomes = $sumServHomes + $com;
		}
		return $sumServHomes;
	}

}

$objStreet = new street(20, 272);

class locality extends street{
	
	public $nameLocality = "Харьков";
	public $foundation = 1654;
	public $coordinates = "50° 0' с.ш., 36° 15' в.д.";
	public $homesInLocality;
	
	function __construct($homesInLocality) {                           //конструктор установливает значения свойств
      $this->homesInLocality = $homesInLocality;	    
    }
	
	public function budget(){                                          //расчет бюджета 		
		$budgetHomes = 0;
		for($k = 1; $k <= $this->homesInLocality; $k++){
			$budgetHomes = $budgetHomes + rand(150, 400) * 400;
		}
		return $budgetHomes;		
	}
	
	public function residents(){
		$arrApar = array(8, 24, 32, 36, 60, 80, 112, 144, 192);		    //расчет численности населения 		
		$residentsHomes = 0;
		for($k = 1; $k <= $this->homesInLocality; $k++){			
			$residentsHomes = $residentsHomes + rand(1, 5) * $arrApar[array_rand($arrApar, 1)];
		}
		return $residentsHomes;	
	}
}

$objLocality = new locality(5000);
echo "<br><br>Название населенного пункта: ".$objLocality->nameLocality;
echo "<br>Основан в ".$objLocality->foundation." году";
echo "<br>Географические координаты: ".$objLocality->coordinates;
echo "<br>Бюджет населенного пункта в зависимости от размера налога на землю: ".$objLocality->budget()." грн"; 
echo "<br>Численность населения: ".$objLocality->residents()." человек"; 

?>

</body>
</html>