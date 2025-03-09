
    <?php
        /** @var $model \app\models\User */
        /** @var $form \app\core\form\Form */
    ?>
    <h2>Login</h2>
    <?php $form::begin('login', 'post') ?>
        
        <?php if (app\core\Application::$app->session->getFlash('error')) : ?>
            <div class="alert alert-danger">
                <?php echo app\core\Application::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'email', 'email') ?>
        <?= $form->field($model, 'password', 'password') ?>
        
    <?php $form::end() ?>
