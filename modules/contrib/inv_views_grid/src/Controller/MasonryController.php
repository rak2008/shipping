<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 1/10/2016
 * Time: 11:26 AM
 */

namespace Drupal\inv_views_grid\Controller;


use Drupal\Core\Controller\ControllerBase;

class MasonryController {
    public function save($view, $item, $width, $height) {
        $result = db_select('inv_masonry', 'm')
            ->fields('m')
            ->condition('view', $view, '=')
            ->condition('item', $item, '=')
            ->execute()
            ->fetchAssoc();
        if ($result) {
            db_update('inv_masonry')
                ->fields(array(
                    'width' => $width,
                    'height' => $height,
                ))
                ->condition('view', $view, '=')
                ->condition('item', $item, '=')
                ->execute();
        } else {
            db_insert('inv_masonry')
                ->fields(array(
                    'view' => $view,
                    'item' => $item,
                    'width' => $width,
                    'height' => $height,
                ))
                ->execute();
        }
        return array();
    }
}