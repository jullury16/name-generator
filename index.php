<?php
$error["status"] = false;
if (isset($_POST['number']) and isset($_POST['locale']) and (int)$_POST['number']>0) {
    require_once 'vendor/autoload.php';
    $faker = Faker\Factory::create($_POST['locale']);
    $names = [];
    $names['names'] = [];
    if ($_POST['number'] > 0) {
        for ($i = 0; $i < $_POST['number']; $i++) {
            $names['names'][] = $faker->firstName;
        }
        $file = $out = fopen('firstname.csv', 'w');
        foreach ($names as $name) {
            fputcsv($file, $name);
        }
        $attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/firstname.csv";
        if (file_exists($attachment_location)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: application/text/x-csv");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:" . filesize($attachment_location));
            header("Content-Disposition: attachment; filename=" . strtotime(date('m/d/Y H:i:s')) . "_" . $_POST['locale'] . ".csv");
            readfile($attachment_location);
            fclose($file);
            die();
        } else {
            $error["status"] = true;
            $error["message"] = "Error while downloading file";
        }
    }
}elseif(!isset($_POST['number']) || $_POST['number']<=0){
    $error["status"] = true;
    $error["message"] = "Vous devez mentionner un nombre supérieur à 0";
}elseif(!isset($_POST['locale'])){
    $error["status"] = true;
    $error["message"] = "Vous devez spécifier le local à utiliser";
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Générateur de prénom</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" href="favicon.ico">
    </head>
    <body>
    <div class="container">
        <h1>Générateur de prénom</h1>
        <form name="form" method="post">
            <?php if($error['status']){ ?>
            <div class="alert alert-danger"><?php echo $error['message'] ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="locale">Locale</label>
                <select name="locale" id="locale">
                    <option value="de_DE">Allemagne</option>
                    <option value="pt_BR">Brésil</option>
                    <option value="en_AU ">Australie</option>
                    <option value="en_CA">Canada</option>
                    <option value="zh_CN">Chine</option>
                    <option value="es_ES">Espagne</option>
                    <option value="en_US">Etats Unis</option>
                    <option value="fr_FR">Français</option>
                    <option value="en_GB">Grande Bretagne</option>
                    <option value="hi_IN">Hindi</option>
                    <option value="en_IN ">Inde</option>
                    <option value="it_IT">Italie</option>
                    <option value="ja_JP">Japon</option>
                    <option value="es_MX">Méxique</option>
                    <option value="en_NZ">Nouvelle Zélande</option>
                    <option value="pt_PT">Portugal</option>
                </select>
            </div>
            <div class="form-group">
                <label for="number">Nombre</label>
                <input type="number" name="number" id="number">
            </div>
            <div class="form-group">
                <input type="submit" value="Génerer" class="btn btn-primary">
            </div>
        </form>
        <div id="footer">
            <p><i class="fa fa-copyright"></i> Jullury - 2020</p>
        </div>
    </div>
    <style>
        form {
            width: 400px;
            margin: 32px auto auto;
        }

        h1 {
            text-align: center;
        }

        label {
            width: 100px;
            padding-top: 8px;
        }

        select, input:not([type="submit"]) {
            flex-grow: 1;
            width: 240px;
            padding: 8px;
        }

        .form-group {
            display: flex;
        }

        input[type="submit"] {
            margin: auto;
        }

        .container {
            margin-top: 32px;
        }

        div#footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding-right: 5%;
        }

        div#footer p {
            text-align: right;
        }
    </style>
    </body>
    </html>
<?php



