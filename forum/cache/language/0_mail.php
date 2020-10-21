<?php
/*
language: Deutsch
category: mail
*/


$this->items['LANG_MAIL_ACTIVATION_SUBJECT']="Ihre Freischaltung bei \$master_board_name_email";
$this->items['LANG_MAIL_ACTIVATION_TEXT']="Hallo \$username,

Ihr Account bei \$master_board_name_email wurde soeben freigeschaltet. Sie k�nnen sich jetzt mit Ihren Benutzerdaten anmelden.
\$url2board/index.php


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_APPLICATION_ACCEPTED_SUBJECT']="Bewerbung f�r die Benutzergruppe \$title akzeptiert";
$this->items['LANG_MAIL_APPLICATION_ACCEPTED_TEXT']="Hallo \$username,

Ihre Bewerbung f�r die Benutzergruppe \$title wurde akzeptiert.
Sie sind nun Mitglied der Benutzergruppe \$title.

Grund (optional):
\$reply


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_APPLICATION_REFUSED_SUBJECT']="Bewerbung f�r die Benutzergruppe \$title abgelehnt";
$this->items['LANG_MAIL_APPLICATION_REFUSED_TEXT']="Hallo \$username,

Ihre Bewerbung f�r die Benutzergruppe \$title wurde abgelehnt.

Grund (optional):
\$reply


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_APPLICATION_SUBJECT']="Bewerbung von \$username f�r die Benutzergruppe \$title";
$this->items['LANG_MAIL_APPLICATION_TEXT']="Hallo \$groupleader,

\$username bewirbt sich f�r die Benutzergruppe \$title.

Um die Bewerbung zu bearbeiten, klicken Sie bitte auf folgenden Link:
\$url2board/usergroups.php?action=groupleaders_editapplication&applicationid=\$applicationid

Bewerbung:
\$reason


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_EC1_SUBJECT']="Aktivierung Ihres Accounts bei \$master_board_name_email vornehmen.";
$this->items['LANG_MAIL_EC1_TEXT']="Hallo \$username,

Sie haben Ihre E-Mail-Adresse bei \$master_board_name_email ge�ndert. Ihr Account wurde daraufhin vor�bergehend deaktiviert bzw. in den eingeschr�nkten Modus versetzt.

Um Ihren Account wieder zu aktivieren, m�ssen Sie auf diesen Link klicken:
\$url2board/register.php?action=activation&usrid=\$userid&a=\$activation

<a href=\"\$url2board/register.php?action=activation&usrid=\$userid&a=\$activation\">AOL Benutzer klicken bitte hier!</a>

**** Funktioniert der Link oben nicht? ****
Wenn der Link nicht funktioniert, sollten Sie folgende Adresse in Ihrem Browser aufrufen:
\$url2board/register.php?action=activation

Bitte achten Sie darauf, dass keine Leerzeichen in der Adresse sind.
Wenn Sie den letzteren Link ( \$url2board/register.php?action=activation ) benutzt haben, m�ssen Sie auf der erscheinenden Seite Ihren Benutzernummer sowie den Aktivierungscode eingeben.

Ihre Benutzernummer lautet: 	\$userid
Ihr Aktivierungscode lautet: 	\$activation

Wenn Sie Probleme beim Aktivieren Ihres Accounts haben, sollten Sie einem Mitglied unseres Support-Teams eine E-Mail schicken.
-> \$webmastermail

Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_EC3_SUBJECT']="Neues Passwort f�r Ihren Account bei \$master_board_name_email";
$this->items['LANG_MAIL_EC3_TEXT']="Hallo \$username,

Sie haben Ihre E-Mail-Adresse bei \$master_board_name_email ge�ndert. Um sich Anzumelden ben�tigen Sie das Passwort aus dieser E-Mail.

Ihr neues Passwort lautet:		\$r_password


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_FORGOTPW_SUBJECT_1']="Passwort vergessen bei \$master_board_name_email";
$this->items['LANG_MAIL_FORGOTPW_SUBJECT_2']="Neues Passwort bei \$master_board_name_email";
$this->items['LANG_MAIL_FORGOTPW_TEXT_1']="Hallo \$username,

wenn Sie Ihr Passwort vergessen haben, ist die einzige L�sung, ein neues Passwort zu erstellen. Dieses k�nnen Sie sp�ter in Ihrem Profil �ndern.
Klicken Sie hier, damit Ihnen ein neues Passwort zugeschickt werden kann: \$url2board/forgotpw.php?action=pw&userid=\$userid&pwhash=\$pwhash

Falls Sie Ihr Passwort nicht vergessen haben, sollten Sie diese E-Mail ignorieren.


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_FORGOTPW_TEXT_2']="Hallo \$username,

Ihr neues Passwort lautet: \$newpw
Sie k�nnen das Passwort jederzeit in Ihrem Profil �ndern.


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_MOD_NEWPOST_SUBJECT']="Neuer Beitrag zum Thema: \$topic";
$this->items['LANG_MAIL_MOD_NEWPOST_TEXT']="Hallo \$username,

es gibt einen neuen Beitrag zum Thema: \$topic
Dieser Beitrag wurde erstellt von: \$author

Benutzen Sie diesen Link um direkt zum Beitrag zu springen:
\$url2board/thread.php?postid=\$postid#post\$postid


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_MOD_NEWTHREAD_SUBJECT']="Neues Thema im Forum: \$title";
$this->items['LANG_MAIL_MOD_NEWTHREAD_TEXT']="Hallo \$username,

es gibt ein neues Thema im Forum: \$title
Dieses Thema tr�gt den Namen �\$topic� und wurde erstellt von: \$author

Benutzen Sie diesen Link um direkt zum Thema zu springen:
\$url2board/thread.php?threadid=\$threadid


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_NEWPM_SUBJECT']="Neue private Nachricht in \$master_board_name_email";
$this->items['LANG_MAIL_NEWPM_TEXT']="Hallo \$username,

Sie haben eine neue private Nachricht von \$sender erhalten.

Benutzen Sie diesen Link um direkt zu Ihrem Posteingang zu springen:
\$url2board/pms.php


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_NEWPOST_SUBJECT']="Neuer Beitrag zum Thema: \$topic";
$this->items['LANG_MAIL_NEWPOST_TEXT']="Hallo \$username,

es gibt einen neuen Beitrag zum Thema: \$topic
Dieser Beitrag wurde erstellt von: \$author

Benutzen Sie diesen Link um direkt zum Beitrag zu springen:
\$url2board/thread.php?postid=\$postid#post\$postid

Die Benachrichtigung zu diesem Thema k�nnen Sie in Ihrer Favoriten Verwaltung im Forum ausstellen:
\$url2board/usercp.php?action=favorites


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_NEWPW_SUBJECT']="Neues Passwort f�r Ihren Account bei \$master_board_name_email";
$this->items['LANG_MAIL_NEWPW_TEXT']="Hallo \$username,

Ihr Passwort bei \$master_board_name_email wurde von einem Administrator ge�ndert.

Ihr neues Passwort lautet:		\$newpassword


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_NEWTHREAD_SUBJECT']="Neues Thema im Forum: \$title";
$this->items['LANG_MAIL_NEWTHREAD_TEXT']="Hallo \$username,

es gibt ein neues Thema im Forum: \$title
Dieses Thema tr�gt den Namen �\$topic� und wurde erstellt von: \$author

Benutzen Sie diesen Link um direkt zum Thema zu springen:
\$url2board/thread.php?threadid=\$threadid

Die Benachrichtigung zu diesem Forum k�nnen Sie in Ihrer Favoriten Verwaltung im Forum ausstellen:
\$url2board/usercp.php?action=favorites


Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_REGISTER1_SUBJECT']="Aktivierung der Registrierung bei \$master_board_name_email vornehmen.";
$this->items['LANG_MAIL_REGISTER1_TEXT']="Hallo \$r_username,

Vielen Dank f�r Ihre Registrierung bei \$master_board_name_email. Bevor wir Ihre Registrierung aktivieren k�nnen, m�ssen Sie einen letzten Schritt machen.

Anmerkung: Sie m�ssen diesen letzten Schritt machen, um Ihre Registrierung zu Ende zu f�hren.

Um die Registrierung zu vervollst�ndigen, m�ssen Sie auf diesen Link klicken:
\$url2board/register.php?action=activation&usrid=\$insertid&a=\$activation

<a href=\"\$url2board/register.php?action=activation&usrid=\$insertid&a=\$activation\">AOL Benutzer klicken bitte hier!</a>

**** Funktioniert der Link oben nicht? ****
Wenn der Link nicht funktioniert, sollten Sie folgende Adresse in Ihrem Browser aufrufen:
\$url2board/register.php?action=activation

Bitte achten Sie darauf, dass keine Leerzeichen in der Adresse sind.
Wenn Sie den letzteren Link ( \$url2board/register.php?action=activation ) benutzt haben, m�ssen Sie auf der erscheinenden Seite Ihren Benutzernummer sowie den Aktivierungscode eingeben.

Ihre Benutzernummer lautet: 	\$insertid
Ihr Aktivierungscode lautet: 	\$activation

Sollten Sie sich nicht bei \$master_board_name_email angemeldet haben, k�nnen Sie diese E-Mail ignorieren.

Wenn Sie Probleme beim Registrieren haben, sollten Sie einem Mitglied unseres Support-Teams eine E-Mail schicken.
-> \$webmastermail

Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_REGISTER3_SUBJECT']="Passwort f�r Ihren Account bei \$master_board_name_email";
$this->items['LANG_MAIL_REGISTER3_TEXT']="Hallo \$r_username,

Vielen Dank f�r Ihre Registrierung bei \$master_board_name_email. Um sich Anzumelden ben�tigen Sie das Passwort aus dieser E-Mail.

Ihr Benutzername lautet:	\$r_username
Ihr Passwort lautet:		\$r_password

Sollten Sie sich nicht bei \$master_board_name_email angemeldet haben, k�nnen Sie diese E-Mail ignorieren.

Wenn Sie Probleme beim Registrieren haben, sollten Sie einem Mitglied unseres Support-Teams eine E-Mail schicken.
-> \$webmastermail

Vielen Dank,
Ihr \$master_board_name_email Team";
$this->items['LANG_MAIL_REGNOTIFY_SUBJECT']="Neue Registrierung bei \$master_board_name_email";
$this->items['LANG_MAIL_REGNOTIFY_TEXT']="Hallo Administrator,

bei \$master_board_name_email erfolgte eine neue Registrierung durch: \$r_username";
$this->items['LANG_MAIL_REPORT_SUBJECT']="Beschwerde �ber Beitrag von \$author";
$this->items['LANG_MAIL_REPORT_TEXT']="Hallo \$mod,

\$username beschwert sich �ber diesen Beitrag von \$author:
\$url2board/thread.php?postid=\$postid#post\$postid

Grund:
\$reason


Vielen Dank,
Ihr \$master_board_name_email Team";
?>