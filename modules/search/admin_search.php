<?
Class Admin_search {
  function show() {
    XML::add_node('content','search');
    return XML::get_dom();
  }

}
