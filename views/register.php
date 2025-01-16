
    <h2>Register</h2>
    <form action="/register" method="post">
        <div class="row">
            <div class="form-group col">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required value="<?= $model->first_name ?? '' ?>">
            </div>
            <div class="form-group col">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required value="<?= $model->last_name ?? '' ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?= $model->email ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Register</button>
    </form>
