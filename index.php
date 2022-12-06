<!-- Include Head -->
<?php include "assest/head.php"; ?>
<?php

// Get Latest articles
$stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN category ON id_categorie=category_id ORDER BY `article_created_time` DESC  LIMIT 6");
$stmt->execute();
$articles = $stmt->fetchAll();

// Get Categories
$stmt = $conn->prepare("SELECT *,COUNT(*) as article_count FROM `article` INNER JOIN category ON id_categorie=category_id GROUP BY id_categorie");
$stmt->execute();
$categories = $stmt->fetchAll();

// Get Most Read Articles
$stmt = $conn->prepare("SELECT * FROM `article` INNER JOIN category ON id_categorie=category_id order by RAND() LIMIT 3");
$stmt->execute();
$most_read_articles = $stmt->fetchAll();

?>

<!-- Google font -->
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">

<!-- Custom CSS -->
<!-- <link href="css/home.css" rel="stylesheet"> -->
<link type="text/css" rel="stylesheet" href="css/style.css" />
<style>
    .alert {
    	background-color: #f1b0b7;
    	color: #bd2130;
		text-align: center;
		width: 500px;
		margin-left: 420px;
		border-radius: 10px;
		padding: 20px;		
    	}
        .succ {
    	background-color: #90EE90;
    	color: #008000;
		text-align: center;
		width: 500px;
		margin-left: 420px;
		border-radius: 10px;
		padding: 20px;		
    	}
    .bg-div {
        background: linear-gradient(rgba(0, 0, 0, 0.75),
                rgba(0, 0, 0, 0.5)), url("./img/slider/1.jpg");
         /*Full height */
        
        height: 680px;
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<title>Home</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php  
    if (isset($_SESSION['message'])){
        echo "<div class='alert' role='alert'>";
        echo $_SESSION['message'];
        echo "</div>"; header("refresh: 1.5");
    }
    

    unset($_SESSION['message']);
    

    if (isset($_SESSION['message1'])){
        echo "<div class='succ' role='alert'>";
        echo $_SESSION['message1'];
        echo "</div>"; header("refresh: 1.5");
    }
    unset($_SESSION['message1']);
    include "assest/header.php";
    ?>
    <!-- </Header> -->

    <!-- Main -->
    <main class="main">
    
        <!-- Jumbotron -->
        <div class="jumbotron text-center p-0 mb-0">
            <div class="bg-div px-5 d-flex align-items-center">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

            <div class="text-left w-50">
                    <h1 class="display-4 text-white">Welcome to Our Blog!</h1>
                    <h2 class="display-5 text-white">Discover the news of articles that you can read completely for free!</h2>

                </div>


            </div>
        </div><!-- /Jumbotron -->

        <!-- Latest Articles -->
        <div class="section section-grey">

            <!-- container -->
            <div class="container">

                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2>Latest Articles</h2>
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
</div><!-- /Latest Articles -->

<!-- Most Read -->
<div class="section section-grey">
<!-- container -->
<div class="container">
<!-- row -->
<div class="row">
<div class="col-md-8">
<div class="row">
    <div class="col-md-12">
        <div class="section-title">
            <h2>Most Read</h2>
        </div>
    </div>

    <?php foreach ($most_read_articles as $article) : ?>

        <!-- post -->
        <div class="col-md-12">
            <div class="post post-row">
                <a class="post-img" href="single_article.php?id=<?= $article['article_id'] ?>">
                    <img src="img/article/<?= $article['article_image'] ?>" alt="">
                </a>
                <div class="post-body">
                    <div class="post-meta">
                        <a href="articleOfCategory.php?catID=<?= $article['category_id'] ?>" class="post-category" style="background-color:<?= $article['category_color'] ?>">
                            <?= $article['category_name'] ?>
                        </a>
                        <span class="post-date">
                            <?= date_format(date_create($article['article_created_time']), "F d, Y ") ?>
                        </span>
                    </div>

                    <h3 class="post-title"><a href="single_article.php?id=<?= $article['article_id'] ?>"><?= $article['article_title'] ?></a></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...</p>
                </div>
            </div>
        </div>
        <!-- /post -->

    <?php endforeach;  ?>

    
</div>
</div>

<div class="col-md-4">

<!-- catagories -->
<div class="aside-widget">
    <div class="section-title">
        <h2>Categories</h2>
    </div>
    <div class="category-widget">

        <ul>
            <!-- /category -->
            <?php foreach ($categories as $category) : ?>
                <li>
                    <a href="articleOfCategory.php?catID=<?= $category['category_id'] ?>"> <?= $category["category_name"] ?>
                        <span style="background-color: <?= $category["category_color"] ?>"> <?= $category["article_count"] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
            <!-- /category -->
        </ul>
    </div>
</div>

<!-- /tags -->
</div>
</div>
<!-- /row -->
</div>
<!-- /container -->
</div><!-- /Most Read -->

</main><!-- </Main> -->

<!-- Footer -->
<?php include "assest/footer.php" ?>
<!-- </Footer> -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>