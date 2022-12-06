<header class="blog-header border-bottom shadow-sm bg-white">
    <div class="container-fluid" style="padding-left: 7rem; padding-right:7rem">

        <div class="d-flex flex-column flex-md-row align-items-center py-2">
            <a href="index.php" class="my-0 mr-md-auto" style="width: 7rem;">
                <img src="img/logo/logo1.png" alt="logo" style="width: 100%;height: auto;">
            </a>

            <?php if ($loggedin) : ?>

                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 px-5 text-muted" href="index.php">Home</a>
                    <a class="p-2 px-5 text-muted" href="categories.php">Category</a>
                    <a class="p-2 px-5 text-muted" href="article.php">Article</a>
                    <a class="p-2 px-5 text-muted" ><i class="fa fa-fw fa-user"></i><?php echo $_SESSION["username"] ?></a>
                </nav>

            <?php else : ?>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 px-5 text-muted" href="articleOfCategory.php">Articles</a>
                </nav>

            <?php endif;  ?>

            <a class="btn btn-outline-success" href="<?= ($loggedin) ? 'Logout.php' : 'login.php'; ?>">
                <?= ($loggedin) ? 'Logout' : 'Sign in'; ?>
            </a>

        </div>
    </div>
</header>