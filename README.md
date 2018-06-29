a tree class
==============

Generates tree structure which could be any. 

## Installation

Use [composer](http://getcomposer.org) to install yilong/mytree in your project:
```
composer require yilongpeng/mytree
```


## Usage
```php
use Nezumi\MyTree;

$class = new MyTree();
$class->init($data, array('id'=>'id','pid'=>'parentid'));
$result = $class->get_tree(0, 0, "<option value=\$id \$selected>\$spacer\$name</option>");
// $result = '<select>'.$result.'</select>';
// $result = $class->get_path(10, $str = "<a href='#'>\$catename</a>>");
// $result = $class->get_treeview(0);
print_r($result);
```