<?php 
/**
* 
*/
namespace app\models;

class Node
{
  private $data;
  private $children = [];
  private $parent = null;
  private $id;

  // function __construct($parent, $data, $children)
  // {
  //   $this->parent = $parent;
  //   $this->data = $data;
  //   $this->children = $children;
  // }  

  function __construct($id, $data)
  {
    $this->id = $id;
    $this->data = $data;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getData()
  {
    return $this->data;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function getChildren()
  {
    return $this->children;
  }

  public function getParent()
  {
    return $this->parent;
  }

  public function setParent($parent)
  {
    $this->parent = $parent;
  }

  public function numberOfChildren()
  {
    return sizeof($this->children);
  }

  public function hasChildren()
  {
    return $this->numberOfChildren() > 0;
  }

  public function setChildren($children)
  {
    foreach ($children as $child) {
      $child->setParent($this);
    }
    $this->children = $children;
  }

  public function addChildren($children)
  {
    foreach ($children as $child) {
      $child->setParent($this);
    }
    $this->children = array_merge($children);
  }

  public function insertDataArrayAsChildren($dataArray, $property)
  {
    foreach ($dataArray as $key => $data) {
      $node = new Node($data[$property], $data);
      $node->setParent($this);
      $this->children[] = $node;
      $node = null;
    }
  }

  public function addChild($child)
  {
    $child->parent = $this;
    $this->children[] = $child;
  }
} 

?>