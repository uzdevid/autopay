<?php

namespace app\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\Response;

class ResponseBootstrap implements BootstrapInterface {

    public function bootstrap($app) {
        $app->response->on(Response::EVENT_BEFORE_SEND, function ($event) {
            $response = $event->sender;
            $response->data = [
                'success' => $response->isSuccessful,
                'body' => $response->data,
            ];
        });

        if (Yii::$app->request->headers->has('Accept-Language')) {
            Yii::$app->language = Yii::$app->request->headers->get('Accept-Language');
        }
    }
}