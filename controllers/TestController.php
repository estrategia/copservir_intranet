<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\helpers\VarDumper;
use app\modules\intranet\models\Area;
use app\modules\intranet\models\Ciudad;
use yii\base\Action;

class TestController extends Controller {
	
	public function actionTest(){
		$model = new Ciudad();
		
		VarDumper::dump($model, 10, true);
	}
	
	
	public function actionModel() {
		
		$model = new \yii\base\DynamicModel([
				'name', 'email', 'address'
		]);
		
		$model->addRule(['name','email'], 'required')
		->addRule(['email'], 'email')
		->addRule('address', 'string',['max'=>32]);
		
		//VarDumper::dump($model, 10, true);
		
		
		/*if($model->load(Yii::$app->request->post())){
			// do somenthing with model
			return $this->redirect(['view']);
		}*/
		
		//return $this->render('form', ['model'=>$model]);
	    
	    $model2 = new DynamicModel(['name', 'email']);
	    $model2->addRule(['name', 'email'], 'string', ['max' => 128])
	    	->addRule('email', 'email')
	    	->validate();
	    
	    	VarDumper::dump($model2, 10, true);
    
	}
	
	public function actionPass($pass){
		$cost = Yii::$app->security->passwordHashCost;
		$cifrado = Yii::$app->security->generatePasswordHash($pass);
		
		echo "cost: $cost";
		echo "<br>Pass: $pass";
		echo "<br>Cifr: $cifrado";
	}
	
	public function actionPassvalid(){
		$pass = "luf9jiw35t";
		$hash = '$2y$13$CzkJuZ8YkhrntWsRM7fTkuGRMYJ2g66cPPwLj8PCyDXdoM9HXbhU2';
		
		if (Yii::$app->getSecurity()->validatePassword($pass, $hash)) {
			echo "validado OK.";
		} else {
			echo "validado ERROR.";
		}
	}
	
	public function actionHelper(){
	    $string= "tarjeta feláéíóúz cumpleaños";
	    //$filename = \Yii::$app->helper->cleanString($filename);
	    
	    /*$string = trim($string);
	    
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	        );
	    
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	        );
	    
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	        );
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	        );
	    
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	        );
	    
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C',),
	        $string
	        );*/
	    
	    
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    /*$string = str_replace(
	        array("\", "¨", "º", "-", "~",
             "#", "@", "|", "!", """,
	            "·", "$", "%", "&", "/",
	            "(", ")", "?", "'", "¡",
	            "¿", "[", "^", "<code>", "]",
	            "+", "}", "{", "¨", "´",
	            ">", "< ", ";", ",", ":",
	            ".", " "),
	        '',
	        $string
	        );*/
	    
	    
	    //$filename = preg_replace("/[^a-zA-Z0-9]/i",'',$filename);
	    
	    echo $string . "<br><br>tamaño: " . strlen($string) . "<br>";
	    
	    $arr = [];
	    for($i=0;$i<strlen($string);$i++){
	       // echo $string[$i]. "<br>";
	        //var_dump($string[$i]);echo " : " . ord($string[$i]) . "<br>";
	        if(ord($string[$i])==195){
	            //echo "tilde i pos [".$i."]<br>";
	            $arr[] = 'i';
	        }else{
	            $arr[] = $string[$i];
	        }
	    }
	    
	    
	    echo "<br><br>";
	    
	    
	    //$stringTest = 'Ë À Ì Â Í Ã Î Ä Ï Ç Ò È Ó É Ô Ê Õ Ö ê Ù ë Ú î Û ï Ü ô Ý õ â û ã ÿ ç';
	    
	    /*$normalizeChars = array(
	        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
	        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
	        'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
	        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
	        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
	        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
	        'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
	        'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
	    );*/
	    
	    //Output: E A I A I A I A I C O E O E O E O O e U e U i U i U o Y o a u a y c
	    //echo strtr($string, $normalizeChars);
	    
	    //$string= utf8_encode($string);
	    //echo "<br><br>$string";
	    //$string= iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	    //echo "<br><br>$string<br>";
	    
	    
	    echo "Cadena: " . implode("", $arr);
	    
	    $especial = array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä','é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë','í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î','ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô','ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'.'ñ', 'Ñ', 'ç', 'Ç');
	    
	    echo "<br>ESPECIALES:<br>";
	    foreach ($especial as $c){
	        var_dump($c); 
	        echo " :: ". utf8_encode($c) . ": " . ord("á") . "<br>";
	    }
	    
	    
	    VarDumper::dump($arr,10,true);
	}
}
