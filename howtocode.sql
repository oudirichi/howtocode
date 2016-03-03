-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 03 Mars 2016 à 11:01
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `howtocode`
--

-- --------------------------------------------------------

--
-- Structure de la table `info_category`
--

CREATE TABLE IF NOT EXISTS `info_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `info_category`
--

INSERT INTO `info_category` (`id`, `name`, `link`, `icon`, `description`) VALUES
(1, 'HTML5', 'html5', 'fa fa-4x fa-html5', ''),
(2, 'CSS3', 'css3', 'fa fa-4x fa-css3', ''),
(3, 'PHP', 'php', 'fa-5x icon-php', ''),
(4, 'c/c++', 'c', 'fa fa-4x fa-code', ''),
(5, 'Gestion de l''ordi', 'gestion-ordinateur', 'fa fa-4x fa-laptop', ''),
(6, 'factorisation', 'algorithme', 'fa fa-4x fa-recycle', 'Cette section est réservée à l''apprentissage de base et non spécifique a un langage et écrit en pseudo code. Vous trouverez aussi des algorithmes que vous pourrez facilement adapter à plusieurs langages.'),
(7, 'Assembleur (8x86)', 'assembleur', 'fa fa-4x fa-terminal', ''),
(8, 'Base de donnée', 'base-de-donnee', 'fa fa-4x fa-database', '');

-- --------------------------------------------------------

--
-- Structure de la table `info_formations`
--

CREATE TABLE IF NOT EXISTS `info_formations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `slug` varchar(255) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `publication` date NOT NULL,
  `modification` date NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `info_formations`
--

INSERT INTO `info_formations` (`id`, `title`, `content`, `slug`, `online`, `publication`, `modification`, `id_category`) VALUES
(1, 'dessin de forme 2D', '<h3 class="titre1">Pyramide</h3>', 'forme-2d', 1, '2015-12-09', '0000-00-00', 6),
(2, '01 - Introduction au php', '<p>Pour commencer à faire du PHP, vous avez de besoin d''un minimum de connaissance en HTML et CSS, puisque le PHP est un langage complémentaire. Celui-ci peut être remplacé par plusieurs autres langages, par exemple le Ruby.</p>\r\n\r\n<p>Vous aurez besoin d''un navigateur (google chrome ou firefox préférablement). D''un éditeur de texte (sublime text, notepad++, etc). Pour ma part, je préfère de loin sublime text puisque nous pouvons ajouter des packages pour le rendre beaucoup plus performant. Pour finir, un interpréteur de PHP qui est Apache. Pour se faire, vous devez installer l''un des logiciels suivait : </p>\r\n\r\n<ul>\r\n<li>WAMP : Pour windows de base, celui que je préfère.</li>\r\n<li>MAMP : </li>\r\n<li>XAMP : </li>\r\n<li>easyphp?</li>\r\n</ul>', 'introduction-php', 1, '0000-00-00', '0000-00-00', 3),
(3, '02 - Les variables', '', '', 0, '0000-00-00', '0000-00-00', 3),
(4, '03 - Les conditions, boucles et autres', '<h3 class="titre1">Introduction</h3>\r\n<p>Parfois, il faut afficher des informations, mais seulement <strong>SI</strong> une condition est vrai ou encore, afficher un message <strong>TANT QUE</strong> une variable n''a pas atteint la valeur voulue.</p>\r\n\r\n<h3 class="titre1">Opérateurs</h3>\r\n<p>Avant d''entrer dans le sujet, il est important de connaître comment écrire les et/ou et vérifier si une valeur est égale a une autre, mais comment l''écrire?</p>\r\n<table class="table table-striped">\r\n    <thead>\r\n         <tr>\r\n              <th>Syntaxe</th><th>Autre méthode</th><th>Traduction</th>\r\n         </tr>\r\n    </thead>\r\n    <tbody>                                  \r\n               <tr><td>&amp;&amp;</td><td>AND</td><td>et</td></tr>\r\n               <tr><td>||</td><td>OR</td><td>ou</td></tr>\r\n               <tr><td>&lt;</td><td></td><td>plus petit</td></tr>\r\n               <tr><td>&lt;=</td><td></td><td>plus petit ou égal</td></tr>\r\n               <tr><td>&gt;</td><td></td><td>plus grand</td></tr>\r\n               <tr><td>&gt;=</td><td></td><td>plus grand ou égal</td></tr>\r\n               <tr><td>==</td><td></td><td>égal à</td></tr>\r\n               <tr><td>!=</td><td></td><td>non égal</td></tr>\r\n               <tr><td>===</td><td></td><td>égal et de même type</td></tr>\r\n    </tbody>\r\n</table>\r\n\r\n<h3 class="titre1">Les conditions</h3>\r\n<p>Les conditions sont l''un des éléments les plus important en programmation et en web. Par exemple, vous créez une section administrateur et vous ne voulez pas que les gens puissent y aller, mais comment faire? Avec des conditions!</p>\r\n\r\n<p>Une chose très importante avant d''utiliser une variable et l''afficher est de vérifier si la variable existe vraiment. PHP a intégrer la fonction : isset() pour nous aider.</p>\r\n<pre>\r\n<code>\r\n&lt;?php\r\n/*1 comme vous vous en rappeler, 1 est toujours vrai, alors il passe dans la condition*/\r\nif(1){\r\n   echo ''&lt;p&gt;Bonjour le monde&lt;/p&gt;'';\r\n}\r\n\r\n//Et les variables? \r\n\r\n$animal=''chat'';\r\nif(isset($nom) && $nom==''chat''){\r\n  echo ''&lt;p&gt;BEURK, un chat!&lt;/p&gt;'';\r\n}else{\r\n  echo ''&lt;p>c\\''est un ''.$animal.''!&lt;/p&gt;'';\r\n}\r\n?&gt;\r\n</code>\r\n</pre>\r\n\r\n<h3 class="titre2">Méthode condensé</h3>\r\n<p>Il peut être utile d''écrire des if else en une seule ligne et garder une certaine lisibilité, voici comment :</p>\r\n<pre>\r\n<code>\r\n&lt;?php\r\n   $value = (1) ? true : false ;\r\n\r\n//voici un cas concret \r\n?&gt; \r\n&lt;li class="&lt;?php echo (isset($page==''lien'') ? ''active'' : '''' ;?&gt; element"&gt;Un lien&lt;/li&gt;\r\n\r\n//si c''est vrai :\r\n    &lt;li class="active element"&gt;Un lien&lt;/li&gt;\r\n//sinon : \r\n    &lt;li class="element"&gt;Un lien&lt;/li&gt;\r\n</code>\r\n</pre>\r\n<h3 class="titre1">Les boucles</h3>\r\n<p>Les boucles ont plusieurs utilités. Parcourir un tableau, afficher un nombre de fois un élément ou encore afficher ce que vous avez récupéré dans votre base de donnée. Il y a deux méthodes de faire les boucles.</p>\r\n<h3 class="titre2">pour</h3>\r\n<p>Plus utile lorsqu''on sait combien d''élément vous devez afficher et de combien vous voulez le déplacer</p>\r\n<pre>\r\n<code>\r\n&lt;?php\r\n     for($i=5;$i>=0;$i--){\r\n          echo ''voici le nombre : ''.$i.''&lt;br&gt;'';\r\n     }\r\n?&gt; \r\n</code>\r\n</pre>\r\n\r\n<h3 class="titre2">tant que/fait tant que</h3>\r\n<p>Le while seul valide et si c''est bon, il le fait, à l''inverse, le do while fait puis vérifie s''il doit le refaire.</p>\r\n<pre>\r\n<code>\r\n&lt;?php\r\n     $i=5;\r\n\r\n     while($i>=0)\r\n     {\r\n          echo ''voici le nombre : ''.$i.''&lt;br&gt;'';\r\n          $i--;\r\n     }\r\n\r\n\r\n     $i=5;\r\n     do{\r\n          echo ''voici le nombre : ''.$i.''&lt;br&gt;'';\r\n          $i--;\r\n     }while($i>=0)\r\n?&gt; \r\n</code>\r\n</pre>\r\n<h3 class="titre1">Les switch</h3>\r\n<p>Les switch sont un if, mais plus spécifique et plus "lisible". Le default est le else, si il ne passe pas dans un des case, il va dans celui-ci.</p>\r\n\r\n<pre>\r\n<code>\r\n&lt;?php\r\n     $i=5;\r\n\r\n     switch ($i) {\r\n		case 1:\r\n			echo ''Le nombre est 1'';\r\n			break;\r\n		case 5:\r\n			echo ''Le nombre est 5'';\r\n			break;\r\n		\r\n		default:\r\n			echo ''Le nombre est ni 1 ni 5!'';\r\n			break;\r\n	}\r\n?&gt; \r\n</code>\r\n</pre>', 'conditions', 1, '0000-00-00', '0000-00-00', 3),
(5, '04 - Les tableaux', '<h3 class="titre1">Introduction</h3>\r\n<p>Les tableaux en PHP sont très pratique, puisque, comme les variables, ils peuvent accueillir n''importe quel type de variable. Vous pouvez y mettre un bool, un int, un char et même des objets dans un même tableau.</p>\r\n\r\n<h3 class="titre1">tableaux simples</h3>\r\n<p>Il a plusieurs méthodes en PHP pour initialiser des tableaux et d''y ajouter des vauleurs.</p>\r\n\r\n<pre>\r\n<code>\r\n&lt;?php\r\n$tab=array(1,2,3);\r\n$tab1=[1,2,3];\r\n?&gt;\r\n</code>\r\n</pre>\r\n\r\n<h3 class="titre1">Tableaux associatifs</h3>\r\n<h3 class="titre1"></h3>', 'les-tableaux', 1, '0000-00-00', '0000-00-00', 3);

-- --------------------------------------------------------

--
-- Structure de la table `info_tutoriels`
--

CREATE TABLE IF NOT EXISTS `info_tutoriels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `slug` varchar(255) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `publication` date NOT NULL,
  `modification` date NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `info_tutoriels`
--

INSERT INTO `info_tutoriels` (`id`, `title`, `content`, `slug`, `online`, `publication`, `modification`, `id_category`) VALUES
(6, 'un tutoriel', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'un-tutoriel', 1, '2016-02-24', '2016-02-24', 3),
(7, 'dgdf', '<p>xvxcvdfs</p>', 'dgdf', 0, '0000-00-00', '0000-00-00', 1),
(8, 'gdfg fdg', '<p>cvbc</p>', 'gdfg-fdg', 0, '0000-00-00', '0000-00-00', 2),
(9, 'dgsdg', '<p>dgfdgdf</p>', 'dgsdg', 0, '0000-00-00', '0000-00-00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `admin`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`) VALUES
(5, 0, 'allo', 'allo@allo.com', '$2y$10$P0pgH0M0N.nwOghD5oBaO.ypaxed.MQ5NUhecT2Ajlxk2OubyA2u6', NULL, '2016-02-20 23:00:02', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
