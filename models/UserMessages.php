<?php

namespace app\models;

/**
 * This is the model class for table "user_messages".
 *
 * @property int $id
 * @property int $id_messages
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Message $messages
 * @property User $user
 */
class UserMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_message', 'id_user'], 'required'],
            [['id_message', 'id_user'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_message'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['id_message' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_message' => 'Id Message',
            'id_user' => 'Id User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'id_message']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
