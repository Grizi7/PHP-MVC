
    <?php
        /** @var Model $model \app\models\User */
        /** @var Form $form \app\core\form\Form */
    ?>
    <h2>Login</h2>
    <?php $form::begin('login', 'post') ?>
        
        <?php if (sessionFlashGet('error')): ?>
            <div class="alert alert-danger">
                <?= sessionFlashGet('error') ?>
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'email', 'email') ?>
        <?= $form->field($model, 'password', 'password') ?>
        
    <?php $form::end() ?>
