<?php

namespace Drupal\blogs_filter\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines BlogsFilterController class.
 */
class BlogsFilterController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  
  public function content() {

    // Roles parameters out of the URL.
    $subject = \Drupal::request()->query->get('subject'); 
    
    // Validation
    if (empty($subject)) {
      echo "Please fill in a subject!";
      exit();
    }

    else{
    // Getting the node ids of the articles with the matching role names 
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('field_blog_subject.entity.name', $subject, 'IN')
        ->condition('type', 'blog'); //content type
      $nids = $query->execute();
      
      // Validation
      if (!empty($nids)) {
        // Getting all the data from the nodes with the matching node ids
        $blogs = \Drupal\node\Entity\Node::loadMultiple($nids);
      
        foreach ($blogs as $blog) {
            $response[] = $blog->toArray();
        } 
      
        return new JsonResponse($response);
      }
      else {
        echo "This subject is not recognized, please fill in a valid subject!";
        exit();
      }
      
    }
  }
}
