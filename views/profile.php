<?php
    $this->title = 'Profile';
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/100" alt="User Avatar" class="rounded-circle border">
                    </div>
                    <h2 class="text-dark"><?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p class="text-muted"><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></p>

                    <div class="mt-3">
                        <p><strong>Status:</strong>
                            <?php echo $user->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                        </p>
                        <p><strong>Joined:</strong> <?php echo htmlspecialchars($user->created_at, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($user->updated_at, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>

                    <a href="/edit-profile.php" class="btn btn-primary mt-3">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>