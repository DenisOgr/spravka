-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 27 2007 г., 12:24
-- Версия сервера: 4.1.18
-- Версия PHP: 5.1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `1x_sapr`
-- 

-- --------------------------------------------------------
-- 
-- Структура таблицы `links_exchange_sections`
-- 

CREATE TABLE `links_exchange_sections` (
  `id` int(11) NOT NULL auto_increment,
  `id_parent` int(11) default NULL,
  `level` int(11) NOT NULL default '1',
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- 
-- Структура таблицы `links_exchange_partners`
-- 

CREATE TABLE `links_exchange_partners` (
  `id` int(11) NOT NULL default '0',
  `id_section` int(11) NOT NULL default '0',
  `id_page` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `image` text NOT NULL,
  `email` varchar(50) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

