<?php

namespace app\models;


/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $comment
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserMessages[] $userMessages
 */
class Message extends \yii\db\ActiveRecord
{

    public function fields()
    {
        return [
            'id',
            'comment',
            'status'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[UserMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserMessages()
    {
        return $this->hasMany(UserMessages::className(), ['id_messages' => 'id']);
    }
}
