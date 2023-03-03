<?php


namespace Api;

use Tests\Support\ApiTester;

class AuthorizationCest {
    private string $_url = '/';

    public function authWithInvalidToken(ApiTester $I): void {
        $I->haveHttpHeader('Authorization', 'Bearer INVALID_TOKEN');

        $I->sendGET($this->_url);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'body' => [
                'name' => 'Unauthorized',
                'message' => 'Your request was made with invalid credentials.',
                'code' => 0,
                'status' => 401,
                'type' => 'yii\\web\\UnauthorizedHttpException',
            ],
        ]);
    }

    public function auth(ApiTester $I): void {
        $I->sendGET($this->_url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'body' => [
                'enabled' => true
            ]
        ]);
    }
}
