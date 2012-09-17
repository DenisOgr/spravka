<?
Class Xml {
	private static $dom,$root,$header_xml=true;
	/**
	 * Совмещение xml и xsl
	 *
	 * @param string $xsl_filename
	 * @param mixed $xml (либо в виде строки, либо объект DOM)   *
	 * @return object DOMDocument
	 */

	public static function transform($root_tag_name=false,$xsl_filename, $xml=null, $debug=false) {

		$xml=self::protect_xml($xml);		
		if (defined('DEBUG') && DEBUG==1) {
			//$debug_file=str_replace('/','_',$xsl_filename);
			self::debug($xml,$xsl_filename);
		}
		if ($debug) {
			self::debug($xml);
		}

		/* load the xml file and stylesheet as domdocuments */
		$xsl = new DomDocument();
		$xsl->load($xsl_filename.'.xsl');

		/* create the processor and import the stylesheet */
		$proc = new XsltProcessor();
		$xsl = $proc->importStylesheet($xsl);
		//$proc->setParameter(null, "titles", "Titles");
		$proc->registerPHPFunctions();
		/* transform and output the xml document */
		$newdom = $proc->transformToDoc($xml);
		self::DOM_destroy();

		if ($root_tag_name) {
			$root_node=self::create_DOMDocument($root_tag_name);
			XML::add_node(false,false,$newdom);
			$newdom=self::$dom;
			self::DOM_destroy();
		}

		return $newdom;
	}


	static function get_dom() {
		$xml=self::$dom;
		self::DOM_destroy();
		return $xml;
	}


	/**
	 * Проверка XML на корректность (должен быть либо не пустой строкой, либо объектом DOMDocument, либо существует внутренний объект DOM)
	 *
	 * @param unknown_type $xml
	 */
	private static function protect_xml($xml=null) {
		if (!is_null($xml)) {
			if (!($xml instanceof DOMDocument)) {
				if (is_string($xml) && $xml!='') {
					$inputdom = new DomDocument();
					$inputdom->loadXML($xml);
					$xml=$inputdom;
				}else{
					var_dump($xml);
					die('некорректный XML');
				}
			}
		} else {
			if (!(self::$dom instanceof DOMDocument)) {
				//self::add_node(false,'empty',array());
				die('self::$dom not instance of DOMDocument');
			}
			$xml=&self::$dom;
		}
		return $xml;
	}

	/**
	 * Преобразование объекта DOM в строку
	 *
	 * @param object DOMDocument $dom (если null то берется внутренний self::dom)
	 * @return sring
	 */

	public static function dom2str(DOMDocument $dom=null) {
		if (is_null($dom)) {
			if (!(self::$dom instanceof DOMDocument)) {
				die('self::$dom not instance of DOMDocument');
			} else {
				$dom=&self::$dom;
			}
		}
		//header('Content-Type: application/xml');
		$str=$dom->saveXML();
		unset($dom);
		$str=preg_replace('/<\?.+\?>/','',$str);
		//return $str;
		$str=trim(str_replace('<![CDATA[','//<![CDATA[',$str));
		return trim(str_replace(']]>','//]]>',$str));
	}

	/**
	 * Метод для дебага, определяет выводить или нет хидер XML
	 *
	 * @param bool $value
	 */
	public function header($value) {
		self::$header_xml=$value;
	}

	/**
	 * Вывод xml в файл или на экран
	 *
	 * @param mixed $xml (либо в виде строки, либо объект DOM, если null то берется внутренний self::dom)
	 * @param string $filename (если отсутствует, то выводит на экран)
	 */

	public static function debug($xml=null,$filename=null) {
		$xml=self::protect_xml($xml);
		$xml->formatOutput = true;
		if (is_string($filename)) {
			$xml->save(XML.basename($filename).'.xml');
		} else {
			if (self::$header_xml) {
				header('Content-Type: application/xml');
			}
			echo $xml->saveXML();
			die();
		}
	}


	/**
	 * Добавление в DOM данных из БД
	 *
	 * @param string $query запрос к БД
	 * @param array $params массив данных для подстановки в запрос
	 * @param string $root_tag_name название корневого тэга для DOM если он еще не создан
	 * @param string $row_tag_name газвание тэга для каждой строки выборки
	 */

	public static function from_db($query, $params = array(), $root_tag_name=false, $row_tag_name=false) {
		$root_db=self::create_DOMDocument($root_tag_name);
		$db = new Db;
		$res= $db->query($query, $params);
		while ($row=$db->fetch($res)) {
			self::add_array($row,$root_db,$row_tag_name);
		}
	}

	/**
	 * Добавление в DOM набора данных (массив, пустой тэг)
	 *
	 * @todo  Добавить возможность передачи на вход массива DOM документов либо строк
	 *
	 * @param string $tag_name название корневого тэга для добавляемых данных
	 * @param mixed $value добавляемые данные
	 * @param string $root_tag_name название корневого тэга для DOM если он еще не создан
	 */

	public static function add_node($root_tag_name=false, $tag_name=false) {
		$root_node=self::create_DOMDocument($root_tag_name);

		$num_args=func_num_args();
		if ($num_args>2) {
			for ($i=2; $i<$num_args; $i++) {
				$value=func_get_arg($i);
				if (is_string($value)) {
					if ($tag_name) {
						$tag_node=self::create_DOMElement(self::$dom,$tag_name);
					} else {
						$tag_node=&$root_node;
					}
					self::create_DOMElement(self::$dom,$tag_node,$value);
				} elseif (is_array($value)) {
					self::add_array($value,$root_node,$tag_name);
				} elseif ($value instanceof DOMDocument) {
					self::create_DOMElement(self::$dom, $tag_name, $value);
				}
			}
		} elseif($tag_name) {
			$root_node=self::create_DOMElement(self::$dom,$tag_name);
		}
	}

	/**
	 * Публичный метод для добавления в DOM данных из массива
	 *
	 * @param array $array Добавляемый массив
	 * @param string $root_tag_name название корневого тэга для DOM если он еще не создан
	 */

	public static function from_array($array, $root_tag_name=false, $row_tag_name=false){
		$root_array=self::create_DOMDocument($root_tag_name);
		self::add_array($array, $root_array, $row_tag_name);
	}

	/**
	 * Уничтожение внутреннего объекта DOMDocument и объекта DOMELement, ссылающегося на корневой тэг
	 *
	 */
	public static function DOM_destroy() {
		self::$dom=self::$root=null;
	}


	/**
	 * Приватный метод рекурсивного добавление в DOM массива
	 *
	 * @param unknown_type $array
	 * @param DOMElement $in_node
	 * @param unknown_type $tag_name
	 */

	private static function add_array($array, DOMElement $root_tag_name, $row_tag_name=null) {

		if (!is_null($row_tag_name)) {
			self::protect_tag($row_tag_name);
			$root_tag_name = $root_tag_name->appendChild(self::$dom->createElement($row_tag_name));
		}

		if (!is_null($array)) {
			foreach ($array as $key => $value) {

				if ($value instanceof DOMDocument) {
					self::create_DOMElement(self::$dom, $root_tag_name, $value);
				} else {
					$corr_key=$key;
					self::protect_tag($corr_key);
					$node = self::$dom->createElement($corr_key);
					if (is_array($value)){
						$node->setAttribute('id',$key);
						self::add_array($array[$key], $node);
					} else {
						if (!is_numeric($value)) {
							$value=stripslashes($value);
							// $value=htmlspecialchars($value); ??? проверить делается ли это по умолчанию при в createTextNode
						}
						$nodeText = self::$dom->createTextNode($value);
						$node->appendChild($nodeText);
					}
					$root_tag_name->appendChild($node);
				}
			}
		}
	}


	/**
	 * Добавление узла или другого DOM
	 *
	 * @todo  Добавить возможность передачи на вход массива DOM документов либо строк
	 *
	 * @param DOMElement $in_node объект DOM к торому ьудут добавлены данные
	 * @param string $tag_name название корневого тэга для добавляемых данных
	 * @param mixed $value добавляемые данные
	 * @return DOMElement
	 */
	private static function create_DOMElement(DOMDocument $dom=null, $tag_name=false, $value = false) {
		if (is_null($dom)) {
			$root_tag=self::create_DOMDocument($tag_name);
			$dom=&self::$dom;
		} else {
			if ($tag_name instanceof DOMElement) {
				$root_tag=&$tag_name;
			} elseif ($tag_name) {
				self::protect_tag($tag_name);
				$root_tag=self::get_tag($dom,$tag_name);
				if (is_null($root_tag)) {
					$root_tag=self::get_tag($dom)->appendChild($dom->createElement($tag_name));
				}
			} else {
				$root_tag=self::get_tag($dom);
			}
		}

		if ($value instanceof DOMDocument) { // @todo брать не первый корневой тэг, а все корневые тэги для импорта
			if (!self::$header_xml) {
				self::debug($value);
			}
			$root_tag->appendChild($dom->importnode(self::get_tag($value), true));
		} elseif (is_string($value)) {
			$root_tag->appendChild($dom->createTextNode($value));
		}
		return $root_tag;
	}

	private static function get_tag(DOMDocument $dom, $tag_name='*'){
		return $dom->getElementsByTagName($tag_name)->item(0);
	}

	/**
	 * Создание либо получение ссылки на внутренний объект DOM
	 *
	 * @param string $root_tag_name название корневого тэга для DOM если он еще не создан
	 * (если внутренний DOM существует то создать ребенка у корневого тэга и вренуть ссылку на него)
	 * (если на вход ничего не продано а DOM существует, то просто вернуть линк на корневой тэг)
	 * @return object DOMDocument
	 */

	static function create_DOMDocument($root_tag_name=false) {
		if (!(self::$dom instanceof DOMDocument)) {
			self::protect_tag($root_tag_name,'root');
			self::$dom = new DOMDocument('1.0', 'UTF-8');
			self::$root=self::$dom->appendChild(self::$dom->createElement($root_tag_name));
			return self::$root;
		}elseif ($root_tag_name) {
			self::protect_tag($root_tag_name);
			$new_root_tag=self::get_tag(self::$dom,$root_tag_name);
			if (is_null($new_root_tag)) {
				$new_root_tag=self::$root->appendChild(self::$dom->createElement($root_tag_name));
			}
			return $new_root_tag;
		} else {
			return self::$root; // вернуть линк на корневой тэг, т.к. внутренний DOM существует
		}
	}

	/**
	 * Защита названия тэгов (недопустимо создание тэга название которого является не строкой или пустой строкой)
	 *
	 * @param unknown_type $tag_name проверяемое имя тэга, может быть подан любой тип данных
	 * @param unknown_type $default_name значение по умолчанию, на которое будет заменено название тэга
	 * если он не пройдет проверку, если же значение по умолчанию также не проходит проверку то тэг будет называться 'node'
	 *
	 */
	private static function protect_tag(&$tag_name, $default_name=false) {
		if (!is_string($tag_name) || $tag_name=='' || is_numeric($tag_name)) {
			(!is_string($default_name) || $default_name=='' || is_numeric($default_name))
			? $tag_name='node'
			: $tag_name=$default_name;
		}
	}
}
?>