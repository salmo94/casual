<?php

namespace backend\controllers;

use common\models\ItemChild;
use common\models\Permission;
use common\models\Role;
use common\models\search\SearchRole;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\Response;

class RoleController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $permissions = Permission::find()
            ->select('name')
            ->where(['type' => Permission::TYPE_PERMISSION])
            ->indexBy('name')
            ->column();
        $searchRole = new SearchRole();
        $dataProvider = $searchRole->search(Yii::$app->request->get());

        return $this->render('index', [
                'searchRole' => $searchRole,
                'dataProvider' => $dataProvider,
                'permissions' => $permissions
            ]
        );
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $role = new Role();
        $permissions = Permission::find()
            ->select(['name', 'description'])
            ->where(['type' => Permission::TYPE_PERMISSION])
            ->asArray()
            ->all();
        if ($role->load(Yii::$app->request->post()) && $role->save()) {
            $newPermissions = Yii::$app->request->post('permission');
            foreach (array_keys($newPermissions) as $permission) {
                $itemChild = new ItemChild();
                $itemChild->parent = $role->name;
                $itemChild->child = $permission;
                $itemChild->save();
            }
            Yii::$app->session->setFlash('success', "Роль '$role->name' створено");

            return $this->redirect('index');
        }
        return $this->render('create', [
            'role' => $role,
            'permissions' => $permissions,
            'existPermissions' => []
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $role = Role::findOne($id);
        $existPermissions = ItemChild::find()
            ->select('child')
            ->where(['parent' => $role->name])
            ->column();
        $permissions = Permission::find()
            ->select(['name', 'description'])
            ->where(['type' => Permission::TYPE_PERMISSION])
            ->asArray()
            ->all();
        if ($role->load(Yii::$app->request->post()) && $role->save()) {
            $newPermissions = Yii::$app->request->post('permission');
            foreach (array_keys($newPermissions) as $permission) {
                if (in_array($permission, $existPermissions)) {
                    continue;
                }
                $itemChild = new ItemChild();
                $itemChild->parent = $role->name;
                $itemChild->child = $permission;
                $itemChild->save();
            }
            foreach ($existPermissions as $existPermission) {
                if (!array_key_exists($existPermission, $newPermissions)) {
                    ItemChild::deleteAll(['parent' => $role->name, 'child' => $existPermission]);
                }
            }
            Yii::$app->session->setFlash('success', "Роль '$role->name' оновлена");

            return $this->redirect('index');
        }
        return $this->render('update', [
            'role' => $role,
            'permissions' => $permissions,
            'existPermissions' => $existPermissions
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): Response
    {
        $role = Role::findOne($id);
        $role->delete();
        Yii::$app->session->setFlash('success', "Роль '$role->name' видалена");

        return $this->redirect('index');
    }
}
