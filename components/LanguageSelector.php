<?php

namespace app\components;

use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $lang = $app->request->get('lang');
        if ( isset($lang) ) {
            $app->session->set('lang', $lang); 
        } 
        if ($app->session->has('lang')) {
            $app->language = $app->session->get('lang');
        }
    }
}

