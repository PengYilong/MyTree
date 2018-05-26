The tree class
Generate tree structure which could be any. 

 [![Latest Stable Version](https://poser.pugx.org/yilongpeng/tree/v/stable)](https://packagist.org/packages/yilongpeng/tree)


## Installation

Use [composer](http://getcomposer.org) to install yilong/mysql in your project:
```
composer require yilongpeng/tree
```


## Usage
```php
use tree\Tree;

$class = new Tree();
$class->init($data, array('id'=>'id','pid'=>'parentid'));
$result = $class->get_tree(0, 0, "<option value=\$id \$selected>\$spacer\$name</option>");
// $result = '<select>'.$result.'</select>';
// $result = $class->get_path(10, $str = "<a href='#'>\$catename</a>>");
// $result = $class->get_treeview(0);
print_r($result);
```