-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 27 2007 г., 13:57
-- Версия сервера: 4.1.18
-- Версия PHP: 5.1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `1x_palitra`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `gallery`
-- 

CREATE TABLE `gallery` (
  `id` bigint(20) NOT NULL auto_increment,
  `id_section` int(11) NOT NULL default '0',
  `text` varchar(255) NOT NULL default '',
  `extension` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

