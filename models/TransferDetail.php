<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer_detail".
 *
 * @property int $id
 * @property int $transfer_id
 * @property int $detail_id
 * @property string $name
 * @property string|null $value
 * @property string $value_type
 *
 * @property TransferDetail $detail
 * @property Transfer $transfer
 * @property TransferDetail[] $transferDetails
 */
class TransferDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transfer_detail';
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
            [['transfer_id', 'detail_id', 'name', 'value_type'], 'required'],
            [['transfer_id', 'detail_id'], 'integer'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['value_type'], 'string', 'max' => 12],
            [['detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransferDetail::class, 'targetAttribute' => ['detail_id' => 'id']],
            [['transfer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transfer::class, 'targetAttribute' => ['transfer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transfer_id' => Yii::t('app', 'Transfer ID'),
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
        return $this->hasOne(TransferDetail::class, ['id' => 'detail_id']);
    }

    /**
     * Gets query for [[Transfer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransfer()
    {
        return $this->hasOne(Transfer::class, ['id' => 'transfer_id']);
    }

    /**
     * Gets query for [[TransferDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransferDetails()
    {
        return $this->hasMany(TransferDetail::class, ['detail_id' => 'id']);
    }
}
