<?php

namespace app\models\search;

use app\models\Mail;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class MailSearch
 * @package app\models\search
 */
class MailSearch extends Mail
{
    public function load($data, $formName = null)
    {
        $this->setAttributes(ArrayHelper::getValue($data, 'MailSearch'));
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Return filterModel
     *
     * @return static
     */
    public function filter()
    {
        return $this;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params = null)
    {
        $query = Mail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'theme', $this->theme]);
        if ($this->created_at) {
            $startDate = date('Y-m-d 00:00:00', strtotime($this->created_at));
            $endDate = date('Y-m-d 23:59:59', strtotime($this->created_at));;
            $query->andFilterWhere(['between', 'created_at', $startDate, $endDate]);
        }

        return $dataProvider;
    }
}
