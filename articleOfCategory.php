<!-- Include Head -->
<?php include "assest/head.php"; ?>
<?php

$catID = "";

// Get All Categories
$stmt = $conn->prepare("SELECT * FROM `category` ");
$stmt->execute();
$categories = $stmt->fetchAll();

if (isset($_GET["catID"])) {

    $catID = $_GET["catID"];

    // Get Category Info
    $stmt = $conn->prepare("SELECT * FROM `category` WHERE category_id = ?");
    $stmt->execute([$catID]);
    $category = $stmt->fetch();

    // Get Latest articles
    $stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN category ON id_categorie=category_id WHERE id_categorie = ?  ORDER BY `article_created_time` DESC ");
    $stmt->execute([$catID]);
    $articles = $stmt->fetchAll();
} else {

    $stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN category ON id_categorie=category_id ORDER BY `article_created_time` DESC ");
    $stmt->execute();
    $articles = $stmt->fetchAll();
}


?>

<!-- Custom CSS -->
<!-- <link href="css/home.css" rel="stylesheet"> -->
<link href="css/style.css" type="text/css" rel="stylesheet" />

<title>Articles</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php include "assest/header.php" ?>
    <!-- </Header> -->

    <!-- Main -->
    <main class="main">

        <!-- Latest Articles -->
        <div class="section jumbotron mb-0 h-100">
            <!-- container -->
            <div class="container">

                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><?= $catID == "" ? "" : $category['category_name'] ?> Articles</h2>

                            <ul class="list-inline mt-1 mb-4">
                                <li class="list-inline-item">
                                    <a href="articleOfCategory.php" class="text-muted">
                                        All
                                    </a>
                                </li>

                                <?php foreach ($categories as $category) : ?>
                                    <li class="list-inline-item">
                                        <a href="articleOfCategory.php?catID=<?= $category['category_id'] ?>" class="text-muted">
                                            <?= $category['category_name'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <?php foreach ($articles as $article) : ?>
                        <!-- post -->
                        <div class="col-md-4">
                            <div class="post">
                                <a class="post-img" href="single_article.php?id=<?= $article['article_id'] ?>">
                                    <img src="img/article/<?= $article['article_image'] ?>" alt="">
                                </a>
                                <di class="post-body">

                                    <div class="post-meta">
                                        <a class="post-category cat-1" href="articleOfCategory.php?catID=<?= $article['category_id'] ?>" style="background-color:<?= $article['category_color'] ?>"><?= $article['category_name'] ?></a>
                                        <span class="post-date">
                                            <?= date_format(date_create($article['article_created_time']), "F d, Y ") ?>
                                        </span>
                                    </div>

                                    <h3 class="post-title"><a href="single_article.php?id=<?= $article['article_id'] ?>"><?= $article['article_title'] ?></a></h3>

                                </di>
                            </div>
                        </div>
                        <!-- /post -->

                    <?php endforeach;  ?>

                    <div class="clearfix visible-md visible-lg"></div>
                </div>
                <!-- /row -->

            </div>
            <!-- /container -->
        </div>


    </main><!-- </Main> -->

    <!-- Footer -->
    <?php include "assest/footer.php" ?>
    <!-- </Footer> -->

</html>