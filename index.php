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

        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 20vw; height: 90vh">
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
                    foreach($json as $key => $value) {
                    ?>
                        <li class="nav-item mb-3 d-flex align-items-center justify-content-start">
                            <img src="dependencies/house.svg" class="me-2" width="20" height="20" />
                            <span><?php echo($value->{"titre_court"}) ?></span>
                        </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>