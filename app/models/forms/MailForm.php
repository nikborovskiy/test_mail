<?php
namespace app\models\forms;
use app\models\Mail;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;


/**
 * Class PostForm
 * @package app\models\forms
 */
class MailForm extends AbstractForm
{
    public $id;
    public $email;
    public $theme;
    public $text;

    /**
     * @inheritdoc
     */
    public function data()
    {
        return \Yii::createObject(Mail::className());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->data()->attributeLabels() ;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'theme', 'text'], 'required'],
            [['text', ], 'string'],
            [['email'], 'email'],
            [['theme'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $model = $this->getModel();
        if (!$model->isNewRecord) {
            $this->setAttributes($model->getAttributes(), false);
        }
        if (parent::load($data, $formName)) {
            return true;
        }
        return false;
    }

    /**
     * Save form
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            if ($this->id) {
                if ($model->isNewRecord) {
                    return false;
                }
            }
            $model->setAttributes($this->getAttributes($this->safeAttributes()), false);
            if ($model->save()) {
                $this->id = $model->id;
                return true;
            }
        }
        return false;
    }

    /**
     * Find model for form
     *
     * @param string|ActiveRecord $object
     * @return static
     */
    public function setModel($object)
    {
        $this->_model = $object;
        return $this;
    }

    /**
     * Find model for form
     *
     * @return Mail
     * @throws MailFormException
     * @throws \yii\base\InvalidConfigException
     */
    public function getModel()
    {
        if ($this->_model === null) {
            if ($this->id) {
                $this->_model = Mail::find()->andWhere(['id' => $this->id])->one();
                if (null == $this->_model) {
                    throw new MailFormException(
                        'Model "Mail" not found ' . VarDumper::dumpAsString($this->id),
                        MailFormException::EXCEPTION_MODEL_NOT_FOUND
                    );
                }
            } else {
                $this->_model = \Yii::createObject(Mail::className());
            }
        }
        return $this->_model;
    }
}

class MailFormException extends Exception
{
    const EXCEPTION_MODEL_NOT_FOUND = 1;
}
