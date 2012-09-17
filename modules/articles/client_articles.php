<?
  
Class Client_articles {
	private $db,$var;

	private $count;

	function __construct(){
		$this->db = new DB();
		$this->count = new Count();
	}

	function show($id_section) {
		$options = array();
		$tmp = $this->db->get_all('SELECT options.key, value FROM options WHERE id_section = ?',array($id_section));
		foreach ($tmp as $t) {
			$options[$t['key']] = $t['value'];
		}
		if (isset($options['anons']) && $options['anons']=='yes'){
			$this->get_anons_list($id_section);
		}
		if (isset($options['number']) && $options['number']!=''){
			$number=$options['number'];
		} else {
			$number = 'many';
		}
		
		if ($id_section==$_GET['section']){
			$count=$this->db->get_one('SELECT COUNT(*) as count FROM articles WHERE id_section=? ',array($_GET['section']));
			if ($count=='1') {
				$_GET['item']=$this->db->get_one('SELECT id as count FROM articles WHERE id_section=? ',array($_GET['section']));
			}
			if (isset($_GET['item'])) {
				$xml=$this->get_item($_GET['item']);
			} else {
				$xml=$this->get_list($id_section,$number);
			}
		}
		//XML::debug();
		return XML::get_dom();
	}

	function get_item($id) {
		Xml::add_node('list_articles','articles');
		XML::from_db('SELECT * FROM articles WHERE id=?',$id,'articles','item');
		XML::add_node('list_articles', 'count', $this->count->showSection($_GET['section']));
	}

	function get_anons_list ($id_section){
		Xml::add_node('list_articles','articles_anons');
		$q='SELECT id, id_section, title, anons, photo FROM articles WHERE id_section=?';
		XML::from_db($q,$id_section,'articles_anons','list');
		XML::add_node('list_articles', 'count', $this->count->showSection($_GET['section']));
	}

	function get_list($id_section, $number) {
		Xml::add_node('list_articles','articles');
		if ($number=='one'){
			$node='item';
			$q='SELECT * FROM articles WHERE id_section=? ORDER BY id DESC LIMIT 1';
		} else {
			$node='list';
			$q='SELECT id, title, text, anons, photo FROM articles WHERE id_section=?';
		}
		XML::from_db($q,$id_section,'articles',$node);
		XML::add_node('list_articles', 'count', $this->count->showSection($_GET['section']));
	}
}
