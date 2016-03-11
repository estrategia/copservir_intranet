
<?php
use app\modules\intranet\models\Menu;

$opciones = Menu::construirArrayMenu();
$items = [
                ['title' => 'Category 1 <input type="checkbox" />','folder' => true],
                ['title' => 'Category 2'],
                [
                    'title' => 'Category 3',
                    'children' => [
                        [
                            'title' => 'Category 3.1',
                        ],
                        [
                            'title' => 'Category 3.2',
                            'children' => [
                                [
                                    'title' => '<a href="#">Category 3.2.1</a> <input type="checkbox" />',
                                ]
                            ],
                            'folder' => true
                        ],
                    ],
                    'folder' => true,
                ]

            ];

echo yii2mod\tree\Tree::widget([
            'items' => $opciones,
            'options' => [
                'autoCollapse' => true,
                'clickFolderMode' => 2,
                'activate' => new \yii\web\JsExpression('
                        function(node, data) {
                              node  = data.node;
                              // Log node title
                              console.log(node.title);
                        }
                ')
            ]
        ]);