<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="dependencies/bootstrap.min.css" rel="stylesheet">
    <link href="dependencies/logo.png" rel="icon">
    <title>Appartements</title>
</head>
<body>
    <div style="min-width: 100vw; min-height: 100vh; max-width: 100vw">
        <div class="container" style="height: 10vh; width : 100vw">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <img width="40" height="40" src="dependencies/logo.png" class="me-3"/>
                    <span class="fs-4">Appartements</span>
                </a>

                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Accueil</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Administration</a></li>
                </ul>
            </header>
        </div>

        <div class="row" style="width: 100vw;">
            <div class="col-3">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="min-height: 90vh; height : 100%">
                    <a href="index.php" class="d-flex align-items-center m-0 link-dark text-decoration-none justify-content-center flex-wrap">
                        <span class="fs-4">Liste des appartements</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto ">
                        <?php
                        if (file_exists("configuration.json")) {
                            $json = json_decode(file_get_contents("configuration.json"));
                        } else {
                            $json = false;
                        }
                        if ($json === false) {
                            ?>
                            <li class="nav-item">
                                <span class="nav-link" aria-current="page">
                                    Aucun appartement disponible
                                </span>
                            </li>
                            <?php
                        }
                        else {
                            foreach($json->{"appartement"} as $key => $value) {
                                ?>
                                <li class="nav-item d-flex align-items-center justify-content-start">
                                    <a href="index.php?id=<?php echo($key); ?>&image=0" class="nav-link <?php
                                    if(isset($_GET["id"]) && $_GET["id"] == $key) {
                                        echo("active");
                                    }
                                    ?>" style="width:100%">
                                    <img src="dependencies/house.svg" class="me-2" width="20" height="20" />
                                    <span><?php echo($value->{"titre_court"}) ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <?php if(isset($_GET["id"])) {
                    ?>
                    <h1 class="text-center"><?php echo($json->{"appartement"}->{$_GET["id"]}->{"titre_long"});?></h1>
                    <br />
                    <hr style="width: 50%; margin: auto"/>
                    <br />
                    <div id="carouselImages" class="carousel slide" data-ride="carousel" style="max-width: 80%; margin : auto;">
                        <div class="carousel-inner">
                            <?php
                                $count = 0;
                                foreach ($json->{"appartement"}->{$_GET["id"]}->{"images"} as $image) {
                                    ?>
                                    <div class="carousel-item <?php if($count == $_GET["image"]) echo("active") ?>">
                                        <img class="d-block w-100" src="<?php echo($image) ?>" alt="Image">
                                    </div>
                                    <?php
                                    $count++;
                                }
                            ?>
                        </div>
                        <?php
                        $next_image = ($_GET["image"] + 1) % count($json->{"appartement"}->{$_GET["id"]}->{"images"});
                        $previous_image = ($_GET["image"] - 1) == -1 ? count($json->{"appartement"}->{$_GET["id"]}->{"images"}) -1 :
                            ($_GET["image"] - 1) % count($json->{"appartement"}->{$_GET["id"]}->{"images"});
                        $next_url = "index.php?id=" . $_GET["id"] . "&image=" . $next_image;
                        $previous_url = "index.php?id=" . $_GET["id"] . "&image=" . $previous_image;
                        ?>
                        <a class="carousel-control-prev" href="<?php echo($previous_url) ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="<?php echo($next_url) ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <br />
                    <hr style="width: 50%; margin: auto"/>
                    <br />
                    <?php
                        $description = str_replace("\n", "<br />", $json->{"appartement"}->{$_GET["id"]}->{"description"});
                    ?>
                    <ul class="list-group" style="width: 80%; margin: auto">
                        <li class="list-group-item active"><h2>Description</h2></li>
                        <li class="list-group-item"><?php echo($description); ?></li>
                    </ul>
                    <br />
                    <hr style="width: 50%; margin: auto"/>
                    <br />
                    <?php
                        if ($json->{"appartement"}->{$_GET["id"]}->{"status_color"} == "green") {
                            $status_color = "list-group-item-success";
                        } else if ($json->{"appartement"}->{$_GET["id"]}->{"status_color"} == "red") {
                            $status_color = "list-group-item-danger";
                        } else if ($json->{"appartement"}->{$_GET["id"]}->{"status_color"} == "yellow") {
                            $status_color = "list-group-item-warning";
                        } else {
                            $status_color = "list-group-item-light";
                        }
                    ?>
                    <ul class="list-group" style="width: 80%; margin: auto">
                        <li class="list-group-item active">
                            <h2>Status</h2>
                        </li>
                        <li class="list-group-item <?php echo($status_color)?>">
                            <?php echo($json->{"appartement"}->{$_GET["id"]}->{"status_text"}); ?>
                        </li>
                    </ul>
                    <br />
                    <?php
                } else {
                    $general = $json->{"general"};
                    if (isset($_GET["image"])) {
                        $image_number = $_GET["image"];
                    } else {
                        $image_number = 0;
                    }
                    ?>
                    <h1 class="text-center"><?php echo($general->{"titre"});?></h1>
                    <br />
                    <hr style="width: 50%; margin: auto"/>
                    <br />
                    <div id="carouselImages" class="carousel slide" data-ride="carousel" style="max-width: 80%; margin : auto;">
                        <div class="carousel-inner">
                            <?php
                            $count = 0;
                            foreach ($general->{"images"} as $image) {
                                ?>
                                <div class="carousel-item <?php if($count == $image_number) echo("active") ?>">
                                    <img class="d-block w-100" src="<?php echo($image) ?>" alt="Image">
                                </div>
                                <?php
                                $count++;
                            }
                            ?>
                        </div>
                        <?php
                        $next_image = ($image_number + 1) % count($general->{"images"});
                        $previous_image = ($image_number - 1) == -1 ? count($general->{"images"}) -1 :
                            ($image_number - 1) % count($general->{"images"});
                        $next_url = "index.php?image=" . $next_image;
                        $previous_url = "index.php?image=" . $previous_image;
                        ?>
                        <a class="carousel-control-prev" href="<?php echo($previous_url) ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="<?php echo($next_url) ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <br />
                    <hr style="width: 50%; margin: auto"/>
                    <br />
                    <?php
                    $description = str_replace("\n", "<br />", $general->{"description"});
                    ?>
                    <ul class="list-group" style="width: 80%; margin: auto">
                        <li class="list-group-item active"><h2>Description</h2></li>
                        <li class="list-group-item"><?php echo($description); ?></li>
                    </ul>
                    <br />
                    <?php
                }?>
            </div>
        </div>
    </div>
</body>
</html>