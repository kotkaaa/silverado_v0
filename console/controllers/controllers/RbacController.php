<?php


namespace console\controllers;

use yii\console\Controller;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{

    /**
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        // add "createPost" permission
        $adminPermission = $auth->createPermission('admin');
        $adminPermission->description = 'Admin area';
        $auth->add($adminPermission);

        // add "updatePost" permission
        $userPermission = $auth->createPermission('user');
        $userPermission->description = 'Registered user';
        $auth->add($userPermission);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $adminPermission);

        $user = $auth->createRole('admin');
        $auth->add($user);
        $auth->addChild($user, $userPermission);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }
}