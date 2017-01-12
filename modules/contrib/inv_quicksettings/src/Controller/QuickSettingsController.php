<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 1/10/2016
 * Time: 11:26 AM
 */

namespace Drupal\inv_quicksettings\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;

class QuickSettingsController {
    public function view($preset) {
		if (!empty($preset)) {
			$_SESSION['innovation_default_preset'] = $preset - 1;
			$config =\Drupal::service('config.factory')->getEditable('innovation.settings');
			$config->set('updated', true);
			$config->save();
		}
		$destination = isset($_GET['destination'])?$_GET['destination']:'<front>';
		return new RedirectResponse(\Drupal::url($destination));
    }
}