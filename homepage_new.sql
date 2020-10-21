# phpMyAdmin SQL Dump
# version 2.5.7
# http://www.phpmyadmin.net
#
# Host: localhost
# Erstellungszeit: 26. Dezember 2004 um 13:22
# Server Version: 4.0.20
# PHP-Version: 4.3.8
# 
# Datenbank: `homepage_new`
# 

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_cats`
#

DROP TABLE IF EXISTS `hp1_cats`;
CREATE TABLE `hp1_cats` (
  `catid` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `styleid` int(11) NOT NULL default '0',
  `top_image` varchar(255) NOT NULL default '',
  `style` int(2) NOT NULL default '0',
  `subcat` int(1) NOT NULL default '0',
  `maincat` int(11) NOT NULL default '0',
  `sort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`catid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_cats`
#

INSERT INTO `hp1_cats` (`catid`, `title`, `description`, `styleid`, `top_image`, `style`, `subcat`, `maincat`, `sort`) VALUES (1, 'Downloads', '', 0, 'images/top_downloads.gif', 1, 0, 0, 1),
(2, 'Artikel', '', 0, 'images/top_articles.gif', 2, 0, 0, 2),
(3, 'Quellcodes', '', 0, 'images/top_sourcecodes.gif', 1, 0, 0, 3),
(4, 'Kurse', '', 0, 'images/top_tutorials.gif', 2, 0, 0, 4),
(5, 'Tipps', '', 0, 'images/top_tips.gif', 3, 0, 0, 5),
(6, 'Links', 'In dieser Kategorie befinden sich zahlreiche und wirklich empfehlenswerte Links zu Seiten aus dem Bereich der Programmierung, geordnet nach diversen Kategorien. Nehmen Sie sich doch die Zeit und stöbern Sie doch ganz einfach mal ein wenig.\r\n\r\nDes weiteren möchten wir Ihnen die Möglichkeit geben, interessante Seiten hier zur verlinken. Betätigen Sie bitte den unten stehenden Link, um ein Webprojekt vorzuschlagen. ', 0, 'images/top_links.gif', 4, 0, 0, 6),
(7, 'Allgemeine Links', 'Links, die sich keiner Kategorie so wirklich zuordnen lassen und dennoch sich dem Thema Programmierung widmen, werden in dieser Kategorie zu finden sein.', 0, '', 0, 1, 6, 1),
(8, 'ASP', '[b]Test[/b]\r\nHallo', 0, '', 0, 1, 6, 2),
(9, 'Assembler', '', 0, '', 0, 1, 6, 3),
(10, 'C/C++/C#', '', 0, '', 0, 1, 6, 4),
(11, 'Cobol', '', 0, '', 0, 1, 6, 5),
(12, 'Delphi/Kylix', '', 0, '', 0, 1, 6, 6),
(13, 'Fortran', '', 0, '', 0, 1, 6, 7),
(14, 'Java', '', 0, '', 0, 1, 6, 8),
(15, '.NET', '', 0, '', 0, 1, 6, 9),
(16, 'Pascal', '', 0, '', 0, 1, 6, 10),
(17, 'Perl', '', 0, '', 0, 1, 6, 11),
(18, 'PHP', '', 0, '', 0, 1, 6, 12),
(19, 'Visual Basic', '', 0, '', 0, 1, 6, 13),
(20, 'Webdesign', '', 0, '', 0, 1, 6, 14);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_designpacks`
#

DROP TABLE IF EXISTS `hp1_designpacks`;
CREATE TABLE `hp1_designpacks` (
  `designpackid` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `color_1` varchar(7) NOT NULL default '',
  `color_2` varchar(7) NOT NULL default '',
  `css` text NOT NULL,
  PRIMARY KEY  (`designpackid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_designpacks`
#

INSERT INTO `hp1_designpacks` (`designpackid`, `title`, `color_1`, `color_2`, `css`) VALUES (1, 'Standard', '', '', '<style type="text/css">\r\n<!--\r\nbody {\r\n background-color: #D6E2F1;\r\n\r\n margin-top: 0px;\r\n margin-left: 0px;\r\n margin-right: 0px;\r\n margin-bottom: 10px;\r\n font-family: Verdana, Helvetica, Arial;\r\n font-size: 8pt;\r\n text-align: left;\r\n color: #000000;\r\n scrollbar-base-color: #FFFFFF;\r\n scrollbar-3dlight-color: #DFDFDF;\r\n scrollbar-arrow-color: #FFFFFF;\r\n scrollbar-darkshadow-color: #0E3989;\r\n scrollbar-face-color: #7F99B2;\r\n scrollbar-highlight-color: #B3C2D2;\r\n scrollbar-shadow-color: #000000;\r\n scrollbar-track-color: #7F99B2;\r\n}\r\n.black {\r\n font-size: 8pt;\r\n color: #000000;\r\n font-weight: bold;\r\n text-decoration: underline;\r\n}\r\n.small {\r\n font-size: 7pt;\r\n color: #000000;\r\n}\r\n.nav {\r\n background-image: url(images/nav_back.gif);\r\n}\r\n.top {\r\n background-image: url(images/top_back.gif);\r\n}\r\n.cat {\r\n background-image: url(images/cat_back.gif);\r\n font-family: Verdana, Helvetica, Arial;\r\n font-weight: bold;\r\n font-size: 10px;\r\n color: #FFFFFF;\r\n}\r\n.input{\r\n background-color: #F5B968;\r\n border-color: #000000;\r\n border-width: 1px;\r\n background-image: url(\'images/orange_input.gif\');\r\n\r\n font-family: Verdana, Helvetica, Arial;\r\n font-size: 8pt;\r\n text-align: left;\r\n color: #000000;\r\n font-weight: bold;\r\n}\r\ninput, textarea {\r\n background-color: #D9E3EC;\r\n border-color: #000000;\r\n border-width: 1px;\r\n border-collapse: collapse;\r\n background-image: url(\'images/input.gif\');\r\n\r\n font-family: Verdana, Helvetica, Arial;\r\n font-size: 8pt;\r\n text-align: left;\r\n color: #000000;\r\n font-weight: bold;\r\n}\r\na {\r\n font-family: Verdana;\r\n color: #000000;\r\n}\r\na:hover {\r\n color: #800000;\r\n text-decoration: none;\r\n}\r\na:visited {\r\n font-family: Verdana;\r\n color: #000000;\r\n}\r\nselect {\r\n background-color: #D9E3EC;\r\n border-color: #000000;\r\n border-width: 1px;\r\n border-collapse: collapse;\r\n\r\n font-family: Verdana, Helvetica, Arial;\r\n font-size: 8pt;\r\n text-align: left;\r\n color: #000000;\r\n font-weight: bold;\r\n}\r\n-->\r\n</style>');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_languages`
#

DROP TABLE IF EXISTS `hp1_languages`;
CREATE TABLE `hp1_languages` (
  `langid` int(11) NOT NULL auto_increment,
  `language` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`langid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_languages`
#

INSERT INTO `hp1_languages` (`langid`, `language`, `image`) VALUES (1, 'Deutsch', 'german.gif'),
(2, 'Mehrsprachig', 'multi.gif'),
(3, 'Englisch', 'english.gif');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_links`
#

DROP TABLE IF EXISTS `hp1_links`;
CREATE TABLE `hp1_links` (
  `linkid` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `language` int(11) NOT NULL default '0',
  `location` varchar(255) NOT NULL default '',
  `clicks` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`linkid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_links`
#

INSERT INTO `hp1_links` (`linkid`, `title`, `description`, `language`, `location`, `clicks`, `cat_id`) VALUES (1, 'http://www.quellcodes.de', 'Seit kurzem befasst sich diese Seite nicht nur mit der Verbreitung von Quellcodes, sondern bietet auch etliches an Zusatzmaterial wie z.B. Kurse.', 1, 'http://www.quellcodes.de', 2, 0),
(2, 'http://www.onlinetutorials.de/', 'Gro&szlig;e Archive mit hochwertigen Kursen findet man im Internet mit Sicherheit selten. Dem Betreiber ist in diesem Fall jedoch ein guter Mix aus Qualit&auml;t und Masse gelungen.', 1, 'http://www.onlinetutorials.de/', 2, 0),
(3, 'http://www.source-center.de/', 'F&uuml;r Anf&auml;nger empfiehlt sich mit Sicherheit ein Besuch dieser Seite. Zahlreiche Beispiele demonstrieren die Verwendung teilweise komplexer Routinen.', 0, 'http://www.source-center.de/', 2, 0),
(4, 'http://www.onlinelesen.de/', 'Die Seite ist &uuml;bersichtlich gegliedert, kann jedoch nicht vollkommen &uuml;berzeugen. Dennoch ist ein Besuch bei der Suche nach Zusatzliteratur mit Sicherheit empfehlenswert.', 0, 'http://www.onlinelesen.de/', 2, 0),
(5, 'http://www.codeproject.com/', 'Auf dieser Seite finden Sie zahlreiche Kurse, Artikel, Neuigkeiten und Libaries zur .Net-Programmierung.', 3, 'http://www.codeproject.com/', 16, 0),
(6, 'http://www.dotnet247.com/', 'Bei den meisten Usern wirft der Begriff ".Net" immer noch Verwunderung hervor. Diese Seite bietet jedenfalls zahlreiche Informationen zu Microsofts neuestem Werk .Net. Einen Besuch ist diese Seite definitiv wert. ', 0, 'http://www.dotnet247.com/', 16, 0),
(7, 'http://asp.net/', 'Diese Seite richtet sich an Einsteiger aber auch an Fortgeschrittene ASP\'ler. Hier finden Sie einige Kurse, Beispiele und Neuigkeiten.', 0, 'http://asp.net/', 3, 0),
(8, 'http://www.asphelper.de/', 'Ein ausf&uuml;hrlicher Kurs f&uuml;r ASP-Neulinge, &uuml;bersichtlich in viele Kapitel gegliedert. Weniger erfreulich ist jedoch die Tatsache, dass die Betreiber ihren Kurs nicht als Offline-Version zum Download zur Verf&uuml;gung stellen.', 0, 'http://www.asphelper.de/', 3, 0),
(9, 'http://user.berlin.de/~andre.mueller/', 'Angehende Assembler-Programmierer haben es in einer Welt von sogenannten Hochsprachen zunehmend schwerer. Dieser Kurs stimmt jedoch optimistisch und &uuml;berzeugt durch seine Detailtreue.', 0, 'http://user.berlin.de/~andre.mueller/', 1, 0),
(10, 'http://www.jegerlehner.ch/', 'Eine Code-Tabelle f&uuml;r Intel x86 Prozessoren.', 0, 'http://www.jegerlehner.ch/', 1, 0),
(11, 'http://www.cybertrails.com/~fys/newbasic.htm', 'Hierbei handelt es sich um die offizielle Herstellerseite des kostenlosen NBASM-Compilers. Dieser steht hier selbstverst&auml;ndlich auch zum Download zur Verf&uuml;gung.', 0, 'http://www.cybertrails.com/~fys/newbasic.htm', 1, 0),
(12, 'http://www.c-plus-plus.de.vu/', 'Das Angebot an Programmen und Kursen &uuml;berzeugt. Dennoch stellt sich zumindest mir die Frage, ob ein Projekt ohne feste Domain ernstgenommen werden kann.', 0, 'http://www.c-plus-plus.de.vu/', 5, 0),
(13, 'http://www.c-plusplus.de/', 'Ein Besuch l&auml;sst das Herz des Programmierers mit gro&szlig;er Wahrscheinlichkeit h&ouml;herschlagen. Grund daf&uuml;r sind die zahlreich verf&uuml;gbaren und &uuml;berwiegend kostenlosen Compiler.', 0, 'http://www.c-plusplus.de/', 5, 0),
(14, 'http://www.mathematik.uni-marburg.de/~cpp/', 'Auf den Seiten der Uni-Marburg st&ouml;sst man auf diesen wirklich empfehlenswerten C++-Kurs. Dieser Kurs vermittelt die n&ouml;tigsten Grundlagen und kann auch als erg&auml;nzende Literatur hinzugezogen werden.', 0, 'http://www.mathematik.uni-marburg.de/~cpp/', 5, 0),
(15, 'http://www.cplus-plus.de/', 'Auch dieses Angebot kann weitesgehend &uuml;berzeugen. Kurse, Links, Quellcodes und noch einiges mehr wartet hier auf den User.', 0, 'http://www.cplus-plus.de/', 5, 0),
(16, 'http://www.c-lernen.de/', 'Moderne Programmiersprachen wie Delphi, Java, C++ und C# dominieren momentan die Programmiererszene. Dennoch ist C immer noch gefragt, vorallem aufgrund der M&ouml;glichkeit C auch auf alternativen Plattformen wie Linux einsetzen zu k&ouml;nnen.', 0, 'http://www.c-lernen.de/', 4, 0),
(17, 'http://www.borland.com/bcppbuilder/', 'Der <i>Borland C++ Builder</i> eignet sich hervorragend f&uuml;r Neulinge und Delphiumsteiger. Die VCL erm&ouml;glicht &auml;hnlich wie bei Delphi das bequeme Zusammenstellen von Anwendungsoberfl&auml;chen.', 0, 'http://www.borland.com/bcppbuilder/', 5, 0),
(18, 'http://www.pronix.de/', 'Hierbei handelt es sich um einen ausgezeichneten C-Kurs f&uuml;r Windows und Linux. Die Quellcodes zum Kurs stehen auf der Seite auch zum Download zur Verf&uuml;gung.', 0, 'http://www.pronix.de/', 4, 0),
(19, 'http://www.guidetocsharp.de/', 'Microsofts neuestes Werk C#, konnte die Herzen der Programmierer im Gegensatz zum Vorg&auml;nger nicht im Sturm erobern. Skepsis ist diesbez&uuml;glich mit Sicherheit angebracht, aber ein Besuch dieser Seite lohnt sich dennoch. ', 0, 'http://www.guidetocsharp.de/', 6, 0),
(20, 'http://www.c-sharpcorner.com/', 'Meines Wissens nach das mit Abstand gr&ouml;&szlig;te Portal f&uuml;r C#-Programmierer. Englischprofis sollte man vom Besuch nicht abhalten.', 0, 'http://www.c-sharpcorner.com/', 6, 0),
(21, 'http://ladedu.com/cpp/', 'Wirklich hochwertige C++-Kurse findet man im Internet leider nur selten. Dieser stimmt jedoch optimistisch.', 0, 'http://ladedu.com/cpp/', 5, 0),
(22, 'http://www.cm.cf.ac.uk/Dave/C/CE.html', 'Hinter einer wirklich nichtssagenden Url verbirgt sich dieser wirklich gut gelungene Kurs. Der Autor geht leider nur auf die Entwicklung unter Unixsystemen ein.', 0, 'http://www.cm.cf.ac.uk/Dave/C/CE.html', 5, 0),
(23, 'http://www.intap.net/~drw/cpp/index.htm', 'Dieser Kurs geht wohl in der Masse unter. Ihm mangelt es &uuml;berwiegend an Detailtreue, aber als Zusatzmaterial sollte er hinzugezogen werden.', 0, 'http://www.intap.net/~drw/cpp/index.htm', 5, 0),
(24, 'http://www.math.uni-wuppertal.de/~axel/skripte/oop/oop_cont.html', 'Auf den Seiten der Uni-Wuppertal finden Sie diesen wirklich interessanten und empfehlenswerten Kurs, der die objektorienttierte Programmierung unter C++ und Java n&auml;her erl&auml;utert. ', 0, 'http://www.math.uni-wuppertal.de/~axel/skripte/oop/oop_cont.html', 5, 0),
(25, 'http://www.vcdj.com/', 'Hierbei handelt es sich um die offizielle Homepage des Visual C++ Developer Journals, welches regelm&auml;&szlig;ig mit interessanten Artikeln dem User den neuesten Stand der Dinge vermittelt.', 0, 'http://www.vcdj.com/', 5, 0),
(26, 'http://www.informatik.uni-halle.de/lehre/c/', 'F&uuml;r C-Einsteiger ist dieser Kurs w&auml;rmstens zu empfehlen. S&auml;mtliche Grundlagen werden ausreichend erl&auml;utert.', 0, 'http://www.informatik.uni-halle.de/lehre/c/', 4, 0),
(27, 'http://www.cobol-workshop.de/', 'Cobol ist in den letzten Jahren nahezu komplett in der Versenkung verschwunden. Wie dieses Projekt beweist, sind die Fans dieser Programmiersprache jedoch noch nicht ganz ausgestorben.', 0, 'http://www.cobol-workshop.de/', 7, 0),
(28, 'http://www.fortran.de/', 'Von einer echten Alternative sollte man bei Fortran nicht sprechen. Dennoch sind auch hier noch nicht alle Fans ausgestorben, aber wohl die meisten.', 0, 'http://www.fortran.de/', 8, 0),
(29, 'http://www.java-archiv.com/home', 'Der Javaboom ist inzwischen mit Sicherheit vorbei, auch wenn es sich bei Java um die bisher einzigste, wirklich plattformabh&auml;ngige Programmiersprache handelt. Diese Seite bietet jedenfalls eine recht gro&szlig;e Auswahl an Applets und Kursen.', 0, 'http://www.java-archiv.com/home', 9, 0),
(30, 'http://people.freenet.de/neumann-borken/', 'Ein Blick auf die Url stimmt mit Sicherheit alles andere als optimistisch. Doch der Schein tr&uuml;gt, denn dahinter verbirgt sich ein wirklich informativer Javakurs.', 0, 'http://people.freenet.de/neumann-borken/', 9, 0),
(31, 'http://www.delphi-treff.de/', 'Philipp Frenzel bietet dem Delphineuling eigentlich alles an Informationen, was er ben&ouml;tigen k&ouml;nnte. Eine ausgewogene Auswahl an Komponenten, Kursen und Links sind hier zu finden. Unbedingt muss an dieser Stelle noch der EDH 2000 erw&auml;hnt werden. Hierbei handelt es sich um eine gigantische Tipps&Trick-Sammlung mit &uuml;ber 400 Artikeln. Inzwischen kann die EDH-Datenbank auch online betrachtet werden.', 0, 'http://www.delphi-treff.de/', 11, 0),
(32, 'http://www.delphi-source.de/', 'Die beiden Administratoren Martin Strohal und Johannes Tr&auml;nkle haben mit diesem Projekt eine hervorragende Arbeit abgeliefert. Ein gro&szlig;es Archiv mit interessanten Kursen f&uuml;r Anf&auml;nger, Fortgeschrittene und selbst f&uuml;r Profis wartet hier auf den Delphianer.', 0, 'http://www.delphi-source.de/', 11, 0),
(33, 'http://www.torry.ru/', 'Bei Torry.ru handelt es sich nur um einen von vielen Mirrors der Seite "Torry\'s Delphipages". Auf der Seite befindet sich eine gigantische Datenbank mit Komponenten und Funktionen.', 0, 'http://www.torry.ru/', 11, 0),
(36, 'http://www.swissdelphicenter.ch/', 'F&uuml;r den jungen Delphianer empfiehlt sich mit Sicherheit ein Besuch dieser Seite. Ein optisch ansprechendes Design veredelt dieses umfangreiche Angebot.', 0, 'http://www.swissdelphicenter.ch/', 11, 0),
(37, 'http://home.t-online.de/home/Peter.Zwosta/', 'Man k&ouml;nnte es ein Nischenprodukt nennen. Peter Zwosta stellt auf seiner kleinen Seite Kurse und Beispiele zum Thema CAPI-Programmierung zur Verf&uuml;gung.', 0, 'http://home.t-online.de/home/Peter.Zwosta/', 11, 0),
(38, 'http://www.erm.tu-cottbus.de/delphi', 'Lange Zeit handelte es sich hierbei um einen echten Geheimtipp, doch inzwischen findet man einige Kurse schon auf fast allen bekannten Delphiseiten. Assarbad stellt auf seiner "selbstgemachten" Seite anspruchsvolle Kurse zur systemnahen Programmierung vor.', 0, 'http://www.erm.tu-cottbus.de/delphi', 11, 0),
(39, 'http://www.borland.com/', 'Die offizielle Seite der Firma Borland, dem Hersteller von Turbo Pascal, Delphi und Kylix. Immer wieder behaupten Stimmen, dass sich Delphi besonders f&uuml;r Programmierneulinge eignet. Die Syntax von Delphi ist ebenso komplex wie die Syntax anderer Plattformen, jedoch die M&ouml;glichkeit die Benutzeroberfl&auml;che per Mausklick zusammenstellen erleichter zumindest die Arbeit. Aber entwerfen ist nun mal leider nicht gleich programmieren.', 0, 'http://www.borland.com/', 11, 0),
(40, 'http://www.jens-doerpinghaus.de.vu/', 'Der Betreiber Jens Doerpinghaus ver&ouml;ffentlicht auf seiner kleine Homepage wirklich informative Kurse zum Thema "Spieleprogrammierung".', 0, 'http://www.jens-doerpinghaus.de.vu/', 11, 0),
(41, 'http://www.delphi-jedi.org/', 'Auf dieser Seite finden Sie eine wirklich gro&szlig;e Sammlung an Funktionen und Prozeduren. Ein Besuch lohnt sich grunds&auml;tzlich immer, ausreichend Zeit vorausgesetzt.', 0, 'http://www.delphi-jedi.org/', 11, 0),
(42, 'http://members.tripod.de/franz_pletz/index.html', 'Auf dieser Seite finden Sie einige Kurse und Quellcodes zur Programmiersprache Pascal. F&uuml;r Nostalgiker ist diese Adresse mit Sicherheit empfehlenswert.', 0, 'http://members.tripod.de/franz_pletz/index.html', 10, 0),
(43, 'http://www.pascalworld.de/', 'Auf dieser Seite stehen einige empfehlenswerte Pascal-Kurse zum Download zur Verf&uuml;gung. Die Kurse eignen sich optimal zur Erg&auml;nzung des Schulstoffes.', 0, 'http://www.pascalworld.de/', 10, 0),
(44, 'http://www.delphi3000.com/', 'Auf dieser Seite finden Sie etliche qualitativ hochwertige Tutorials zu nahezu allen Themenbereichen.', 0, 'http://www.delphi3000.com/', 11, 0),
(45, 'http://www.delphispirit.com/', 'Sollten Sie auf der Suche nach einer speziellen Komponente sein, k&ouml;nnen jedoch auf den bekannten Seiten wie z.B. Torry nichts finden, so sollten Sie dieser Seite mal einen Besuch abstatten.', 0, 'http://www.delphispirit.com/', 11, 0),
(46, 'http://www.ensacom.de', 'Dieses Projekt hat sich in letzter Zeit erstaunlich schnell entwickelt und verf&uuml;gt nun &uuml;ber ein recht gro&szlig;es Archiv an Tipps, Links, Komponenten und Quellcodes.', 0, 'http://www.ensacom.de', 11, 0),
(47, 'http://www.phy.uni-bayreuth.de/~btpa25/perl', 'Auf dieser Seite der Uni-Bayruth finden Sie einen informativen und umfangreichen Perl-Kurs, der sich optimal f&uuml;r Perl-Neulinge eignet.', 0, 'http://www.phy.uni-bayreuth.de/~btpa25/perl', 12, 0),
(48, 'http://www.perlhelp.de/', 'Diese Seite bietet einige Kurse und eine gro&szlig;e Anzahl an ausgew&auml;hlten Tipps. Ein gelegentlicher Besuch lohnt sich mit Sicherheit.', 0, 'http://www.perlhelp.de/', 12, 0),
(49, 'http://www.dynamic-webpages.de/', 'PHP ist Trend! Anders kann man den PHP-Boom kaum noch in Worte fassen. Innerhalb k&uuml;rzester Zeit wurde PHP zur beliebtesten Scriptsprache. Zu den Vorteilen geh&ouml;ren unter anderem wohl die recht primitive Syntax, die Plattformunabh&auml;ngigkeit, sowie die g&uuml;nstigen Entwicklungskosten. Die Artikel dieser Seite sollten meiner Meinung nach nur als Zusatzliteratur genutzt werden.', 0, 'http://www.dynamic-webpages.de/', 13, 0),
(50, 'http://www.selfphp3.de/', 'Hierbei handelt es sich um ein Partnerprojekt von SelfHTML und ist ebenso w&auml;rmstens zu empfehlen. Es wird hier jedoch nicht n&auml;her auf die Grundlagen eingegangen, es handelt sich in diesem Fall um eine ausf&uuml;hrliche Sprachreferenz.', 0, 'http://www.selfphp3.de/', 13, 0),
(51, 'http://www.php-center.de/', 'Diese Seite &uuml;berzeugt durch eine &uuml;bersichtliche Gliederung und ein ansprechendes Design. Das Projekt umfasst eine gro&szlig;e Anzahl an Neuigkeiten, Informationen und eine umfangreiche Auswahl an Kursen.', 0, 'http://www.php-center.de/', 13, 0),
(55, 'http://www.koehntopp.de/kris/artikel/php3-einfuehrung/', 'Der kurs bietet Anf&auml;ngern einen optimalen Einstieg. Die zugeh&ouml;rige Referenz sollte als Erg&auml;nzung genutzt werden.', 0, 'http://www.koehntopp.de/kris/artikel/php3-einfuehrung/', 13, 0),
(57, 'http://www.php-homepage.de/', 'Ein gelegentlicher Besuch dieser Seite ist mit Sicherheit empfehlenswert. Interessante Kurse, Beispiele und Informationen warten auf Sie.', 0, 'http://www.php-homepage.de/', 13, 0),
(58, 'http://www.schattenbaum.net/php/', 'Auf dieser Seite finden Sie eine kleine &uuml;bersichtliche PHP-Sprachreferenz, in der die wichtigsten Befehle anschaulich erkl&auml;rt werden.', 0, 'http://www.schattenbaum.net/php/', 13, 0),
(59, 'http://www.php3-forum.de/', 'Das Forum besticht nicht gerade durch Übersichtlichkeit. Die zugeh&ouml;rige Referenz ist jedoch empfehlenswert.', 0, 'http://www.php3-forum.de/', 13, 0),
(60, 'http://www.phpcommand.de/', 'Auf dieser Seite finden Sie einen recht interessanten Workshop mit wirklich guten Beispielen.', 0, 'http://www.phpcommand.de/', 13, 0),
(61, 'http://www.php-resource.de/', 'Eine schier unersch&ouml;pfliche Quelle f&uuml;r Scripts fast jeder Art hat sich auf der Seite von PHP Resource aufgetan. Gleichg&uuml;ltig was Sie suchen, hier k&ouml;nnen Sie Ihren Durst l&ouml;schen. ASP, Java, Perl, DHTML usw. &Uuml;bersichtlich in Rubriken geordnet, verschwenden Sie auch keine Zeit mehr beim Suchen. Das php-resource.de Forum richtet sich an Anf&auml;nger sowie an Profis gleicherma&szlig;en. Fragen werden stets schnell und professionell beantwortet.', 0, 'http://www.php-resource.de/', 13, 0),
(62, 'http://www.php-experts.de/', 'Dieser Kurs sollte nur als erg&auml;nzende Literatur herangezogen werden. Auf wichtige Grundlagen wird leider nur bedingt eingegangen.', 0, 'http://www.php-experts.de/', 13, 0),
(63, 'http://www.ksl.asn-linz.ac.at/ts/vb5/', 'Auf dieser Seite finden Sie einen recht umfangreichen Kurs, der sich besonders f&uuml;r Anf&auml;nger eignet.', 0, 'http://www.ksl.asn-linz.ac.at/ts/vb5/', 14, 0),
(64, 'http://www.vbwelt.de/', 'Diese Seite bietet dem Programmierer n&uuml;tzliche Tipps, Kurse und News zu Visual Basic.', 0, 'http://www.vbwelt.de/', 14, 0),
(65, 'http://www.visual-basic-grundkurs.de/', 'Dieser Kurs ist f&uuml;r Anf&auml;nger nur zu empfehlen! Er ist &uuml;bersichtlich gegliedert und geizt in keiner Weise mit Details.', 0, 'http://www.visual-basic-grundkurs.de/', 14, 0),
(66, 'http://www.vb-seminar.de/', 'Auch dieser Kurs ist f&uuml;r Anf&auml;nger ebenfalls zu empfehlen. Die ordentliche Gliederung und die F&uuml;lle an Details machen Lust auf mehr!', 0, 'http://www.vb-seminar.de/', 14, 0),
(67, 'http://www.visualbasic-archiv.de/', 'Empfehlenswert auf dieser Homepage ist die umfangreiche Api-Referenz. Zur Fortbildung eignen sich die zahlreichen Workshops.', 0, 'http://www.visualbasic-archiv.de/', 14, 0),
(68, 'http://homepages.compuserve.de/DiplPackulat/Default.htm', 'Der Betreiber stellt mit diesem Projekt einen recht interessanten, jedoch nicht allzu umfangreichen Kurs f&uuml;r den User zur Verf&uuml;gung.', 0, 'http://homepages.compuserve.de/DiplPackulat/Default.htm', 14, 0),
(69, 'http://v-basic.de/', 'Diese Seite eignet sich besonders f&uuml;r Fans weiterer Basic-Dialekte. Gerade f&uuml;r Informationen zu Exoten wurde gesorgt.', 0, 'http://v-basic.de/', 14, 0),
(70, 'http://selfhtml.teamone.de/', 'Angehenden Webdesignern ist diese Referenz w&auml;rmstens zu empfehlen. Bei dieser Referenz werden jedoch nicht nur einzelne Funktionen erl&auml;utert, auch auf Details geht der Autor Stefan M&uuml;nz n&auml;her ein. SelfHTML befasst sich neben HTML auch mit Java-Script, CSS, XML und Perl.', 0, 'http://selfhtml.teamone.de/', 15, 0),
(72, 'http://www.math.uni-wuppertal.de/~axel/skripte/oop/oop_cont.html', 'Auf den Seiten der Uni-Wuppertal finden Sie diesen wirklich interessanten und empfehlenswerten Kurs, der die objektorienttierte Programmierung unter C++ und Java n&auml;her erl&auml;utert. ', 0, 'http://www.math.uni-wuppertal.de/~axel/skripte/oop/oop_cont.html', 9, 0),
(73, 'http://www.perlunity.de', 'Serverbasierte Scriptsprachen gewinnen immer mehr an Beliebtheit. Aus diesem Grund kann man mit ruhigem Gewissen sagen, dass PHP momentan einen Trend darstellt. PHP wurde direkt f&uuml;r den Einsatz im Internet entwickelt, w&auml;hrend Perl um einiges &auml;lter als das Internet ist und somit auch ein wenig komplexer, wenn nicht sogar komplizierter. Aus diesem Grund findet man im Internet auch wirklich wenig empfehlenswerte Kurse und genau deshalb lohnt sich ein Besuch dieser Seite.', 0, 'http://www.perlunity.de', 12, 0),
(74, 'http://www.delphi-forum.de', 'Hier treffen sich Delphi-Entwickler um &uuml;ber Probleme und L&ouml;sungen zu diskutieren. Die Community verf&uuml;gt &uuml;ber mehr als 2.500 aktive User und &uuml;ber 50.000 Beitr&auml;ge.', 0, 'http://www.delphi-forum.de', 11, 0),
(75, 'http://www.hannes-sander.net', 'Auf dieser Seite findest du viele n&uuml;tzliche Tipps& Tricks rund um Webdesign, im speziellen PHP,\r\n<br>kostenlose PHP-Scripte, ein Forum f&uuml;r deine\r\n<br>Fragen, etc. Au&szlig;erdem gibt es, um das Ganze etwas aufzulockern, noch eine gro&szlig;e Fun-Ecke sowie das\r\n<br>Internetlexikon mit &uuml;ber 300 Fachbegriffen, die hier verst&auml;ndlich erkl&auml;rt werden!', 0, 'http://www.hannes-sander.net', 13, 0),
(85, 'http://lowlevel.net.tc/', 'In diesem recht interessanten Magazin dreht sich alles um die Programmierung von Betriebssystemen. Der Artikel liesst sich, bis auf einige kleine Fehler, recht gut.', 0, 'http://lowlevel.net.tc/', 2, 0),
(79, 'http://www.delphipraxis.net/', 'Ein verh&auml;ltnism&auml;&szlig;ig gro&szlig;es, gut besuchtes Forum mit einer umfangreichen Sammlung von Codeschnippseln. ', 0, 'http://www.delphipraxis.net/', 11, 0),
(80, 'http://www.alexander-graef.de/', 'Eine private Homepage mit einem interessanten Angebot an Kursen und Informationen zu Turbo Pascal.', 0, 'http://www.alexander-graef.de/', 10, 0),
(81, 'http://www.aspfaq.de/', 'Eine umfangreiche FAQ mit vielen Artikeln zu Microsofts "Active Server Pages".', 0, 'http://www.aspfaq.de/', 3, 0),
(82, 'http://www.phptutorials.de/', 'Eine wirklich empfehlenswerte Seite die zahlreiche Tutorials zu PHP f&uuml;r Anf&auml;nger und Fortgeschrittene bereit h&auml;lt.', 0, 'http://www.phptutorials.de/', 13, 0),
(83, 'http://www.asp-database.de', 'Diese Seite besch&auml;ftigt sich fast ausschliesslich mit dem Entwickeln von Datenbankanwendungen in ASP.', 0, 'http://www.asp-database.de', 3, 0),
(84, 'http://www.productivity.org/projects/mysql/', 'Das kostenlose Datenbanksystem MySQL erfreut sichimmer gr&ouml;&szlig;erer Beliebtheit. Auf dieser Seite finden Sie eine wirklich empfehlenswerte Komponente f&uuml;r den Zugriff auf MySQL-Datenbanken.', 0, 'http://www.productivity.org/projects/mysql/', 11, 0);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_links_vote`
#

DROP TABLE IF EXISTS `hp1_links_vote`;
CREATE TABLE `hp1_links_vote` (
  `linkid` int(11) NOT NULL auto_increment,
  `count` int(11) NOT NULL default '0',
  `score` float NOT NULL default '0',
  PRIMARY KEY  (`linkid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_links_vote`
#


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_options`
#

DROP TABLE IF EXISTS `hp1_options`;
CREATE TABLE `hp1_options` (
  `id` int(11) NOT NULL default '0',
  `password` varchar(50) NOT NULL default '',
  `default_style` int(11) NOT NULL default '0',
  `debug` int(1) NOT NULL default '0',
  `webmaster_name` varchar(255) NOT NULL default '',
  `webmaster_street` varchar(255) NOT NULL default '',
  `webmaster_zip` varchar(8) NOT NULL default '',
  `webmaster_location` varchar(255) NOT NULL default '',
  `webmaster_phone` varchar(50) NOT NULL default '',
  `webmaster_mail` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_options`
#

INSERT INTO `hp1_options` (`id`, `password`, `default_style`, `debug`, `webmaster_name`, `webmaster_street`, `webmaster_zip`, `webmaster_location`, `webmaster_phone`, `webmaster_mail`) VALUES (0, '0f6203ce27649aff67b40318b8de4870', 1, 0, 'Stephan Altmann', 'Lerchenweg 53', '03130', 'Spremberg', '0174/4219941', 'webmaster@programmers-club.de');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_shop`
#

DROP TABLE IF EXISTS `hp1_shop`;
CREATE TABLE `hp1_shop` (
  `id` int(11) NOT NULL auto_increment,
  `asin` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_shop`
#

INSERT INTO `hp1_shop` (`id`, `asin`) VALUES (1, '3772388396'),
(2, '12345');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_styles`
#

DROP TABLE IF EXISTS `hp1_styles`;
CREATE TABLE `hp1_styles` (
  `styleid` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `templatepackid` int(11) NOT NULL default '0',
  `designpackid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`styleid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_styles`
#

INSERT INTO `hp1_styles` (`styleid`, `title`, `templatepackid`, `designpackid`) VALUES (1, 'Standard', 1, 1);

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_templatepacks`
#

DROP TABLE IF EXISTS `hp1_templatepacks`;
CREATE TABLE `hp1_templatepacks` (
  `templatepackid` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `files` int(1) NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`templatepackid`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_templatepacks`
#

INSERT INTO `hp1_templatepacks` (`templatepackid`, `title`, `files`, `path`) VALUES (1, 'Standard', 1, 'templates');

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `hp1_templates`
#

DROP TABLE IF EXISTS `hp1_templates`;
CREATE TABLE `hp1_templates` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `templatepackid` int(3) NOT NULL default '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Daten für Tabelle `hp1_templates`
#

INSERT INTO `hp1_templates` (`id`, `title`, `templatepackid`, `content`) VALUES (1, 'main', 1, '<!DOCTYPE HTML PUBLIC "-//W3C//bDTD HTML 4.01 Transitional//EN"\r\n       "http://www.w3.org/TR/html4/transitional.dtd">\r\n\r\n<html>\r\n<head>\r\n<title>Programmers-Club.de</title>\r\n<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">\r\n<meta name="author" content="Stephan Altmann">\r\n<meta name="description" content="Programmers-Club.de - Das Portal für Programmierer, Webdesigner und Scriptentwickler. Wir bieten zahlreiche Informationen, Artikel, Kurse, Tipps, Neuigkeiten, Links, Downloads, Quellcodes und vieles mehr zu allen bekannten Programmiers-, Script- und Beschreibungssprachen, wie C++, C, C#, Visual Basic, PHP, HTML, XML, WML, Delphi, Pascal, Cobol, Perl, Fortran, Java, Assembler,...">\r\n<meta name="keywords" content="HTML, Programmierung, Visual Basic, PHP, Delphi, Perl, Cobol, Assembler, C, C#, C++, Fortran, Links, Tipps, Kurse, Tutorials, Datenbanken, MySQL, XML, WML, Java, Pascal, Java-Script">\r\n\r\n{css}\r\n\r\n</head>\r\n<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="100%" summary="Seitenlogo">\r\n<tr class="top">\r\n <td style="border-top: 1px #000000 solid; border-left: 1px #000000 solid;"><a href="http://www.programmers-club.de"><img src="images/top_logo.gif" border="0" alt="Programmers-Club.de - Das Portal für Softwareentwickler"></a></td>\r\n <td align="right" style="border-top: 1px #000000 solid; border-right: 1px #000000 solid;"><img src="images/top_right.gif" border="0" alt=""></td>\r\n</tr>\r\n</table>\r\n\r\n<table bgcolor="#000000" cellpadding="0" cellspacing="1" width="100%" summary="Navigationsleiste">\r\n<tr height="29" class="nav">\r\n <td bgcolor="#FFFFFF" align="center"><a href="index.php" target="_top"><img src="images/top_home.gif" border="0" alt=""></a>$main_top_navigation<a href="http://www.coder-treff.de" target="_blank"><img src="images/top_forum.gif" border="0" alt=""></a></td>\r\n</tr>\r\n</table>\r\n\r\n<table cellpadding="0" cellspacing="0" width="100%" summary="Haupttabelle">\r\n<tr>\r\n <td width="210" valign="top">\r\n\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Überschrift Suche">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid" width="25"><img src="images/search.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid">Suche</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Suche">\r\n <tr height="25">\r\n  <td bgcolor="#F5B968" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid;" width="145"><input type="Text" name="search" value="Stichwort" size="20" maxlength="255" class="input"></td>\r\n  <td bgcolor="#F5B968" valign="middle" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;"><img src="images/btn_search.gif" border="0" alt=""></td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Überschrift Subnavigation">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid" width="25"><img src="images/btn_sub.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;">Subnavigation</td>\r\n </tr>\r\n </table>\r\n $main_subnavigation\r\n \r\n $main_shop\r\n\r\n </td>\r\n <td align="center" valign="top" style="padding-top: 20px;">\r\n\r\n $index_news\r\n\r\n </td>\r\n <td align="right" valign="top" width="180">\r\n\r\n$main_webring \r\n$main_newsletter\r\n$main_partner\r\n\r\n  </td>\r\n </tr>\r\n </table>\r\n\r\n </td>\r\n</tr>\r\n</table>\r\n\r\n</body>\r\n</html>\r\n'),
(15, 'index_subnavigation', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Subnavigation">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; padding: 5px; border-bottom: 1px #000000 solid;">\r\n  <a href="index.php?action=archiv">Archiv</a><br>\r\n  <a href="index.php?action=shop">Shop</a><br>\r\n  <a href="impressum.php">Impressum</a><br>\r\n  <a href="index.php?action=statistics">Statistiken</a><br>\r\n  <a href="index.php?action=link_us">Link Us</a><br>\r\n  <a href="contact.php">Kontakt</a><br>\r\n  <a href="index.php?action=sitemap">Sitemap</a><br><br>\r\n\r\n  <a href="http://www.coder-treff.de" target="_blank"><b>Forum</b></a></td>\r\n  <td bgcolor="#A7BFDB" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;" align="right" valign="middle"><img src="images/optimized.gif" border="0" alt=""><br><img src="images/valid_html.gif" border="0" alt=""><br><img src="images/browser.gif" border="0" alt=""></td>\r\n </tr>\r\n </table>'),
(5, 'main_webring', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="150" summary="Überschrift PHP-Webring">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 0px; border-bottom: 1px #000000 solid" width="25"><img src="images/btn_sub.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; padding-left: 5px;">PHP-Webring</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="150" summary="PHP-Webring">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="middle" align="center" style="border-left: 1px #000000 solid; padding: 5px; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;">\r\n\r\n  <table border="0" width="130" cellspacing="0" cellpadding="0" summary="PHP-Webring Gliederung">\r\n  <tr>\r\n   <td width="100%"><b><font size="1" face="Verdana" color="#000000">Member of</font></b></td>\r\n  </tr>\r\n  <tr>\r\n   <td width="100%" bgcolor="#FFFFFF" style="border: 1px #000000 solid;"><a href="http://www.php-resource.de/" target="_blank"><img border="0" src="http://www.php-resource.de/banner/webringlogo_light_trans.gif" alt="Webring-Logo" width="120" height="60"></a></td>\r\n  </tr>\r\n  <tr>\r\n   <td width="50%" align="left" bordercolor="#C0C0C0"><A href="http://Q.webring.com/go?ring=php&id=12&prev" target="_top"><font face="Verdana" size="1">.:: <b>Zurück</b></font></a> | <A href="http://Q.webring.com/go?ring=php&id=12&next" target="_top"><font face="Verdana" size="1"><b>Weiter ::.</b></font></a></td>\r\n  </tr>\r\n  <tr>\r\n   <td width="50%" align="center" bordercolor="#C0C0C0"><A href="http://Q.webring.com/go?ring=php&id=12&random" target="_top"><font face="Verdana" size="1">.:: <b>Zufallsseite</b> ::.</font></a></td>\r\n  </tr>\r\n  <tr>\r\n   <td width="50%" align="center" bordercolor="#C0C0C0"><A href="http://Q.webring.com/hub?ring=php&id=12&hub" target="_top"><font face="Verdana" size="1">.:: <b>Auflisten</b> ::.</font></a></td>\r\n  </tr>\r\n  <tr>\r\n   <td width="100%" align="center" bordercolor="#C0C0C0"><A href="http://Q.webring.com/wrman?ring=php&addsite" target="_top"><font face="Verdana" size="1">.:: <b>Beitreten</b> ::.</font></a></td>\r\n  </tr>\r\n  </table>\r\n\r\n  </td>\r\n </tr>\r\n </table>'),
(2, 'main_shop', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Überschrift Kaufempfehlung">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid;" width="25"><img src="images/shop.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;">Kaufempfehlung</td>\r\n </tr>\r\n </table>\r\n\r\n<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Kaufempfehlung">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="middle" align="left" style="border-left: 1px #000000 solid; padding: 5px; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;">\r\n\r\n  <table cellpadding="0" cellspacing="1" summary="Gliederung Kaufempfehlung">\r\n  <tr>\r\n   <td align="left" colspan="2"><font style="color:#000000;"><b><u>Jetzt lerne ich Delphi</u></b></font><br></td>\r\n  </tr>\r\n  <tr>\r\n   <td align="left" colspan="2">Thomas Binzinger<br><br></td>\r\n  </tr>\r\n  <tr>\r\n   <td colspan="2" align="left"><img src="images/bdel12.jpg" border="0" alt=""><br><br></td>\r\n  </tr>\r\n  <tr>\r\n   <td align="left"><b>Umfang:</b></td>\r\n   <td align="left">470 Seiten</td>\r\n  </tr>\r\n  <tr>\r\n   <td align="left"><b>Jahr:</b></td>\r\n   <td align="left">2001</td>\r\n  </tr>\r\n  <tr>\r\n   <td align="left"><b>ISBN:</b></td>\r\n   <td align="left">3827262127</td>\r\n  </tr>\r\n  <tr>\r\n   <td align="left"><b>Preis:</b></td>\r\n   <td align="left"><b>24,95 EUR</b></td>\r\n  </tr>\r\n  </table></td>\r\n </tr>\r\n </table>'),
(3, 'main_partner', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="150" summary="Überschrift Partner">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 0px; border-bottom: 1px #000000 solid;" width="25"><img src="images/partner.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; padding-left: 5px;">Partner</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="150" summary="Partner">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="middle" align="center" style="border-left: 1px #000000 solid; padding: 5px; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;">\r\n   <img src="images/firstnews.gif" alt="" border="0" style="padding-top: 5px;"><br><br>\r\n\r\n   <div align="left" style="padding-left:5px;"><table cellpadding="0" cellspacing="1" border="0" summary="Gliederung Partner">\r\n   <tr>\r\n    <td valign="bottom" style="padding-right:2px;"><img src="images/point.gif" /></td>\r\n    <td align="left"><a href="/">SONIUM-PHP</a></td>\r\n   </tr>\r\n   <tr>\r\n    <td valign="bottom" style="padding-right:2px;"><img src="images/point.gif" /></td>\r\n    <td align="left"><a href="/">DeveloperChannel</a></td>\r\n   </tr>\r\n   <tr>\r\n    <td valign="bottom" style="padding-right:2px;"><img src="images/point.gif" /></td>\r\n    <td align="left"><a href="/">Topwebtools.de</a></td>\r\n   </tr>\r\n   </table>\r\n   </div>\r\n\r\n  </td>\r\n </tr>\r\n </table>'),
(4, 'main_newsletter', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="150" summary="Überschrift Newsletter">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 0px; border-bottom: 1px #000000 solid;" width="25"><img src="images/mail.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; padding-left: 5px;">Newsletter</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="150" summary="Newsletter">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="middle" align="center" style="border-left: 1px #000000 solid; padding: 5px; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid;">\r\n  <input type="Text" name="email" value="Em@il" size="20" maxlength="255"><br>\r\n  <img src="images/btn_send.gif" alt="" border="0" style="padding-top: 5px;">\r\n  </td>\r\n </tr>\r\n </table>\r\n'),
(6, 'index_news_bit', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="100%" summary="Überschrift Neuigkeiten">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid; border-top: 1px #000000 solid;" width="25"><img src="images/news.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; border-top: 1px #000000 solid;">Neuigkeiten am 22.03.2004</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="0" cellspacing="0" width="100%" summary="Neuigkeiten">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="top" style="border-left: 1px #000000 solid; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; padding: 5px; padding-top:1px;" align="left"><div class="small"><b>Autor:</b> Stephan Altmann&nbsp;&nbsp;-&nbsp;&nbsp;<b>Uhrzeit:</b> 22:45</div><br>\r\n\r\n  <div class="black">Relaunch</div>\r\n  Nach langer Zeit voller Arbeit, bin ich froh, Ihnen das neuen Programmers-Club.de präsentieren zu dürfen. Und wie Sie sehen, es hat sich einiges getan. Das gesamte Layout wurde insgesamt ein wenig aufwendiger und wärmer gestaltet. Desweiteren wurde einige zusätzliche Funktionen, wie die Statistik integriert.<br><br>\r\n\r\n  Außerdem darf ich Ihnen eine neue Kategorie namens Artikel vorstellen. Hier werden Sie absofort Beiträge finden, die Hintergründe beleuchten, sowie über Neuigkeiten aus dem Bereich der Informationstechnik aufklären. Und auch Ihnen möchten wir die Möglichkeit geben, dort Beiträge zu veröffentlichen.<br><br>\r\n\r\n  Die gesamte Homepage basiert übrigens absofort auf einem sog. Content-Management-System (kurz: CMS), welches es ermöglicht, die Inhalte ohne HTML-Kenntnisse abzuändern. Dieses Content-Management-System wird in naher Zukunft auch zum Download zur Verfügung stehen.<br><br>\r\n\r\n  <b>Stephan Altmann</b>\r\n  </td>\r\n </tr>\r\n </table><br><br>'),
(7, 'impressum', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="100%" summary="Überschrift Impressum">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid; border-top: 1px #000000 solid;" width="25"><img src="images/info.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; border-top: 1px #000000 solid;">Impressum</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="5" cellspacing="0" width="100%" summary="Impressum">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="top" style="border-left: 1px #000000 solid; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; padding: 5px;" align="left">\r\n  \r\n  <table border="0" width="100%" summary="Gliederung" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n  <td style="padding:6px;" valign="top">\r\n  <img src="images/logo_small.gif" alt="Firstnews" border="0">\r\n  <br><br><b>Verantwortlich für dieses Projekt ist:</b><br><br>\r\n  $options[webmaster_name]<br>\r\n  $options[webmaster_street]<br>\r\n  $options[webmaster_zip] $options[webmaster_location]<br><br>\r\n\r\nTelefon: (+49) 0174/4219941<br>   \r\nE-Mail: <a href="mailto:$options[webmaster_mail]">$options[webmaster_mail]</a>\r\n\r\n</td>\r\n  <td style="padding:6px;" valign="top"><b>Weitere Projekte des Betreibers:</b><br><br>\r\n\r\n  <b>1)</b> <b>1st News</b><br>Das Newsletterscript für den prof. Einsatz<br>\r\n  --> <a href="http://www.firstnews.programmers-club.de" target="_blank">http://www.firstnews.programmers-club.de</a><br><br>\r\n\r\n  <b>2)</b> Das Forum für Software- & Scriptentwickler<br>\r\n  --> <a href="http://www.coder-treff.de" target="_blank">http://www.coder-treff.de</a></td>\r\n </tr>\r\n  </table>\r\n  \r\n  </td>\r\n </tr>\r\n </table><br><br>'),
(8, 'contact', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="100%" summary="Überschrift Kontakt">\r\n <tr height="25" class="cat">\r\n  <td bgcolor="#FFFFFF" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; border-bottom: 1px #000000 solid; border-top: 1px #000000 solid;" width="25"><img src="images/mail.gif" border="0" alt=""></td>\r\n  <td bgcolor="#FFFFFF" valign="middle" align="left" style="border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; border-top: 1px #000000 solid;">Kontakt</td>\r\n </tr>\r\n </table>\r\n <table bgcolor="#000000" cellpadding="15" cellspacing="0" width="100%" summary="Kontakt">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="top" style="border-left: 1px #000000 solid; border-right: 1px #000000 solid; border-bottom: 1px #000000 solid; padding: 15px;" align="left">\r\n$report_message\r\n<form enctype="multipart/form-data" action="contact.php" method="POST">\r\n  \r\n  <table border="0" summary="Eingabefelder" cellpadding="2" cellspacing="0" width="100%">\r\n  <tr>\r\n  <td valign="middle" width="100"><b>Ihre EMail:</b></td>\r\n  <td valign="top"><input type="text" name="email" value="$_POST[email]" size="30"></td>\r\n  <td rowspan="3" valign="top" width="20">&nbsp;</td>\r\n  <td rowspan="3" valign="top">Dieses Formular soll es Ihnen ermöglichen, mit uns direkt in Kontakt zu treten, wenn Sie Fragen, Anregungen und Sonstiges an uns direkt richten möchten.<br><br>\r\n\r\nWenn Sie über, für uns interessante Inhalte verfügen, dann verwenden Sie bitte das Formular auf der entsprechenden Themenseite. (Bsp. Tipps - "Tipp hinzufügen")<br><br>\r\n\r\nDes weiteren möchten wir Sie bitten, den Kontakt möglichst über das <a href="http://www.coder-treff.de" target="_blank"><b>Forum</b></a> zu suchen.<input type="hidden" name="send" value="yes"></td>\r\n </tr>\r\n <tr>\r\n  <td valign="middle"><b>Betreff:</b></td>\r\n  <td valign="top"><input type="text" name="subject" value="$_POST[subject]" size="30"></td>\r\n </tr>\r\n <tr>\r\n  <td valign="top"><b>Nachricht:</b></td>\r\n  <td valign="top"><textarea name="message" rows="15" cols="40">$_POST[message]</textarea></td>\r\n </tr>\r\n <tr>\r\n  <td valign="middle"><b>Dateianhang:</b><br>(max. $upload_max_filesize)</td>\r\n  <td valign="middle" colspan="3"><input type="file" name="attachment" name="attachment" value="" size="30"></td>\r\n </tr>\r\n <tr>\r\n  <td valign="middle" colspan="4" align="left"><input type="submit" name="" value="Absenden" style="text-align: center;"></td>\r\n </tr></form>\r\n </table>\r\n  \r\n  </td>\r\n </tr>\r\n </table><br><br>'),
(9, 'contact_error', 1, '<div style="color: #880000;"><b>Die Nachricht konnte nicht versendet werden!</b></div>\r\nIhre Angaben waren fehlerhaft!<br>\r\nBitte geben Sie Ihre EMail, eine Nachricht sowie einen Betreff an.'),
(10, 'contact_success', 1, '<div style="color: #006600;"><b>Die Nachricht konnte erfolgreich versendet werden!</b></div>'),
(11, 'main_top_navigation_downloads_bit', 1, '<a href="downloads.php?cat_id=$cats[id]"><img src="$cats[top_image]" border="0" alt="$cats[title]"></a>'),
(12, 'main_top_navigation_articles_bit', 1, '<a href="articles.php?cat_id=$cats[id]"><img src="$cats[top_image]" border="0" alt="$cats[title]"></a>'),
(13, 'main_top_navigation_faq_bit', 1, '<a href="faq.php?cat_id=$cats[id]"><img src="$cats[top_image]" border="0" alt="$cats[title]"></a>'),
(14, 'main_top_navigation_links_bit', 1, '<a href="links.php?cat_id=$cats[id]"><img src="$cats[top_image]" border="0" alt="$cats[title]"></a>'),
(16, 'main_subnavigation', 1, '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="180" summary="Subnavigation">\r\n <tr height="25">\r\n  <td bgcolor="#A7BFDB" valign="middle" style="border-left: 1px #000000 solid; padding-left: 5px; padding: 5px; border-bottom: 1px #000000 solid; border-right: 1px #000000 solid;">\r\n  $main_subnavigation_bit<br>\r\n\r\n  <a href="http://www.coder-treff.de" target="_blank"><b>Forum</b></a></td>\r\n </tr>\r\n </table>'),
(17, 'main_subnavigation_bit', 1, '<a href="$site.php?cat_id=$subcats[id]">$subcats[title]</a><br>');
