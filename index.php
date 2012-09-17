<?
header('Content-type: text/html; charset=UTF-8');
session_start();
include 'config.php';
include ENGINE.'init.php';
$ctrl= new Client_control;
$ctrl->show();
echo str_replace(':8080','',XML::dom2str(XML::transform(null,ENGINE.'xsl/client_index')));
?>