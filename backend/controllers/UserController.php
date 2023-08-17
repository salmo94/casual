<?php

namespace backend\controllers;

use common\models\Assignment;
use common\models\ItemChild;
use common\models\Role;
use common\models\search\SearchUser;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update','delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'permissions' => ['indexUser'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'permissions' => ['createUser'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'permissions' => ['updateUser'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'permissions' => ['deleteUser'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $roles = Role::find()
            ->select('name')
            ->where(['type' => Role::TYPE_ROLE])
            ->indexBy('name')
            ->column();
        $userSearch = new SearchUser();
        $dataProvider = $userSearch->search(Yii::$app->request->get());

        return $this->render('index', [
                'userSearch' => $userSearch,
                'dataProvider' => $dataProvider,
                'roles' => $roles,
            ]
        );
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $user = new User();
        $roles = Role::find()
            ->select(['name', 'description'])
            ->where(['type' => Role::TYPE_ROLE])
            ->asArray()
            ->all();
        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $user->generateAuthKey();
            $user->setPassword($user->password);
            $user->save(false);

            $newRoles = Yii::$app->request->post('role');
            foreach (array_keys($newRoles) as $role) {
                $assignment = new Assignment();
                $assignment->item_name = $role;
                $assignment->user_id = $user->id;
                $assignment->save();
            }
            Yii::$app->session->setFlash('success', "Користувач '$user->username' створений");

            return $this->redirect('index');
        }
        return $this->render('create', [
            'user' => $user,
            'roles' => $roles,
            'existRoles' => []
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $roles = Role::find()
            ->select(['name', 'description'])
            ->where(['type' => Role::TYPE_ROLE])
            ->asArray()
            ->all();
        $existRoles = Assignment::find()
            ->select('item_name')
            ->where(['user_id' => $user->id])
            ->column();
        if (!$user) {
            throw new NotFoundHttpException("Користувача з id: $id не знайдено");
        }
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            $newRoles = Yii::$app->request->post('role');
            foreach (array_keys($newRoles) as $role) {
                if (in_array($role, $existRoles)) {
                    continue;
                }
                $assignment = new Assignment();
                $assignment->item_name = $role;
                $assignment->user_id = $user->id;
                $assignment->save();
            }
            foreach ($existRoles as $role) {
                if (!array_key_exists($role, $newRoles)) {
                    Assignment::deleteAll(['user_id' => $user->id, 'item_name' => $role]);
                }
            }
            Yii::$app->session->setFlash('success', "Дані користувача '$user->username' оновлені");

            return $this->redirect('index');
        } else {
            return $this->render('update', [
                    'user' => $user,
                    'roles' => $roles,
                    'existRoles' => $existRoles
                ]
            );
        }
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete($id): Response
    {
        $user = User::findOne($id);
        $user->is_deleted = true;
        $user->save(false);
        Yii::$app->session->setFlash('success', "Користувача '$user->username' видалено");

        return $this->redirect(['index']);
    }
}
