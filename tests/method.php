<?php
$data = array (
  0 =>
  array (
    'id' => '1',
    'pid' => '0',
    'catename' => '新闻',
  ),
  1 =>
  array (
    'id' => '2',
    'pid' => '0',
    'catename' => '图片',
  ),
  2 =>
  array (
    'id' => '3',
    'pid' => '1',
    'catename' => '国内新闻',
  ),
  3 =>
  array (
    'id' => '4',
    'pid' => '1',
    'catename' => '国际新闻',
  ),
  4 =>
  array (
    'id' => '5',
    'pid' => '3',
    'catename' => '北京新闻',
  ),
  5 =>
  array (
    'id' => '6',
    'pid' => '4',
    'catename' => '美国新闻',
  ),
  6 =>
  array (
    'id' => '7',
    'pid' => '2',
    'catename' => '美女图片',
  ),
  7 =>
  array (
    'id' => '8',
    'pid' => '2',
    'catename' => '风景图片',
  ),
  8 =>
  array (
    'id' => '9',
    'pid' => '7',
    'catename' => '日韩明星',
  ),
  9 =>
  array (
    'id' => '10',
    'pid' => '9',
    'catename' => '大陆明星',
  ),
);


function infinity_category($arr, $pid = 0){
	static $result = array();
	if(!empty($arr)){	
		foreach ($arr as $key => $value) {
			if($value['pid']==$pid){
				$result[] = $value;
				infinity_category($arr,$value['id']);
			}
		}	
	}
	return $result;
}

function infinity_category2($arr, $pid = 0, &$result = array()){
	// static $result = array();
	if(!empty($arr)){	
		foreach ($arr as $key => $value) {
			if($value['pid']==$pid){
				$result[] = $value;
				infinity_category2($arr,$value['id'], $result);
			}
		}	
	}
	return $result;
}

function infinity_category3($arr, $pid = 0){
	// static $result = array();
	global $result;
	if(!empty($arr)){	
		foreach ($arr as $key => $value) {
			if($value['pid']==$pid){
				$result[] = $value;
				infinity_category3($arr,$value['id']);
			}
		}	
	}
	return $result;
}


    /**
     * 当前位置
     * 
     * @param $id 菜单id
     */
    final public static function current_pos($id) {
        $menudb = pc_base::load_model('menu_model');
        $r =$menudb->get_one(array('id'=>$id),'id,name,parentid');
        $str = '';
        if($r['parentid']) {
            $str = self::current_pos($r['parentid']);
        }
        return $str.L($r['name']).' > ';
    }

// $result = infinity_category3($data);
// print_r($result);
