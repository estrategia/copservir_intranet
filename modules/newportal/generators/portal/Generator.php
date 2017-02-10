<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\newportal\generators\portal;

use yii\gii\CodeFile;
use yii\helpers\Html;
use Yii;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;
use app\modules\intranet\models\Portal;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @property string $controllerNamespace The controller namespace of the module. This property is read-only.
 * @property boolean $modulePath The directory that contains the module class. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    public $moduleClass;
    public $moduleID;
    public $portalColor;
    public $portalLogo;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Generador de portales';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Este módulo le permitira generar el código de esqueleto necesario para crear un portal.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['moduleID', 'moduleClass'], 'filter', 'filter' => 'trim'],
            [['moduleID', 'moduleClass'], 'required'],
            [['moduleID'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Solo se permiten caracteres alfabéticos y barras inversas.'],
            [['moduleClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Solo se permiten caracteres alfabéticos y barras inversas.'],
            [['portalColor'], 'required'],
            [['moduleClass'], 'validateModuleClass'],
            [['portalLogo'], 'file', 'extensions' => 'jpg, png, jpeg', 'wrongExtension' => 'El archivo {file} no contiene una extensión permitida {extensions}', 'maxFiles' => 1, ],

        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'moduleID' => 'ID del módulo',
            'moduleClass' => 'Clase del módulo',
            'portalColor' => 'Color del portal',
            'portalLogo' => 'Logo del portal'
        ];
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return [
            'moduleID' => 'Este es el ID del módulo, e.j: <code>admin</code>.',
            'moduleClass' => 'Este es el nombre completo de la clase del módulo, incluyendo el namespace e.j: <code>app\modules\admin\Module</code>.',
        ];
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        if (Yii::$app->hasModule($this->moduleID)) {
            $link = Html::a('Visitarlo', Yii::$app->getUrlManager()->createUrl($this->moduleID), ['target' => '_blank']);

            return "El portal se ha generado correctamente. $link.";
        }

//         $output = <<<EOD
// <p>The module has been generated successfully.</p>
// <p>To access the module, you need to add this to your application configuration:</p>
// EOD;
//         $code = <<<EOD
// <?php
//     ......
//     'modules' => [
//         '{$this->moduleID}' => [
//             'class' => '{$this->moduleClass}',
//         ],
//     ],
//     ......
// EOD;

//         return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['module.php', 'controller.php', 'view.php', 'main.php'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render("module.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/controllers/DefaultController.php',
            $this->render("controller.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/views/layouts/main.php',
            $this->render("main.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/views/default/index.php',
            $this->render("view.php")
        );
        // $preview = Yii::$app->request->post('preview');
        $this->uploadLogo();
        $this->saveImagePlaceholders();
        $this->saveModuleOnDB();
        return $files;
    }

    /**
     * Validates [[moduleClass]] to make sure it is a fully qualified class name.
     */
    public function validateModuleClass()
    {
        if (strpos($this->moduleClass, '\\') === false || Yii::getAlias('@' . str_replace('\\', '/', $this->moduleClass), false) === false) {
            $this->addError('moduleClass', 'El namespace de la clase del módulo debe ser correcto.');
        }
        if (empty($this->moduleClass) || substr_compare($this->moduleClass, '\\', -1, 1) === 0) {
            $this->addError('moduleClass', 'El namespace de la clase del módulo no debe estar vacio. Por favor ingrese un nombre de clase con el namespace correspondiente. e.j: "app\\modules\\admin\\Module".');
        }
    }

    /**
     * @return boolean the directory that contains the module class
     */
    public function getModulePath()
    {
        return Yii::getAlias('@' . str_replace('\\', '/', substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\'))));
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getControllerNamespace()
    {
        return substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\')) . '\controllers';
    }

    public function setModuleConfig()
    {
        $file = fopen(\Yii::$app->basePath . '/config/modules.php', "c");
$code = <<<EOD

  '{$this->moduleID}' => [
    'class' => '{$this->moduleClass}',
  ],
];
EOD;
        fseek($file, -3, SEEK_END);
        fwrite($file, $code);
        fclose($file);
    }

    public function uploadLogo()
    {
        $file = UploadedFile::getInstance($this, 'portalLogo');
        if ($file) {
            Yii::$app->session->set('portalLogo', $_FILES);
        }
        if ($file) {
            $rutaImagen = "logo_header.$file->extension";
            $folder = Yii::getAlias('@webroot') . '/img/multiportal/' . "{$this->moduleID}";
            if (!is_dir($folder)) {
                mkdir($folder, 0777);         
            }
            $file->saveAs($folder . '/' . $rutaImagen);
        }
    }

    public function saveImagePlaceholders()
    {   
        $folder = Yii::getAlias('@webroot') . '/img/multiportal/' . "{$this->moduleID}";
        $slidesFolder = Yii::getAlias('@webroot') . '/img/multiportal/' . "{$this->moduleID}" . '/slides';
        if (!is_dir($folder)) {
            mkdir($folder, 0777);         
        }
        if (!is_dir($slidesFolder)) {
            mkdir($slidesFolder, 0777);         
        }
        copy(Yii::getAlias('@webroot') . '/img/multiportal/' . 'slideplaceholder.png', $slidesFolder . '/banner-home.png');
        copy(Yii::getAlias('@webroot') . '/img/multiportal/' . 'sectionplaceholder.png', $slidesFolder . '/sectionplaceholder.png');
    }

    public function saveModuleOnDB()
    {
        $portal = Portal::find()->where(['nombrePortal' => $this->moduleID])->one();
        if ($portal == null) {
            $portal = new Portal;
            $portal->nombrePortal = $this->moduleID;
            $portal->estado = 1;
            $portal->save();
        }
    }
}
