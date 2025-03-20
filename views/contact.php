
    <?php
        $this->title = 'Contact Us';
    ?>
    <h2>Contact Us</h2>
    <?= $form->begin('contact', 'POST') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email', 'email') ?>
        <?= $form->field($model, 'subject') ?>
        <?= $form->field($model, 'message') ?>
    <?= $form->end() ?>
