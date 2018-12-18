<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 12.09.17
 * Time: 13:57
 */

class ConfigKo
{
	private static $instance = null;
	/** @var Memcache */
	private $memcache;

	/**
	 * @param $memcache
	 * @return ConfigKo|null
	 */
	public static function init($memcache)
	{
		if (null === self::$instance)
		{
			self::$instance = new self();
		}
		self::$instance->memcache = $memcache;

		return self::$instance;
	}

	private function __clone() {}
	private function __construct() {}

	private $_active = [];
	public function getList()
	{
		if(empty($this->_active)) {
			$this->_active = [];
			$config = $this->memcache->get('configKo');
			if($config) {
				try {
					$config = unserialize($config);
				} catch (Exception $ex) {
					$config = [];
				}
			}

			if(!$config || !is_array($config)) {
				$config = [];
				$query = mysql_query('select cks.* from config_ko_settings as cks inner join config_ko_main as ckm on ckm.id = cks.main_id where ckm.is_enabled = 1');
				while ($row = mysql_fetch_array($query)) {
					$config[] = $row;
				}

				$this->memcache->set('configKo', serialize($config));
			}

			foreach ($config as $_item) {
				$this->_active[$_item['main_id']][$_item['group_id']][$_item['field_type']][] = [
					'name' 	=> $_item['field_name'],
					'value' => $_item['field_value'],
				];
			}
		}

		$stock_list = [];
		foreach ($this->_active as $_id => $stock_group) {
			$stock = $this->checkStock($stock_group);
			if(!$stock) {
				continue;
			}

			$stock_list = array_merge($stock_list, $stock);
		}

		return $stock_list;
	}

	public function invalidate()
	{
		$data = $this->memcache->get('configKo');
		if($data) {
			$this->memcache->delete('configKo');
		}

		return json_encode(['status' => '1']);
	}

	protected function checkStock($stock_group)
	{
		$stock = [];
		$current_time = time();
		$i = 0;
		$i_count = count($stock_group);
		foreach ($stock_group as $group_id => $info) {
			$i++;
			if(isset($info['datetimepicker']) && $i_count > 1) {
				$_f = $info['datetimepicker'][0]['value'];
				$_s = $info['datetimepicker'][1]['value'];

				$start_time = $_f < $_s ? $_f : $_s;
				$end_time = $_f > $_s ? $_f : $_s;
				if(($start_time > $current_time || $current_time > $end_time) && $i < $i_count) {
					continue;
				}
			}

			foreach ($info as $type => $fields) {
				foreach ($fields as $field_info) {
					switch ($type) {
						case 'array':
							$stock[$field_info['name']] = explode('|', $field_info['value']);
							break;
						//case ConfigKoSettings::TYPE_DATETIMEPICKER:
						//	$stock[$field_info['name']] = date('d.m.Y H:i:s', $field_info['value']);
						//	break;
						default:
							$stock[$field_info['name']] = $field_info['value'];
							break;
					}
				}
			}
		}

		return $stock;
	}
}