<?php
namespace tree;

class Tree{

	public $data = array();   
	public $field = array();  // in order to different key which is not always id,pid,catename

	public $result = array(); //
	public $item = array();   //
	public $tree = '';   	  //
	public $options = '';     //select result
	public $path = array();   //path
	public $path_str = '';    //path string

	public $icon = array('│','├','└');
	public $nbsp = "&nbsp;";

	public function __construct($data, $field = array('id'=>'id','pid'=>'parentid','name'=>'catename'))
	{
		if( empty($data) ){
			$this->error = 'data is empty.';
			return false;
		}	
		$this->data = $data;
		$this->field = $field;
	}


	/**
	 * gets infinity array
	 * 
	 * @param int $pid parent id
	 * 
	 * @return array  
	 * 
	 */
	public function get_array($pid = 0)
	{
		$child = $this->get_child($pid);
		if( !empty($child) ){
			foreach ($child as $key => $value) {
				$this->result[] = $value;
				$this->get_array($arr, $value[$this->field['id']]);
			}
		}
		return $this->result;
	}


	/**
	 * gets subset of array
	 * 
	 * @param int $pid parent id
	 * 
	 * @return array
	 * 
	 */
    public function get_child($pid)
    {
    	$result = array();
		foreach ($this->data as $key => $value) {
			if($value[$this->field['pid']]==$pid){
				$result[$key] = $value;
			}
		}
    	return $result;
    }

	/**
	 *  jquery treeview theme，require treeview
	 * 
	 * @param int $pid parent id 
	 * @param string $folder_str have subset of li
	 * @param string $file_str have not subset of li
	 * 
	 * @return array
	 * 
	 */
	public function get_treeview($pid = 0, $first = 'id="category_tree" class="filetree  treeview"', $file_str = "<span class='file'>\$name</span>", $folder_str= "<span class='folder'>\$name</span>")
	{
		$child = $this->get_child($pid);
		if( !empty($child) ){
			if( $first ){
				$this->tree.= '<ul '.$first.'>';
			} else {
				$this->tree.= '<ul>';
			}
			foreach ($child as $key => $value) {
				$name = $value[$this->field['name']];
				$id = $value[$this->field['id']];
				if( $this->get_child($value[$this->field['id']]) ){
					eval("\$nstr=\"$folder_str\";");
					$this->tree.='<li>'.$nstr;
					$this->get_treeview($value[$this->field['id']], '' , $file_str, $folder_str);
				} else {
					eval("\$nstr=\"$file_str\";");
					$this->tree.='<li>'.$nstr;
				}
				$this->tree.='</li>';
			}
			$this->tree.='</ul>';
		}
		return $this->tree;
	}


	/**
	 * Generates tree structure
	 * 
	 * @param tint $pid  
	 * @param string $str format:
	 * 			e.g.："<option value=\$id \$selected>\$spacer\$name</option>"，
	 * @param int $sid default selected 
	 * 
	 * @return string all of options
	 * 
	 */
	public function get_tree($pid = 0, $str ='', $sid = 0, $adds = '')
	{
		if( empty($str) ){
			$str = "<option value=\$id \$selected>\$spacer\$name</option>";
		}
		$child = $this->get_child($pid);
		if( !empty($child) ){
			$number = 1;
			$array_number = count($child);
			foreach ($child as $key => $value) {
				$id = $value[$this->field['id']];
				extract($value);
				$selected = $id == $sid ? 'selected' : '';
				$spacer = $this->nbsp;
				$icon = $third = '';
				if( $array_number!=$number ){ //not the last item
					$icon .= $this->icon[1];
				} else {  //the last item
					$icon .= $this->icon[2]; 
				}
				$third = $adds ? $this->icon[0] : ''; //the third item
				$spacer = $adds ? $adds.$icon : '';	
				eval("\$nstr = \"$str\";");
				$this->options .= $nstr;
				$number++;
				$this->get_tree($value[$this->field['id']], $str, $sid, $adds.$third.$this->nbsp);
			}
		}	
		return $this->options;
	}

	/**
	 * gets the navigation array
	 * 
	 * @param int $pid parent id
	 * 
	 * @return array
	 * 
	 */
	public function get_path_array($pid)
	{	
		foreach ($this->data as $key => $value) {
			if( $value[$this->field['id']] == $pid ){
				$this->path[] = $value;
				$this->get_path_array($value[$this->field['pid']]);
			}
		}
		
		krsort($this->path);
		return $this->path;
	}

	/**
	 * gets own navigation array
	 * 
	 * @param int $id own id
	 * 
	 * @return array
	 * 
	 */
	public function get_path_first_array($id)
	{	
		$result = array();
		foreach ($this->data as $key => $value) {
			if( $value[$this->field['id']] == $id ){
				$result = $value;
			}
		}	
		return $result;
	}


	/**
	 * format the navigation array
	 * 
	 * @param int $pid parent id
	 * @param string $str format:
	 * 			e.g.："<option value=\$id \$selected>\$spacer\$name</option>"，
	 * 
	 * @return array
	 */
	public function get_path($id, $str = "<a href='#'>\$name</a>>")
	{
		//gets the current array
		$first_array = $this->get_path_first_array($id);
		//get the parent array
		$result = $this->get_path_array($first_array[$this->field['pid']]);
		if( !empty($result) ){
			array_push($result, $first_array); //Push the first array to $result array
			foreach ($result as $key => $value) {
				extract($value);
				eval("\$nstr = \"$str\";");
				$this->path_str .= $nstr;
			}
		}
		return $this->path_str;
	}

	public function get_error()
	{
		return $this->error;
	}

	public function __destruct()
	{

	}

}