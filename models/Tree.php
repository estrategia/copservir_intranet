<?php 
/**
* 
*/
namespace app\models;

class Tree
{
  private $root;

  public function getRoot()
  {
    return $this->root;
  }

  public function setRoot($root)
  {
    $this->root = $root;
  }

  public function isEmpty()
  {
    return is_null($this->root);
  }

  public function numberOfNodes($root)
  {
    $count = 0;
    $count ++;
    if ($root->numberOfChildren() != 0) {
      foreach ($root->getChildren() as $children) {
        $count = $count + $this->numberOfNodes($children);
      }
    }
    return $count;
  }

  public function numberOfNodesInTree()
  {
    return $this->numberOfNodes($this->root);
  }

  public function searchNodeById($id, $startNode = null)
  {
    $node = null;
    $root = $this->root;
    if (!is_null($startNode)) {
      $root = $startNode;
    }

    if (!$root->hasChildren()) {
      return $node;
    }

    if ($root->getId() == $id) {
      return $root;
    }

    $queue = [$root];
    while (!empty($queue)) {
      $currentNode = array_shift($queue);
      foreach ($currentNode->getChildren() as $child) {
        if ($child->getId() == $id) {
          return $child;
        }
      }
    }

    return $node;
  }

  public function insertDataArrayAsChildrenById($id, $dataArray, $property)
  {
    $node = $this->searchNodeById($id);
    if (!is_null($node)) {
      $node->insertDataArrayAsChildren($dataArray, $property);
      return true;
    }
    return false;
  }

} 

?>