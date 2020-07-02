<?php

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%data_model}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $last_update
 */
class TestWorkUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_work_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name'], 'required'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 100],
            [['last_update'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'last_update' => 'Дата обновления'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhone()
    {
        return $this->hasMany(TestWorkPhone::class, ['user_id' => 'id']);
    }
}
