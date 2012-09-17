<?
Class Client_map{
  function show() {
    XML::add_node('content','map');
    return XML::get_dom();
  }
}
