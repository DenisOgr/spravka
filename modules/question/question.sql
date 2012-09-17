-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Авг 27 2007 г., 15:57
-- Версия сервера: 4.1.18
-- Версия PHP: 5.1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Структура таблицы `guest`
-- 


CREATE TABLE `question` (
  `id` bigint(20) NOT NULL auto_increment,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `email` varchar(100) default NULL,
  `name` varchar(100) default NULL,
  `visible` tinyint(1) NOT NULL default '0',
  `phone` varchar(50) default NULL,
  `id_section` int(11) default NULL,
  `who_answered` varchar(255) NOT NULL default '',
  `date_answered` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `user` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

