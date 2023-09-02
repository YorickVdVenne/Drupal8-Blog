<?php

namespace Drupal\blog_detailpage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines BlogDetailpageController class.
 */
class BlogDetailpageController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  
  public function content() {

    // Roles parameters out of the URL.
    $id = \Drupal::request()->query->get('id'); 
    
    // Validation
    if (empty($id)) {
      echo "Please fill in your roles!";
      exit();
    }

    else{
    // Getting the node ids of the articles with the matching role names 
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1)
        ->condition('nid', $id)
        ->condition('type', 'blog'); //content type
      $nid = $query->execute();

      // Validation
      if (!empty($nid)) {
        // Getting all the data from the node with the matching node id
        $blog = \Drupal\node\Entity\Node::load($id);

        $blog_data = $blog->toArray();
          $fileUri = $blog->field_blog_image->entity->getFileUri();
          $blog_data['field_blog_image'] = file_create_url($fileUri);
          $response[] = $blog_data;

        return new JsonResponse($response);
      }
      else {
        echo "This role is not recognized, please fill in a valid role!";
        exit();
      }
      
    }
  }
}
