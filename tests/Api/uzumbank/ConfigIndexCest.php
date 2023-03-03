<?php

namespace Api\uzumbank;

use Tests\Support\ApiTester;

class ConfigIndexCest {
    private string $_url = '/uzumbank/config/index';

    public function unauthorized(ApiTester $I): void {
        $I->haveHttpHeader('Authorization', 'Bearer INVALID_TOKEN');

        $I->sendGET($this->_url);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'success' => 'boolean',
            'body' => [
                'name' => 'string',
                'message' => 'string',
                'code' => 'integer',
                'status' => 'integer',
                'type' => 'string',
            ],
        ]);
    }

    public function methodNotAllowed(ApiTester $I): void {
        $I->sendPost($this->_url, []);

        $I->seeResponseCodeIs(405);

        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'success' => 'boolean',
            'body' => [
                'name' => 'string',
                'message' => 'string',
                'code' => 'integer',
                'status' => 'integer',
                'type' => 'string',
            ],
        ]);
    }

    public function checkEnabled(ApiTester $I): void {
        $I->sendGET($this->_url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'success' => 'boolean',
            'body' => [
                'enabled' => 'boolean'
            ]
        ]);
    }
}
