<?
Class Client_main {
  function show() {
    XML::from_db('SELECT * FROM main',array(),'main',null);
    return XML::get_dom();
  }
}
