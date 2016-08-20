<?php /*
	Copyright 2014-2015 Cédric Levieux, Jérémy Collot, ArmagNet

	This file is part of Fabrilia.

    Fabrilia is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Fabrilia is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Fabrilia.  If not, see <http://www.gnu.org/licenses/>.
*/

$lang["date_format"] = "d/m/Y";
$lang["time_format"] = "H:i";
$lang["fulldate_format"] = "dddd DD/MM/YYYY";
$lang["datetime_format"] = "le {date} à {time}";

$lang["common_validate"] = "Valider";
$lang["common_create"] = "Créer";
$lang["common_delete"] = "Supprimer";
$lang["common_fork"] = "Copier";
$lang["common_reject"] = "Rejeter";
$lang["common_connect"] = "Connecter";
$lang["common_ask_for_modification"] = "Demander modification";
$lang["common_save"] = "Sauvegarder";
$lang["common_yes"] = "Oui";
$lang["common_no"] = "Non";

$lang["language_fr"] = "Français";
$lang["language_en"] = "Anglais";
$lang["language_de"] = "Allemand";

$lang["fabrilia_title"] = "Fabrilia";

$lang["menu_language"] = "Langue : {language}";
$lang["menu_index"] = "Accueil";
$lang["menu_rejoin"] = "Réadhérer";
$lang["menu_mypreferences"] = "Mes préférences";
$lang["menu_logout"] = "Se déconnecter";
$lang["menu_login"] = "Se connecter";
$lang["menu_administration"] = "Administration";

$lang["administration_guide"] = "Gérez ici les informations de gestion de l'application";
$lang["administration_server"] = "Information serveur";
$lang["administration_server_base"] = "Base d'url";
$lang["administration_server_line"] = "Ligne du serveur";
$lang["administration_server_line_dev"] = "Développement";
$lang["administration_server_line_beta"] = "Beta";
$lang["administration_server_line_prod"] = "Production";
$lang["administration_server_timezone"] = "Fuseau horaire";
$lang["administration_server_timezone_none"] = "Aucun";
$lang["administration_server_timezone_europeparis"] = "Europe/Paris";
$lang["administration_database"] = "Information base de données";
$lang["administration_database_host"] = "Hôte BDD";
$lang["administration_database_port"] = "Port BDD";
$lang["administration_database_database"] = "BDD";
$lang["administration_database_login"] = "Login BDD";
$lang["administration_database_password"] = "Password BDD";
$lang["administration_memcached"] = "Information memcached";
$lang["administration_memcached_host"] = "Hôte Memcached";
$lang["administration_memcached_port"] = "Port Memcached";
$lang["administration_mail"] = "Information mail";
$lang["administration_mail_host"] = "Hôte SMTP";
$lang["administration_mail_port"] = "Port SMTP";
$lang["administration_mail_secure"] = "Sécurisation Mail";
$lang["administration_mail_secure_none"] = "Aucune";
$lang["administration_mail_secure_none_alert"] = "Les mails partent en clair et sont interceptables";
$lang["administration_mail_secure_ssl_alert"] = "Les mails partent chiffrés mais semblent interceptables";
$lang["administration_mail_secure_tls_alert"] = "Les mails partent chiffrés, c'est la bonne pratique actuelle";
$lang["administration_mail_username"] = "Username SMTP";
$lang["administration_mail_password"] = "Password SMTP";
$lang["administration_mail_from_address"] = "Adresse From";
$lang["administration_mail_from_name"] = "Nom From";
$lang["administration_account"] = "Identifiant de l'administrateur";
$lang["administration_account_login"] = "Login Administrateur";
$lang["administration_account_password"] = "Password Administrateur";
$lang["administration_ping_database"] = "Tester";
$lang["administration_alert_ok"] = "La configuration a été mise à jour avec succès";
$lang["administration_alert_ping_ok"] = "La configuration base de données est bonne";
$lang["administration_alert_ping_no_host"] = "Hôte inconnu";
$lang["administration_alert_ping_bad_credentials"] = "Mauvais compte";
$lang["administration_alert_ping_no_database"] = "Base de données inexistante";

$lang["login_title"] = "Identifiez vous";
$lang["login_loginInput"] = "Identifiant";
$lang["login_passwordInput"] = "Mot de passe";
$lang["login_button"] = "Me connecter";
$lang["login_rememberMe"] = "Se souvenir de moi";
$lang["register_link"] = "ou m'enregistrer";
$lang["forgotten_link"] = "j'ai oublié mon mot de passe";

$lang["breadcrumb_index"] = "Accueil";
$lang["breadcrumb_mypreferences"] = "Mes préférences";
$lang["breadcrumb_forgotten"] = "J'ai oublié mon mot de passe";
$lang["breadcrumb_about"] = "À Propos";
$lang["breadcrumb_connect"] = "Se connecter";
$lang["breadcrumb_administration"] = "Administration";

$lang["index_guide"] = "Fabrilia est la boîte à outil du Parti Pirate.";
$lang["index_connect_button"] = "Se connecter";
$lang["index_membership"] = "Il vous reste {days} jours avant d'avoir besoin de <a href=\"rejoin.php\">réadhérer</a>. Fin le {date}.";
$lang["index_redmine_no_account"] = "Vous n'avez pas de compte sur l'outil Redmine.";
$lang["index_redmine_not_same_password"] = "Votre mot de passe Redmine est différent de celui utilisé de manière centralisée. Voulez-vous le mettre à jour ? ";

$lang["task_issue"] = "Anomalie";
$lang["task_upgrade"] = "Amélioration";
$lang["task_document"] = "Documentation";
$lang["task_task"] = "Tâche";
$lang["task_assigned_list"] = "Tâches assignées";
$lang["task_not_assigned_list"] = "Tâches à faire";
$lang["task_if_you_please"] = "Vous avez le temps, vous avez les compétences, aidez-nous.";

$lang["sso_galette"] = "Outil de gestion des informations adhérents";
$lang["sso_congressus"] = "Outil de gestion de réunion";
$lang["sso_personae"] = "Outil de délégation liquide";
$lang["sso_redmine"] = "Outil de suivi des demandes et projets du Parti Pirate";
$lang["sso_wiki"] = "Wiki du Parti Pirate";
$lang["sso_forum"] = "Forum du Parti Pirate";
$lang["sso_ml"] = "Mailing Lists du Parti Pirate";

$lang["connect_guide"] = "Bienvenue sur l'écran de connexion de Fabrilia";
$lang["connect_form_legend"] = "Connexion";
$lang["connect_form_loginInput"] = "Identifiant";
$lang["connect_form_loginHelp"] = "Votre identifiant Galette ou votre email";
$lang["connect_form_passwordInput"] = "Mot de passe";
$lang["connect_form_passwordHelp"] = "Votre mot de passe Galette";

$lang["mypreferences_guide"] = "Changer mes préférences.";
$lang["mypreferences_form_legend"] = "Configuration de vos accès";
$lang["mypreferences_form_passwordInput"] = "Nouveau mot de passe";
$lang["mypreferences_form_passwordPlaceholder"] = "votre nouveau mot de passe de connexion";
$lang["mypreferences_form_oldInput"] = "Mot de passe actuel";
$lang["mypreferences_form_oldPlaceholder"] = "votre mot de passe de connexion actuel";
$lang["mypreferences_form_confirmationInput"] = "Confirmation";
$lang["mypreferences_form_confirmationPlaceholder"] = "confirmation de votre nouveau mot de passe";
$lang["mypreferences_form_languageInput"] = "Langage";
$lang["mypreferences_validation_mail_empty"] = "Le champ mail ne peut être vide";
$lang["mypreferences_validation_mail_not_valid"] = "Cette adresse mail n'est pas une adresse valide";
$lang["mypreferences_validation_mail_already_taken"] = "Cette adresse mail est déjà prise";
$lang["mypreferences_form_mailInput"] = "Adresse mail";
$lang["mypreferences_save"] = "Sauver mes préférences";

$lang["forgotten_guide"] = "Vous avez oublié votre mot de passe, bienvenue sur la page qui vour permettra de récuperer un accès";
$lang["forgotten_form_legend"] = "Récupération d'accès";
$lang["forgotten_form_mailInput"] = "Adresse mail";
$lang["forgotten_save"] = "Envoyez moi un mail !";
$lang["forgotten_success_title"] = "Récupération en cours";
$lang["forgotten_success_information"] = "Un mail vous a été envoyé.<br>Ce mail contient un nouveau mot de passe. Veillez à le changer aussitôt que possible.";
$lang["forgotten_mail_subject"] = "[Fabrilia] J'ai oublié mon mot de passe";
$lang["forgotten_mail_content"] = "Bonjour,

Il semblerait que vous ayez oublié votre mot de passe sur Fabrilia. Votre nouveau mot de passe est {password} .
Veuillez le changer aussitôt que vous serez connecté.

L'équipe @Fabrilia";

$lang["error_cant_change_password"] = "Le changement de mot de passe a échoué";
$lang["ok_operation_success"] = "Opération réussie";
$lang["error_passwords_not_equal"] = "Votre mot de passe et sa confirmation sont différents";
$lang["error_cant_delete_files"] = "Fabrilia n'arrive pas à supprimer les fichiers d'installation";
$lang["error_cant_connect"] = "Impossible de se connecter à la base de données";
$lang["error_database_already_exists"] = "La base de données existe déjà";
$lang["error_database_dont_exist"] = "La base de données n'existe pas";
$lang["error_login_ban"] = "Votre IP a été bloquée pour 10mn.";
$lang["error_login_bad"] = "Vérifier vos identifiants, l'identification a échouée.";

$lang["about_footer"] = "À Propos";
$lang["Fabrilia_footer"] = "<a href=\"https://www.fabrilia.net/\" target=\"_blank\">Fabrilia</a> est une application fournie par <a href=\"https://www.partipirate.org\" target=\"_blank\">le Parti Pirate</a>";
?>