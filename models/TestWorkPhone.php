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
class TestWorkPhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_work_phone}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['phone_number'], 'string', 'max' => 100],
            [['phone_number'], 'match', 'pattern'=>'/^[0-9]+$/', 'message' => 'Значение поля должно содержать только цифры'],
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
    public function getUser()
    {
        return $this->hasOne(TestWorkUser::class, ['id' => 'user_id']);
    }
}
