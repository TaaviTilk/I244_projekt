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

function pealeht() {
    global $c;
    include_once('views/pealeht.php');

    //    $max = 5;
//    $start = ($page - 1) * $max;
//    $query = 'SELECT id, nimetus, pilt, text FROM rent ORDER BY nimetus ASC' ;
    $query = 'SELECT nimetus, text, pilt  FROM rent ORDER BY nimetus ASC';

    $stmt = mysqli_prepare($c, $query);
    if (mysqli_error($c)) {
        echo mysqli_error($c);
        exit;
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nimetus, $text, $pilt);
    $rp = array();
    while (mysqli_stmt_fetch($stmt)) {
        $rp[] = array(
            'nimetus' => $nimetus,
            'text' => $text,
            'pilt' => $pilt,
        );
    }
    //print_r($rows);
    mysqli_stmt_close($stmt);
    return $rp;
}

function asjad() {
    include_once('views/asjad.php');
    global $c;

    if (!empty($_SESSION["user"])) {


        $kasutaja = $_SESSION["user"];

//    $max = 5;
//    $start = ($page - 1) * $max;
        
//    $query = 'SELECT id, nimetus, pilt, text FROM rent ORDER BY nimetus ASC' ;
        $query = 'SELECT id, nimetus, text, pilt, omanik  FROM rent WHERE omanik = ?';

        $stmt = mysqli_prepare($c, $query);
        if (mysqli_error($c)) {
            echo mysqli_error($c);
            exit;
        }
        mysqli_stmt_bind_param($stmt, 's', $kasutaja);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $nimetus, $text, $pilt, $omanik);
        $rows = array();
        while (mysqli_stmt_fetch($stmt)) {
            $rows[] = array(
                'id' => $id,
                'nimetus' => $nimetus,
                'text' => $text,
                'pilt' => $pilt,
                'omanik' => $omanik,
            );
        }
        //print_r($rows);
        mysqli_stmt_close($stmt);
        return $rows;
    } else {
        header("Location: ?");
    }
}

function rendi() {
    include_once('views/rendi.php');
    global $c;

    if (!empty($_SESSION["user"])) {
        $kasutaja = $_SESSION["user"];

//    $max = 5;
//    $start = ($page - 1) * $max;
       
//    $query = 'SELECT id, nimetus, pilt, text FROM rent ORDER BY nimetus ASC' ;
        $query = 'SELECT id, nimetus, text, pilt, omanik, aeg, rentnik  FROM rent ORDER BY nimetus ASC';

        $stmt = mysqli_prepare($c, $query);
        if (mysqli_error($c)) {
            echo mysqli_error($c);
            exit;
        }
        //mysqli_stmt_bind_param($stmt, 's', $kasutaja);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $nimetus, $text, $pilt, $omanik, $aeg, $rentnik);
        $rows = array();
        while (mysqli_stmt_fetch($stmt)) {
            $rows[] = array(
                'id' => $id,
                'nimetus' => $nimetus,
                'text' => $text,
                'pilt' => $pilt,
                'omanik' => $omanik,
                'aeg' => $aeg,
                'rentnik' => $rentnik,
            );
        }
        //print_r($rows);
        mysqli_stmt_close($stmt);
        return $rows;
    } else {
        header("Location: ?");
    }
}

function rendi_valja() {
    global $c;
    if (!empty($_SESSION["user"])|| $_POST['id']<0) {

        $rentnik = $_SESSION["user"];
        $aeg = date("Y-m-d H:i:s");
        $id = $_POST['id'];

        $query = 'UPDATE rent SET aeg = ?, rentnik = ? WHERE id = ? LIMIT 1';
        $stmt = mysqli_prepare($c, $query);
        if (mysqli_error($c)) {
            echo mysqli_error($c);
            exit;
        }
        mysqli_stmt_bind_param($stmt, 'ssi', $aeg, $rentnik, $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            return false;
        }

        mysqli_stmt_close($stmt);

        header("Location: ?page=rendi");
    } else {
        header("Location: ?");
    }
}

function kustuta() {
    global $c;

    if (($_SESSION["roll"] == "admin" || !empty($_SESSION["user"]))) {
        $id = $_POST['id'];

        $query = 'DELETE FROM rent WHERE id = ? LIMIT 1';
        $stmt = mysqli_prepare($c, $query);
        if (mysqli_error($c)) {
            echo mysqli_error($c);
            exit;
        }
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            return false;
        }

        mysqli_stmt_close($stmt);

        header("Location: ?page=asjad");
    } else {
        header("Location: ?");
    }
}

function lisa() {

    global $c;
    if ($_SESSION["roll"] == "admin") {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $nimi = mysqli_real_escape_string($c, $_POST["nimetus"]);
            $text = mysqli_real_escape_string($c, $_POST["text"]);
            $pilt = mysqli_real_escape_string($c, upload("pilt"));
            $omanik = mysqli_real_escape_string($c, $_POST["omanik"]);
            if($nimi!=""||$pilt !=""){
            $query = "INSERT INTO rent(nimetus, text, pilt, omanik) VALUES ('$nimi', '$text', '$pilt', '$omanik')";
            $stmt = mysqli_prepare($c, $query);
            if (mysqli_error($c)) {
                echo mysqli_error($c);
                exit;
            }
            $id = mysqli_stmt_insert_id($stmt);
            //echo "nimi: " . $nimi . "<br/> text: " . $text . "<br/> text: " . $pilt . "<br/> omanik: " . $omanik;

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return $id;

            header("refresh:2; url=?page=asjad");
            }else{
                echo 'Jätsite ühe kohustuslikest väljadest <b>nimi</b> ja <b>pilt</b> sisestamata';
                header("refresh:5; url=?page=lisa");
            }
        } else {
            include_once('views/lisa.php');
        }
    } else {
        header("Location: ?page=login");
    }
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

function logi() {
    global $c;
    if (!empty($_SESSION["user"])) {
        header("Location: ?");
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
                    header("Location: ?page=rendi");
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

?>