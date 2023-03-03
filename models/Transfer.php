<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property int $id
 * @property int $transaction_id
 * @property string|null $request_raw
 * @property string|null $response_raw
 * @property string $request_time
 *
 * @property Transaction $transaction
 * @property TransferDetail[] $transferDetails
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transfer';
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
            [['id', 'transaction_id', 'request_time'], 'required'],
            [['id', 'transaction_id'], 'integer'],
            [['request_raw', 'response_raw'], 'string'],
            [['request_time'], 'safe'],
            [['id'], 'unique'],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::class, 'targetAttribute' => ['transaction_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'request_raw' => Yii::t('app', 'Request Raw'),
            'response_raw' => Yii::t('app', 'Response Raw'),
            'request_time' => Yii::t('app', 'Request Time'),
        ];
    }

    /**
     * Gets query for [[Transaction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::class, ['id' => 'transaction_id']);
    }

    /**
     * Gets query for [[TransferDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransferDetails()
    {
        return $this->hasMany(TransferDetail::class, ['transfer_id' => 'id']);
    }
}
