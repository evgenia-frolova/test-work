<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TestController extends ActiveController
{
    public function verbs()
    {
        return [
            'view' => ['GET'],
            'delete' => ['DELETE'],
            'create' => ['POST'],
        ];
    }

    /*
     * добавление и обновление
     * */
    public function actionCreate($id = null)
    {
        // $id - id пользователя, если обновляем данные или добавляем новый номер телефона для пользователя
        $postData = Yii::$app->request->post();

        //предположим, что пришли данные из post с 2мя массивами - TestWorkUser и TestWorkPhone
        //TestWorkPhone пришло в качестве массива из номеров телефонов, поскольку телефонов может быть много

        if ($id) {
            $user = \TestWorkUser::find()->where(['id' => $id])->one();
            if (!$user) {
                return NotFoundHttpException::class('Пользователь с таким id не существует');
            }
        } else {
            $user = new \TestWorkUser();
        }

        if ($postData['TestWorkUser']) {
            $user->load($postData['TestWorkUser']);

            $transaction = \Yii::$app->getDb()->beginTransaction();

            if (!$user->validate) {
                return $user;
            }

            if (!$user->save()) {
                $transaction->rollBack();
                return BadRequestHttpException::class('При добавлении нового пользователя произошла ошибка');
            }

            if ($postData['TestWorkPhone']) {
                foreach ($postData['TestWorkPhone'] as $value) {
                    if ($value) {
                        $phone = new \TestWorkPhone();
                        $phone->user_id = $user->id;
                        $phone->phone_number = $value;

                        if (!$phone->validate) {
                            return $phone;
                        }

                        if (!$phone->save()){
                            $transaction->rollBack();
                            return BadRequestHttpException::class('При добавлении номера телефона произошла ошибка');
                        }
                    }
                }
            }

            $transaction->commit();
        }

        return true;
    }

    /*
     * удаление пользователя
     * */
    public function actionDelete($id)
    {
        $user = \TestWorkUser::find()->where(['id' => $id])->one();

        if (!$user) {
            return NotFoundHttpException::class('Пользователь с таким id не существует');
        }

        $phone = $user->phone;

        $transaction = \Yii::$app->getDb()->beginTransaction();

        // удаляем телефоны пользователя
        if ($phone) {
            foreach ($phone as $value) {
                if (!$value->delete()) {
                    $transaction->rollBack();
                    return BadRequestHttpException::class('При удалении номера телефона произошла ошибка');
                }
            }
        }

        //удаляем пользователя из справочника
        if (!$user->delete()){
            $transaction->rollBack();
            return BadRequestHttpException::class('При удалении пользователя произошла ошибка');
        }

        $transaction->commit();

        return true;
    }

    public function actionView($id)
    {
        $user = \TestWorkUser::find()->where(['id' => $id])->one();

        if (!$user) {
            return NotFoundHttpException::class('Пользователь с таким id не существует');
        }

        $phone = $user->phone;

        return [
            'User' => $user,
            'Phone' => $phone,
        ];
    }
}