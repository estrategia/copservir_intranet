<?php
return [
  'intranet' => [
      'class' => 'app\modules\intranet\IntranetModule',
      'modules' => [
        'formacioncomunicaciones' => [
            'class' => 'app\modules\intranet\modules\formacioncomunicaciones\FormacionComunicacionesModule',
        ],
        'servicop' => [
            'class' => 'app\modules\intranet\modules\servicop\ServicopModule',
            'modules' => [
              'creditos' => [
                'class' => 'app\modules\intranet\modules\servicop\modules\creditos\CreditosModule'
              ],
              'contribuciones' => [
                'class' => 'app\modules\intranet\modules\servicop\modules\contribuciones\ContribucionesModule'
              ]
            ]
        ],
      ],
  ],
  'proveedores' => [
      'class' => 'app\modules\proveedores\ProveedoresModule',
      'modules' => [
          'visitamedica' => [
              'class' => 'app\modules\proveedores\modules\visitamedica\VisitaMedicaModule',
          ],
      ],
  ],
  'convenios' => [
      'class' => 'app\modules\convenios\ConveniosModule',
  ],
  'copservir' => [
      'class' => 'app\modules\copservir\CopservirModule',
  ],
  'tarjetamas' => [
      'class' => 'app\modules\tarjetamas\TarjetaMasModule',
  ],
  'trademarketing' => [
      'class' => 'app\modules\trademarketing\TradeMarketingModule',
  ],
  'treemanager' => [
      'class' => '\kartik\tree\Module',
  ],
  'newportal' => [
    'class' => 'app\modules\newportal\NewPortalModule',
  ],
  'prueba' => [
    'class' => 'app\modules\prueba\PruebaModule',
  ],
];