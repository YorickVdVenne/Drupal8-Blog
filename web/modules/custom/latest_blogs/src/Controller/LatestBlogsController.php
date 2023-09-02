<?php

namespace Drupal\latest_blogs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines LatestBlogsController class.
 */
class LatestBlogsController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  
  public function content() { 


    // Getting the node ids of the latest 6 blogs out of database 
      $query = \Drupal::entityQuery('node')
        ->condition('status', 1) // published
        ->condition('type', 'blog') //content type
        ->sort('field_blog_date', 'DESC') // sort by date
        ->pager(6); // only show 6
      $nids = $query->execute();
      
      // Validation
      if (!empty($nids)) {
        // Getting all the data from the nodes with the matching node ids
        $blogs = \Drupal\node\Entity\Node::loadMultiple($nids);
      
        foreach ($blogs as $blog) {
          $blog_data = $blog->toArray();
          $fileUri = $blog->field_blog_image->entity->getFileUri();
          $blog_data['field_blog_image'] = file_create_url($fileUri);
          $response[] = $blog_data;
        } 
      
        return new JsonResponse($response);
      }
      else {
        echo "Something went wrong!";
        exit();
      }
    
  }
}
