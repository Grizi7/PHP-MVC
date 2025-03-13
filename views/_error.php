<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="text-center">
                <h1 class="text-danger font-weight-bold">Forbidden</h1>
                <h2 class="text-dark">
                    <?php echo htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <h3 class="text-muted">Error Code: <?php echo $exception->getCode(); ?></h3>
                <a href="/" class="btn btn-danger mt-3">Go Back Home</a>
            </div>
        </div>
    </div>
</div>