<?php

/**
 * INSTALLATION DE SENDMAIL : WINDOWS
 * Télécharger Sendmail à partir du site officiel : 
 * https://www.glob.com.au/sendmail/sendmail.zip
 * Extraire son contenu dans un dossier (Exemple : c:\wamp64\www\projet fin formation\sendmail)
 * Ouvrir sendmail.ini et définir les variables suivantes :
 * - smtp_server=smtp.gmail.com
 * - smtp_port=25
 * - auth_username=ricardomagalhaessousa58@gmail.com
 * - auth_password=eskorbuto00
 * Fermer en sauvegardant
 * 
 * CONFIGURATION PHP : WINDOWS
 * Ouvrir php.ini et commenter les variables suivantes :
 * - ;SMTP = localhost
 * - ;smtp_port = 25
 * - ;auth_username =
 * - ;auth_password =
 * - ;sendmail_from = me@example.com -> Windows seulement
 * Puis définir la variable suivante :
 * - sendmail_path="c:\wamp64\www\projet fin formation\sendmail"
 * Fermer en sauvegardant
 * Redémarrer le serveur Apache
 * 
 * CONFIGURATION GMAIL
 * Cliquer sur le lien suivant pour autoriser les apps moins sécurisées : 
 * https://www.google.com/settings/security/lesssecureapps
 */

// Variables d'envoi du mail : to, cc, subject, body...
$to = 'paulo_magalhaes@outlook.fr, ricardomagalhaessousa58@gmail.com';
$subject = 'Test envoi de mail via PHP';
$body = ' <h1>Test envoi de mail</h1>
 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam animi tempore corrupti placeat sunt fugit, incidunt facilis nemo deleniti architecto saepe, sint est unde, excepturi eveniet quae doloremque culpa aut?</p>
 <a href="http://localhost/herblay/CP7/">Retour à l\'accueil</a>';

// Variables d'en-tête : AR, CC, BCC, Importance, etc.
$header = "MIME-Version: 1.0 \r\n";
$header .= "Content-Type: text/html;charset=utf8 \r\n";
$header .= "From: noreply@greta.fr \r\n";
$header .= "Cc: apollo@creed.us, adonis@creed.us \r\n";
$header .= "Bcc: rocky@balboa.us \r\n";

// Envoi du mail
$result = mail($to, $subject, $body, $header);
echo ($result ? 'Message bien envoyé' : 'Echec dans l\'envoi du message');
