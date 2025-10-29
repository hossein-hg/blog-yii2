<?php

use yii\db\Migration;

class m251029_053953_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "viewPost" permission
        $viewPost = $auth->createPermission('viewPost');
        $viewPost->description = 'view post';
        $auth->add($viewPost);

        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'delete post';
        $auth->add($deletePost);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createPost);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $viewPost);
        $auth->addChild($admin, $deletePost);

        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);
        $auth->addChild($author, $viewPost);

        $auth->assign($author, 2);
        $auth->assign($admin, 1);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251029_053953_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251029_053953_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
