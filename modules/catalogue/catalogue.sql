SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Структура таблицы `catalogue_anons`
-- 

CREATE TABLE `catalogue_anons` (
  `id_section` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 
-- Структура таблицы `catalogue`
-- 
CREATE TABLE `catalogue` (
  `id` int(11) NOT NULL auto_increment,
  `id_section` int(11) NOT NULL default '0',
  `name` text NOT NULL,
  `anons` text NOT NULL,
  `text` text NOT NULL,
  `price` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Структура таблицы `cat_images`
-- 

CREATE TABLE `cat_images` (
  `id` int(11) NOT NULL auto_increment,
  `id_goods` int(11) NOT NULL default '0',
  `version` int(11) NOT NULL default '0',
  `extension` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;