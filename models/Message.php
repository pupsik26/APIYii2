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
            [['created_at', 'updated_at', 'id'], 'safe'],
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, ['id' => 'id_user'])->viaTable('user_message', [
            'id_message' => 'id'
        ]);
    }
}
