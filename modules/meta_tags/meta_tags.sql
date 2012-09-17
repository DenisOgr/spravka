-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 27 2007 г., 13:19
-- Версия сервера: 4.1.18
-- Версия PHP: 5.1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `meta_tags`
-- 

CREATE TABLE `meta_tags` (
  `id` int(11) NOT NULL auto_increment,
  `id_section` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `description` varchar(200) NOT NULL default '',
  `keywords` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `meta_tags`
-- 

---INSERT INTO `meta_tags` (`id`, `id_section`, `title`, `description`, `keywords`) VALUES 
---(1, 10, 'Новость', 'Описание', 'Ключевые слова, слова'),
---(2, 1, 'Мегасталь', 'Описание сайта', 'Ключевые слова');
