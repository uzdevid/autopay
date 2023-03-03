<?php

namespace app\models;

use yii\base\BaseObject;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $name
 * @property string $accessToken
 */
class Project extends BaseObject implements IdentityInterface {
    private static $projects = [
        'autopay.uz' => [
            'id' => 'autopay.uz',
            'name' => "Auto Pay",
            'accessToken' => 'RnBvbnkKNzAYJaqoVFRjMLWNUEAosgeZdYfJBICaeCeuJbZToh',
        ],
    ];

    public $id;
    public $name;
    public $accessToken;

    /**
     * @param $id
     * @return IdentityInterface|static|null
     */
    public static function findIdentity($id) {
        return isset(self::$projects[$id]) ? new static(self::$projects[$id]) : null;
    }

    /**
     * @param $token
     * @param $type
     * @return IdentityInterface|static|null
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        foreach (self::$projects as $project) {
            if ($project['accessToken'] === $token) {
                return new static($project);
            }
        }

        return null;
    }

    /**
     * @return int|string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getAuthKey() {
        return null;
    }

    /**
     * @param $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool {
        return false;
    }
}
