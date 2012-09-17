<?

class Admin_count {

  private $count;

  function __construct () {
    $this->count = new Count();
    if (isset($_GET['view']) and $this->count->isStat()) {
      header('Location: ' . $this->count->url);
    }
  }

  function show () {
    $this->xsl = MODULES . 'count/admin_count';
    $sec = new Sections('visible="1" AND (module="articles" OR module="catalogue" OR module="catalogue1")');
    XML::from_array($sec->ar, 'stat', 'item');
    XML::from_db('SELECT a.*, b.module, IF(c.name!="",c.name,c1.name) AS name FROM section AS b, count AS a LEFT JOIN catalogue AS c ON a.item=c.id LEFT JOIN catalogue1 AS c1 ON a.item=c1.id WHERE a.section=b.id AND (b.module="catalogue" OR b.module="catalogue1") AND a.item!=0',null,'catalogue');
    return XML::transform('content', $this->xsl);
  }
}
?>