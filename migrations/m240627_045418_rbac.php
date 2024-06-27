<?php

use yii\db\Migration;

class m240627_045418_rbac extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $creator = $auth->createPermission('creator');
        $creator->description = 'Возможность создавать новые заявки';
        $auth->add($creator);

        $editor = $auth->createPermission('editor');
        $editor->description = 'Возможность изменять ранее созданную заявку';
        $auth->add($editor);

        $editorAll = $auth->createPermission('editorAll');
        $editorAll->description = 'Возможность изменять все заявки';
        $auth->add($editorAll);

        $deleter = $auth->createPermission('deleter');
        $deleter->description = 'Возможность удалять заявки';
        $auth->add($deleter);

        $viewer = $auth->createPermission('viewer');
        $viewer->description = "Возможность просмотра заявок";
        $auth->add($viewer);

        $user = $auth->createRole('user');
        $user->description = "Обычный пользователь";
        $auth->add($user);
        $auth->addChild($user, $viewer);

        $author = $auth->createRole('author');
        $author->description = "Верифицированный пользователь";
        $auth->add($author);
        $auth->addChild($author, $user);
        $auth->addChild($author, $creator);
        $auth->addChild($author, $editor);

        $admin = $auth->createRole('admin');
        $admin->description = "Администратор";
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $editorAll);
        $auth->addChild($admin, $deleter);
    }

    public function safeDown()
    {
        echo "m240627_045418_rbac cannot be reverted.\n";

        return false;
    }
}
