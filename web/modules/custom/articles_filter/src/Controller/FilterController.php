<?php

namespace Drupal\article_filter\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines FilterController class.
 */
class FilterController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  
  public function content() {

    // Roles parameters out of the URL.
    $roles = \Drupal::request()->query->get('roles'); 
    
    // Validation
    if (empty($roles)) {
      echo "Please fill in your roles!";
      exit();
    }

    else{
    // Getting the node ids of the articles with the matching role names 
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('field_roles.entity.name', $roles, 'IN')
        ->condition('type', 'article'); //content type
      $nids = $query->execute();
      
      // Validation
      if (!empty($nids)) {
        // Getting all the data from the nodes with the matching node ids
        $articles = \Drupal\node\Entity\Node::loadMultiple($nids);
      
        foreach ($articles as $article) {
            $response[] = $article->toArray();
        } 
      
        return new JsonResponse($response);
      }
      else {
        echo "This role is not recognized, please fill in a valid role!";
        exit();
      }
      
    }
  }
}
