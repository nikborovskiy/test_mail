<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%mail}}".
 *
 * @property int $id #
 * @property string $email Email
 * @property string $theme Тема
 * @property string $text Сообщение
 * @property string $created_at Время создания
 */
class Mail extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        \Yii::$app->mailer->compose()
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject($this->theme)
            ->setTextBody($this->text)
            ->send();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['email', 'theme'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'email' => 'Email',
            'theme' => 'Тема',
            'text' => 'Сообщение',
            'created_at' => 'Время отправки',
        ];
    }
}
