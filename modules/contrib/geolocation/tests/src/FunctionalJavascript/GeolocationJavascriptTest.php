<?php

namespace Drupal\Tests\geolocation\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase;
use Drupal\views\Tests\ViewTestData;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\Core\Entity\Entity\EntityFormDisplay;

use Zumba\GastonJS\Exception\JavascriptError;

/**
 * Tests the JavaScript functionality.
 *
 * @group geolocation
 */
class GeolocationJavascriptTest extends JavascriptTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'node',
    'field',
    'views',
    'views_test_config',
    'geolocation',
    'geolocation_test_views',
  ];

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['geolocation_test'];

  /**
   * Filter the missing key GoogleMapsAPI error.
   *
   * @param mixed $path
   *   Path to get.
   *
   * @return string Return what drupal would.
   *   Return what drupal would.
   *
   * @throws \Zumba\GastonJS\Exception\JavascriptError
   */
  protected function drupalGetFilterGoogleKey($path) {
    try {
      $this->drupalGet($path);
      $this->getSession()->getDriver()->wait(1000, '1==2');
    }
    catch (JavascriptError $e) {
      foreach ($e->javascriptErrors() as $errorItem) {
        if (strpos((string) $errorItem, 'MissingKeyMapError') !== FALSE) {
          continue;
        }
        else {
          throw $e;
        }
      }
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->drupalCreateContentType(['type' => 'article', 'name' => 'Article']);

    // Add the geolocation field to the article content type.
    FieldStorageConfig::create([
      'field_name' => 'field_geolocation_test',
      'entity_type' => 'node',
      'type' => 'geolocation',
    ])->save();
    FieldConfig::create([
      'field_name' => 'field_geolocation_test',
      'label' => 'Geolocation',
      'entity_type' => 'node',
      'bundle' => 'article',
    ])->save();

    EntityFormDisplay::load('node.article.default')
      ->setComponent('field_geolocation_test', [
        'type' => 'geolocation_googlegeocoder',
      ])
      ->save();

    EntityViewDisplay::load('node.article.default')
      ->setComponent('field_geolocation_test', [
        'type' => 'geolocation_map',
        'weight' => 1,
      ])
      ->save();

    $this->container->get('views.views_data')->clear();

    ViewTestData::createTestViews(get_class($this), ['geolocation_test_views']);

    $entity_test_storage = \Drupal::entityTypeManager()->getStorage('node');
    $entity_test_storage->create([
      'id' => 1,
      'title' => 'foo bar baz',
      'body' => 'test test',
      'type' => 'article',
      'field_geolocation_test' => [
        'lat' => 52,
        'lng' => 47,
      ],
    ])->save();
    $entity_test_storage->create([
      'id' => 2,
      'title' => 'foo test',
      'body' => 'bar test',
      'type' => 'article',
      'field_geolocation_test' => [
        'lat' => 53,
        'lng' => 48,
      ],
    ])->save();
    $entity_test_storage->create([
      'id' => 3,
      'title' => 'bar',
      'body' => 'test foobar',
      'type' => 'article',
      'field_geolocation_test' => [
        'lat' => 54,
        'lng' => 49,
      ],
    ])->save();
  }

  /**
   * Tests the CommonMap style.
   */
  public function testCommonMap() {
    $this->drupalGetFilterGoogleKey('geolocation-test');

    $this->assertSession()->statusCodeEquals(200);

    $this->assertSession()->elementExists('css', '.geolocation-common-map-container');
    $this->assertSession()->elementExists('css', '.geolocation-common-map-locations');

    // If Google works, either gm-style or gm-err-container will be present.
    $this->assertSession()->elementExists('css', '.geolocation-common-map-container [class^="gm-"]');
  }

  /**
   * Tests the GoogleMap formatter.
   */
  public function testGoogleMapFormatter() {
    $this->drupalGetFilterGoogleKey('node/3');
    $this->assertSession()->statusCodeEquals(200);


    $this->assertSession()->elementExists('css', '.geolocation-google-map');

    // If Google works, either gm-style or gm-err-container will be present.
    $this->assertSession()->elementExists('css', '.geolocation-google-map [class^="gm-"]');
  }

  /**
   * Tests the GoogleMap formatter.
   */
  public function testGeocoderWidget() {
    $admin_user = $this->drupalCreateUser([
      'bypass node access',
      'administer nodes',
    ]);
    $this->drupalLogin($admin_user);

    $this->drupalGetFilterGoogleKey('node/3/edit');
    $this->assertSession()->statusCodeEquals(200);

    $this->assertSession()->elementExists('css', '.geolocation-map-canvas');

    // If Google works, either gm-style or gm-err-container will be present.
    $this->assertSession()->elementExists('css', '.geolocation-map-canvas [class^="gm-"]');
  }

}
