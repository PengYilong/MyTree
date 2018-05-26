<?php
include './Loader.php';
spl_autoload_register('Loader::_autoload');

//load data
$data = include './data/data3.php';

//init
$class = new tree\Tree($data, array('id'=>'id','pid'=>'parentid'));

//usage
$result = $class->get_tree(0, 0, "<option value=\$id \$selected>\$spacer\$name</option>");
// $result = '<select>'.$result.'</select>';
// $result = $class->get_path(10, $str = "<a href='#'>\$catename</a>>");
// $result = $class->get_treeview(0);
print_r($result);
