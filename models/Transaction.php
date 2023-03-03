<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $module
 * @property string $payment_system
 * @property string|null $request_raw
 * @property string|null $response_raw
 * @property int $request_time
 *
 * @property TransactionDetail[] $transactionDetails
 * @property Transfer[] $transfers
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('autopay');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'module', 'payment_system', 'request_time'], 'required'],
            [['id', 'request_time'], 'integer'],
            [['request_raw', 'response_raw'], 'string'],
            [['module'], 'string', 'max' => 32],
            [['payment_system'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'module' => Yii::t('app', 'Module'),
            'payment_system' => Yii::t('app', 'Payment System'),
            'request_raw' => Yii::t('app', 'Request Raw'),
            'response_raw' => Yii::t('app', 'Response Raw'),
            'request_time' => Yii::t('app', 'Request Time'),
        ];
    }

    /**
     * Gets query for [[TransactionDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, ['transaction_id' => 'id']);
    }

    /**
     * Gets query for [[Transfers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransfers()
    {
        return $this->hasMany(Transfer::class, ['transaction_id' => 'id']);
    }
}
