<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Remove all previous data
        $auth->removeAll();

        // Create permissions
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage user accounts';
        $auth->add($manageUsers);

        $addGames = $auth->createPermission('addGames');
        $addGames->description = 'Add games to the platform';
        $auth->add($addGames);

        $createTeamLists = $auth->createPermission('createTeamLists');
        $createTeamLists->description = 'Create team made lists';
        $auth->add($createTeamLists);

        $addGenre = $auth->createPermission('addGenre');
        $addGenre->description = 'Create team made lists';
        $auth->add($addGenre);

        $addPlatform = $auth->createPermission('addPlatform');
        $addPlatform->description = 'Create team made lists';
        $auth->add($addPlatform);

        $addFranchise = $auth->createPermission('addFranchise');
        $addFranchise->description = 'Create team made lists';
        $auth->add($addFranchise);

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        $createList = $auth->createPermission('createList');
        $createList->description = 'Create a list';
        $auth->add($createList);

        // Create roles
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);

        $gamedev = $auth->createRole('gamedev');
        $gamedev->description = 'Game developer';
        $auth->add($gamedev);

        $user = $auth->createRole('user');
        $user->description = 'Regular user';
        $auth->add($user);

        // Assign permissions to roles
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $addGames);
        $auth->addChild($gamedev, $addGames);
        $auth->addChild($moderator, $addGames);
        $auth->addChild($admin, $createTeamLists);
        $auth->addChild($moderator, $createTeamLists);
        $auth->addChild($admin, $addGenre);
        $auth->addChild($moderator, $addGenre);
        $auth->addChild($admin, $addPlatform);
        $auth->addChild($moderator, $addPlatform);
        $auth->addChild($admin, $addFranchise);
        $auth->addChild($moderator, $addFranchise);
        $auth->addChild($user, $createPost);
        $auth->addChild($user, $createList);

        // Assign roles to users (example IDs: 1 => admin, 2 => user)
        $auth->assign($admin, 1); // User ID 1 is an admin
        $auth->assign($user, 2);  // User ID 2 is a regular user

        echo "RBAC roles and permissions have been initialized.\n";
    }
}