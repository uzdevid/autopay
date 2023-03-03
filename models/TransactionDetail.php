<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction_detail".
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $detail_id
 * @property string $name
 * @property string|null $value
 * @property string $value_type
 *
 * @property TransactionDetail $detail
 * @property Transaction $transaction
 * @property TransactionDetail[] $transactionDetails
 */
class TransactionDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_detail';
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
            [['transaction_id', 'detail_id', 'name', 'value_type'], 'required'],
            [['transaction_id', 'detail_id'], 'integer'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['value_type'], 'string', 'max' => 12],
            [['detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionDetail::class, 'targetAttribute' => ['detail_id' => 'id']],
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
            'detail_id' => Yii::t('app', 'Detail ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'value_type' => Yii::t('app', 'Value Type'),
        ];
    }

    /**
     * Gets query for [[Detail]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetail()
    {
        return $this->hasOne(TransactionDetail::class, ['id' => 'detail_id']);
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
     * Gets query for [[TransactionDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, ['detail_id' => 'id']);
    }
}
