<?php

namespace app\modules\proveedores\models;
use Yii;
//use yii\data\ActiveDataProvider;

class Retencion extends \yii\db\ActiveRecord
{
	public $nit;
	
	public function attributeLabels()
    {
        return [
            'nit' => 'Digite el NIT de la empresa',
        ];
    }

	public function rules() {      
		return [
			[["nit"], "required"],						
			[["nit"], "integer"],	
		];     
    }	
}
