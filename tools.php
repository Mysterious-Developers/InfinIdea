<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->


<!-- TOUCHE PAS NON PLUS A CE FICHIER CE SONT DES FONCTIONS QUI ME SERVENT
DANS LE BACK-END -->


<?php
require_once 'strings.php';
function getDB()
{
    $db = mysqli_connect('localhost', 'root', 'tta55tty4!_AL', 'blog');
    if(!$db)
    {
        die('Erreur de connexion (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    return $db;
}
function getID($pseudo) : int
{
    $db = getDB();
    $query = "SELECT id FROM users WHERE pseudo = '$pseudo'";
    $result = mysqli_query($db, $query);
    // if we have a result, we can return the id
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        mysqli_close($db);
        if(!$row)
        {
            return -1;
        }
        else
        {
            return $row['id'];
        }
    }
    else
    {
        mysqli_close($db);
        return -1;
    }
}
function getPseudo($id) : string
{
    $db = getDB();
    $query = "SELECT pseudo FROM users WHERE id = '$id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($db);
    return $row['pseudo'];
}
function getMail($id) : string
{
    $db = getDB();
    $query = "SELECT email FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($db);
    return $row['email'];
}
function getMailbyUser($user) : string
{
    $db = getDB();
    $query = "SELECT email FROM users WHERE pseudo = '$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($db);
    return $row['email'];
}
function getPassword($id) : string
{
    $db = getDB();
    $query = "SELECT password FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($db);
    return $row['password'];
}
function getPasswordbyUser($user) : string
{
    $db = getDB();
    $query = "SELECT password FROM users WHERE pseudo = '$user'";
    $result = mysqli_query($db, $query);
    // if we get result, we return the password
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        mysqli_close($db);
        return $row['password'];
    }
    else // else we return an empty string
    {
        mysqli_close($db);
        return '';
    }
}
function register($pseudo, $firstname, $email, $password, $age, $avatar, mysqli $db) : string
{
    $query = "SELECT pseudo FROM users WHERE pseudo = '$pseudo'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0)
    {
        return '<p style="color:red">Le pseudo " . $pseudo . " est déjà utilisé</p>';
    }
    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0)
    {
        return '<p style="color:red">L\'email " . $email . " est déjà utilisée</p>';
    }
    $password = hash('sha512', $password);
    $query = "INSERT INTO users (pseudo, prenom, email, age, password, avatar) VALUES ('$pseudo', '$firstname', '$email', '$age', '$password', '$avatar')";
    $result = mysqli_query($db, $query);
    if($result)
    {
        return '<p style="color:green">Inscription réussie</p>';
    }
    else
    {
        return '<p style="color:red">Inscription échouée</p>';
    }
}
function createAuthToken($id, mysqli $db) : string
{
    // on créé un token aléatoire de 64 caractères
    $token = bin2hex(random_bytes(64));
    // on définit la date d'expiration du token
    $expiration = time() + 15*24*3600; // 15 jours
    $query = "INSERT INTO tokens (type, token, user, expiration) VALUES ('auth', '$token', " . $id . ", '$expiration');";
    echo $query;
    $result = mysqli_query($db, $query);
    if($result)
    {
        mysqli_close($db);
        logs('token', 'create auth token', $id);

        return $token;
    }
    else
    {
        mysqli_close($db);
        return 'NONE';
    }

}
function createPassForgotToken($id, mysqli $db) : string
{
    // on créé un token aléatoire de 26 caractères
    $token = bin2hex(random_bytes(26));
    // on définit la date d'expiration du token
    $expiration = time() + 24*3600; // 1 jours
    $query = "INSERT INTO tokens (type, token, user, expiration) VALUES ('pass', '$token', " . $id . ", '$expiration');";
    $result = mysqli_query($db, $query);
    if($result)
    {
        logs('token', 'create pass forgot token', $id, $db);
        return $token;
    }
    else
    {
        logs('token', 'error creating pass forgot token', $id, $db);
        return 'NONE';
    }

}
function verifyPasswordStrongness(string $password)
{
    $ok = true;
    $error = '';

    if(strlen($password) < 8)
    {
        $ok = false;
        $error .= 'Password is too short<br/>';
    }
    if(!preg_match('#[0-9]+#', $password))
    {
        $ok = false;
        $error = 'Password must include at least one number<br/>';
    }
    if(!preg_match('#[a-zA-Z]+#', $password))
    {
        $ok = false;
        $error = 'Password must include at least one letter<br/>';
    }
    return array($ok, $error);

}
function getIP() : string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function updateUserIP($user, mysqli $db) : void
{
    $ip = getIP();
    $query = "UPDATE users SET ip = '$ip' WHERE id = '$user'";
    mysqli_query($db, $query);
    logs('ip', 'updated ip for user ' . $user, $user, $db);
    $db->close();
}
function logs($action, $details = '', $user = 0, mysqli $db) : void
{
    $ip = getIP();
    $query = 'INSERT INTO logs (action, details, user, ip) VALUES ("' . $action . '", "' . $details . '", ' . $user . ', "' . $ip . '")';
    echo $query;
    mysqli_query($db, $query);
}