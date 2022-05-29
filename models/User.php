<?php

namespace app\models;


use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['email'], 'email'],
            [['email', 'name'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[UserMessages]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'id_message'])->viaTable('user_message', [
            'id_user' => 'id'
        ]);
    }

    /**
     * @param $name
     * @return string|null
     */
    public function checkEmail($name)
    {
        return User::findOne(['name' => $name])->email;
    }
}
