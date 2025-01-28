
    <h2>Register</h2>
    <?php $form::begin('register', 'post') ?>
        <div class="row">
            <div class="col">
                <?= $form->field($model, 'first_name') ?>
            </div>
            <div class="col">
                <?php echo $form->field($model, 'last_name') ?>
            </div>
        </div>
        <?= $form->field($model, 'email', 'email') ?>
        <?= $form->field($model, 'password', 'password') ?>
        <?= $form->field($model, 'confirm_password', 'password') ?>
    <?php $form::end() ?>