-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 27 2007 г., 13:11
-- Версия сервера: 4.1.18
-- Версия PHP: 5.1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `options`
-- 

CREATE TABLE `options` (
  `id` int(11) NOT NULL auto_increment,
  `id_section` int(11) NOT NULL default '0',
  `key` varchar(100) NOT NULL default '',
  `value` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;