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

        $addGame = $auth->createPermission('addGame');
        $addGame->description = 'Add game to the platform';
        $auth->add($addGame);

        $updateGame = $auth->createPermission('updateGame');
        $updateGame->description = 'Update game in the platform';
        $auth->add($updateGame);

        $deleteGame = $auth->createPermission('deleteGame');
        $deleteGame->description = 'Deleting a game from the platform';
        $auth->add($deleteGame);

        $createTeamList = $auth->createPermission('createTeamList');
        $createTeamList->description = 'Create team made list';
        $auth->add($createTeamList);

        $updateTeamList = $auth->createPermission('updateTeamList');
        $updateTeamList->description = 'Update team made list';
        $auth->add($updateTeamList);

        $deleteTeamList = $auth->createPermission('deleteTeamList');
        $deleteTeamList->description = 'Delete team made list';
        $auth->add($deleteTeamList);

        $addGenre = $auth->createPermission('addGenre');
        $addGenre->description = 'Add a genre';
        $auth->add($addGenre);

        $updateGenre = $auth->createPermission('updateGenre');
        $updateGenre->description = 'Update a genre';
        $auth->add($updateGenre);

        $deleteGenre = $auth->createPermission('deleteGenre');
        $deleteGenre->description = 'Delete a genre';
        $auth->add($deleteGenre);

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

        $createTarefa = $auth->createPermission('createTarefa');
        $createTarefa->description = 'Criar tarefa';
        $auth->add($createTarefa);

        $updateTarefa = $auth->createPermission('updateTarefa');
        $updateTarefa->description = 'Atualizar tarefa';
        $auth->add($updateTarefa);

        $deleteTarefa = $auth->createPermission('deleteTarefa');
        $deleteTarefa->description = 'Apagar tarefa';
        $auth->add($deleteTarefa);

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
        $auth->addChild($admin, $addGame);
        $auth->addChild($gamedev, $addGame);
        $auth->addChild($moderator, $addGame);
        $auth->addChild($admin, $updateGame);
        $auth->addChild($gamedev, $updateGame);
        $auth->addChild($moderator, $updateGame);
        $auth->addChild($admin, $deleteGame);
        $auth->addChild($gamedev, $deleteGame);
        $auth->addChild($moderator, $deleteGame);
        $auth->addChild($admin, $createTeamList);
        $auth->addChild($moderator, $createTeamList);
        $auth->addChild($admin, $updateTeamList);
        $auth->addChild($moderator, $updateTeamList);
        $auth->addChild($admin, $deleteTeamList);
        $auth->addChild($moderator, $deleteTeamList);
        $auth->addChild($admin, $addGenre);
        $auth->addChild($moderator, $addGenre);
        $auth->addChild($admin, $updateGenre);
        $auth->addChild($moderator, $updateGenre);
        $auth->addChild($admin, $deleteGenre);
        $auth->addChild($moderator, $deleteGenre);
        $auth->addChild($admin, $addPlatform);
        $auth->addChild($moderator, $addPlatform);
        $auth->addChild($admin, $addFranchise);
        $auth->addChild($moderator, $addFranchise);
        $auth->addChild($user, $createPost);
        $auth->addChild($user, $createList);
        $auth->addChild($admin, $createTarefa);
        $auth->addChild($admin, $updateTarefa);
        $auth->addChild($admin, $deleteTarefa);

        $auth->assign($admin, 1);
        $auth->assign($moderator, 2);
        $auth->assign($gamedev, 3);

        echo "RBAC roles and permissions have been initialized.\n";
    }
}