<?php

namespace Drupal\product_page\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines ProductController class.
 */
class ProductController extends ControllerBase {

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
    if ($roles == null) {
        echo "Please fill in your roles!";
        exit();
    }
    else if ($roles[0] == "") {
        echo "Please fill in a valid role!";
        exit();
    }
    else{
    // Getting the node ids of the articles with the matching role names 
        $query = \Drupal::entityQuery('node')
            ->condition('status', 1)
            ->condition('field_roles.entity.name', $roles, 'IN')
            ->condition('type', 'products'); //content type
        $nids = $query->execute();

        // Validation
        if (empty($nids)) {
            echo "This role is not recognized, please fill in a valid role!";
            exit();
        }
        // Getting all the data from the nodes with the matching node ids
        $products = \Drupal\node\Entity\Node::loadMultiple($nids);

        foreach ($products as $product) {
            $response[] = $product->toArray();
        } 
    
        return new JsonResponse($response);
    }

    }
}

 //  _______--------------------SKETCH CODE--------------------_______
  
  // Getting all the requested Taxonomy term ids out of the database.
  // $tids = array();
  // $query = \Drupal::entityQuery('taxonomy_term')
  //   ->condition('vid', "roles")
  //   ->condition('name', $roles, 'IN');
  // $tids = $query->execute();


  // $database = \Drupal::database();
  // $query = $database->query('SELECT nid FROM {node} WHERE type = :article',
  // [':article' => 'article'])
  // $result = $query->fetchField();
  // var_dump($result);


  // public function content() {
  //   return new JsonResponse(
  //     [
  //       'data' => $this->getResults(),
  //       'method' => 'GET',
  //     ]
  //     );

  //   }

  //   private function getResults() {
      
  //     $query = \Drupal::entityQuery('node')
  //       ->condition('status', 1) //published or not
  //       ->condition('type', 'article') //content type
  //       ->pager(10); //specify results to return
  //     $nids = $query->execute();
  
  //     $articles = \Drupal\node\Entity\Node::loadMultiple($nids);
  
  //     return ($articles);
  //   }
    
    
    // $body = $node->body->value;
    // $title = $node->title->value
    // $nids = \Drupal::service('database')->query('SELECT nid FROM {node} WHERE type = :article', [':article' => 'article'])->fetchCol();
  // $articles = \Drupal\node\Entity\Node::loadMultiple($nids);
  
  // $select = Database::getConnection()->select('articles', 'a');
  // $select->addField('a', 'title');
  // $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
  // console.log($entries);
  // return $entries;
    
  // }

  // public function articles() {
  //   $content = array();
  //   $content['message'] = array(
  //     '#markup' => $this->t('Below is a list of all the articles.'),
  //   );
  //   $headers = array(
  //     t('Title'),
  //     t('Body'),
  //   );
  //   $rows = array();
  //   foreach ($entries = $this->content() as $entry) {
  //     $rows[] = array_map('Drupal\Component\Utility\SafeMarkup::checkPlain', $entry);
  //   }
  //   $content['table'] = array(
  //     '#type' => 'table',
  //     '#header' => $headers,
  //     '#rows' => $rows,
  //     '#empty' => t('No entries available'),
  //   );
  //   $content['#cache']['max-age'] = 0;
  //   return $content;

    // return $articles;



    // $response = array();
    //     $nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple();
    //     foreach ($nodes as $node) {
    //         $response[] = $node->toArray();
    //     }
    //     return ($response);




    
    // $query = \Drupal::entityQuery('node')
    // ->condition('status', 1);
    
    // $nids = $query->execute();
    // $nodes = entity_load_multiple('node', $nids);

    // if (isset($nodes['node'])) {
    //   $artciles_items_nids = array_keys($nodes['node']);
    //   $articles_items = entity_load('node', $articles_items_nids);
    // }

    // $output = "<ul>\n";
    // foreach($articles_items as $articles_item){
    //   $snippet = "<li>\n";
    //   $snippet .= "<h2>".t($articles_items->title)."</h2>\n";
    //   $snippet .= "<p>".t(substr($articles_items->body['und'][0]['value'],0,600))."</p>\n";
    //   $snippet .= "</li>\n";
    //   $output .= $snippet;
    // }
    // $output .= "</ul>\n";

    // return $output;