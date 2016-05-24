<?php

function connect_db() {
    global $c;
    $host = "localhost";
    $user = "root";
    $pass = "Password";
    $db = "test";
    $c = mysqli_connect($host, $user, $pass, $db);
    mysqli_query($c, "SET CHARACTER SET UTF8");
}

function asjad2($nimetus, $text, $pilt, $omanik) {
    include_once('views/asjad.php');
    global $c;
    $query = 'SELECT id, nimetus, text, pilt, omanik FROM rent ORDER BY nimetus ASC (?, ?, ?, ?)';
    $stmt = mysqli_prepare($l, $query);
    if (mysqli_error($l)) {
        echo mysqli_error($l);
        exit;
    }
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function asjad() {
    include_once('views/asjad.php');
    global $c;
//    $max = 5;
//    $start = ($page - 1) * $max;
    connect_db();
    $query = 'SELECT id, nimetus, pilt, text FROM rent ORDER BY nimetus ASC';
//    $query = 'SELECT id, nimetus, pilt, text FROM rent ORDER BY nimetus ASC ?,?';
    $stmt = mysqli_prepare($c, $query);
    if (mysqli_error($c)) {
        echo mysqli_error($c);
        exit;
    }
//    mysqli_stmt_bind_param($stmt, 'ii', $start, $max);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nimetus, $pilt, $text);
    $rows = array();
    while (mysqli_stmt_fetch($stmt)) {
        $rows[] = array(
            'id' => $id,
            'nimetus' => $nimetus,
            'pilt' => $pilt,
            'text' => $text,
            
        );
    }
    mysqli_stmt_close($stmt);
    return $rows;
    
}

function logi() {
    // siia on vaja funktsionaalsust (13. nädalal)
    global $c;
    if (!empty($_SESSION["user"])) {
        header("Location: ?page=loomad");
    } else {
        $errors = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST["user"] != "" && $_POST["pass"] != "") {
                $u = mysqli_real_escape_string($c, $_POST["user"]);
                $p = mysqli_real_escape_string($c, $_POST["pass"]);
                $sql = "SELECT id, roll from ttilk__kylastajad WHERE username = '$u' AND passw = SHA1('$p')";
                $result = mysqli_query($c, $sql);
                if (mysqli_num_rows($result)) {
                    $_SESSION["user"] = $_POST["user"];
                    $_SESSION["roll"] = mysqli_fetch_assoc($result)["roll"];
                    header("Location: ?page=loomad");
                } else {
                    $errors[] = "Vale kasutajanimi või parool!";
                }
            } else {
                $errors[] = "Kasutajanimi või parool on täitmata!";
            }
        }
    }

    include_once('views/login.html');
}

function logout() {
    $_SESSION = array();
    session_destroy();
    header("Location: ?");
}



function muuda() {
    // siia on vaja funktsionaalsust (13. nädalal)
    global $c;
    if (empty($_SESSION["user"])) {
        header("Location: ?page=login");
    } elseif ($_SESSION["roll"] != "admin") {
        header("Location: ?page=loomad");
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST["nimi"] == "" || $_POST["puur"] == "") {
                $errors[] = "Nimi või puur on täitmata!";
            } elseif ($_POST['id'] == "") {
                header("Location: ?page=loomad");
            } else {
                $id = mysqli_real_escape_string($c, $_POST["id"]);
                $loom = hangi_loom($id);
                $nimi = mysqli_real_escape_string($c, $_POST["nimi"]);
                $puur = mysqli_real_escape_string($c, $_POST["puur"]);
                if (upload("liik")) {
                    $liik = mysqli_real_escape_string($c, upload("liik"));
                } else {
                    $liik = $loom['liik'];
                }
                $sql = "UPDATE ttilk__loomaaed SET nimi = '$nimi', puur = '$puur', liik = '$liik' WHERE id = '$id'";
                $result = mysqli_query($c, $sql);
                header("Location: ?page=loomad");
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = mysqli_real_escape_string($c, $_GET["id"]);
            if ($id == "") {
                header("Location: ?page=loomad");
            } else {
                $loom = hangi_loom($id);
            }
        }
    }

    include_once('views/editvorm.html');
}

function lisa() {
    // siia on vaja funktsionaalsust (13. nädalal)
    global $c;
    if ($_SESSION["roll"] == "admin") {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            connect_db();
            $nimi = mysqli_real_escape_string($c, $_POST["nimetus"]);
            $text = mysqli_real_escape_string($c, $_POST["text"]);
            $pilt = mysqli_real_escape_string($c, upload("pilt"));
            $omanik = mysqli_real_escape_string($c, $_POST["omanik"]);
            $query = "INSERT INTO rent(nimetus, pilt, text, omanik) VALUES ('$nimi', '$pilt', '$text', $omanik)";
            $stmt = mysqli_prepare($c, $query);
            if (mysqli_error($c)) {
                echo mysqli_error($c);
                exit;
            }
            $id = mysqli_stmt_insert_id($stmt);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $id;
            echo "nimi: " . $nimi . "<br/> text: " . $text . "<br/> text: " . $pilt . "<br/> omanik: " . $omanik. "<br/> ID: " . $id;
            header("refresh:10; url=?page=asjad");
        } else {
            include_once('views/lisa.php');
        }
    } else {
        header("Location: ?page=login");
    }
}

function lisa_originaal() {
    // siia on vaja funktsionaalsust (13. nädalal)
    global $c;
    if (empty($_SESSION["user"])) {
        echo '1';
        header("Location: ?page=login");
    } elseif ($_SESSION["roll"] != "admin") {
        echo '2';
        header("Location: ?page=asjad");
    } else {
        echo '3';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '4';
            if ($_POST["nimi"] == "" || $_POST["text"] == "") {
                echo '5';
                $errors[] = "olete osa infot jätnud sisestamata!";
            } elseif ($_FILES["pilt"]["error"] > 0) {
                echo '6';
                $errors[] = "Faili saatmine ebaõnnestus";
            } else {
                echo '7';
                connect_db();
                $nimi = mysqli_real_escape_string($c, $_POST["nimi"]);
                $text = mysqli_real_escape_string($c, $_POST["text"]);
                $pilt = mysqli_real_escape_string($c, upload("pilt"));
                $sql = "INSERT INTO rent(nimi, text, pilt) VALUES ('$nimi', '$text', pildid/'$pilt')";
                $result = mysqli_query($c, $sql);
                if (mysqli_insert_id($c)) {
                    echo '8';
                    header("Location: ?page=asjad");
                } else {
                    echo '9';
                    header("Location: ?page=lisa");
                }
            }
        }
    }

    include_once('views/lisa.php');
}

function upload($name) {
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    $allowedTypes = array("image/gif", "image/jpeg", "image/png", "image/pjpeg");
    $ss = explode(".", $_FILES[$name]["name"]); //[$name] - array ehk siis 
    $extension = end($ss);

    if (in_array($_FILES[$name]["type"], $allowedTypes) && ($_FILES[$name]["size"] < 100000) && in_array($extension, $allowedExts)) {

        if ($_FILES[$name]["error"] > 0) {
            $_SESSION['notices'][] = "Return Code: " . $_FILES[$name]["error"];
            return "";
        } else {

            if (file_exists("pildid/" . $_FILES[$name]["name"])) {

                $_SESSION['notices'][] = $_FILES[$name]["name"] . " juba eksisteerib. ";
                return "pildid/" . $_FILES[$name]["name"];
            } else {
                move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
                return "pildid/" . $_FILES[$name]["name"];
            }
        }
    } else {
        return "";
    }
}

?>