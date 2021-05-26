<?php


/**
 * Génère une alerte Bootstrap
 * @param string $var variable à chercher dans la QueryString
 * @param string $val valeur de la variable recherchée
 * @param string $type type d'alerte (danger, warning ou success)
 * @param string $msg message d'alerte
 * @return string alerte Bootstrap au format HTML
 */

function display_alert(string $var, string $val, string $type, string $msg): string
{
    if (isset($_GET[$var]) && !empty($_GET[$var])) {
        if ($_GET[$var] === $val) {
            return
                '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">' . $msg . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>';
        }
    }
    return '';
}

/**
 * Génère un mot de passe aléatoire de taille 8 par défaut
 * à partir des caractères suivants :
 * A à Z
 * a à z
 * 0 à 9
 * + * - / $ #
 * @param int $len taille du mot de passe (par défaut 8)
 * @return string mot de passe aléatoire généré
 * @author Lesly
 * @version 1.0
 */

function generate_password(int $len = 8): string
{
    $dict = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+*-/$#';
    $pass = str_shuffle($dict);
    $pass = substr($pass, 0, $len);
    return $pass;
}


/**
 * Génère un mot de passe aléatoire de taille 8 par défaut
 * à partir des caractères suivants :
 * A à Z
 * a à z
 * 0 à 9
 * + * - / $ #
 * @param int $len taille du mot de passe (par défaut 8)
 * @return string mot de passe aléatoire généré
 * @author Lesly
 * @version 2.0
 */

function generate_password2($len = 8): string
{
    // Dictionnaire
    $tab1 = range('A', 'Z');
    $tab2 = range('a', 'z');
    $tab3 = range(0, 9);
    $tab4 = array('+', '*', '-', '/', '$', '#');
    $dict = array_merge($tab1, $tab2, $tab3, $tab4);
    shuffle($dict);

    // Si erreur
    if ($len < 8 || $len > count($dict)) {
        trigger_error(sprintf('La taille doit être comprise entre %d et %d caractères', $len, count($dict)), E_USER_WARNING);
    }

    // Renvoi mot de passe
    $pass = '';
    for ($i = 0; $i < $len; $i++) {
        $pass .= $dict[rand(0, count($dict) - 1)];
    }
    return $pass;
}
?>