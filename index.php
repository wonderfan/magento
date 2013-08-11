<?php

switch($_SERVER['HTTP_HOST']) {
  case 'volluma.es':
  case 'www.volluma.es':
  case 'hairfor2.es':
  case 'www.hairfor2.es':
  case 'volluma.magenting.com':
  case 'volluma.local:8080':
    Mage::run('volluma_es', 'store');
  break;

  case 'hairfor2.es':
  case 'www.hairfor2.es':
    Mage::run('volluma_es', 'store');
  break;

  case 'blax.es':
  case 'www.blax.es':
    Mage::run('blax_es', 'store');
  break;
  
  case 'test.couvre.es':
  case 'couvre.es':
  case 'www.couvre.es':
  case 'test.toppik-espana.es':
  case 'toppik-espana.es':
  case 'www.toppik-espana.es':
  case 'test.toppik-espana.com':
  case 'toppik-espana.com':
  case 'www.toppik-espana.com':
  case 'toppik.magenting.com':
  case 'toppik.local:8080':
  case 'toppek.es':
  case 'www.toppek.es':
  case 'xfusionpelo.es':
  case 'www.xfusionpelo.es':
  case 'xfusion.es':
  case 'www.xfusion.es':
  case 'x-fusion.es':
  case 'www.x-fusion.es':
  case 'xfusionhair.es':
  case 'www.xfusionhair.es':
  case 'xn--toppik-espaa-khb.es':
  case 'www.xn--toppik-espaa-khb.es':
  case 'xn--toppik-espaa-khb.com':
  case 'www.xn--toppik-espaa-khb.com':
    Mage::run('toppik_espana_com', 'store');
  break;

  
  default:
    /* Store or website code */
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';

    /* Run store or run website */
    $mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';

    Mage::run($mageRunCode, $mageRunType);
  break;
}
