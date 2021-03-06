<?php

namespace Drupal\sms\Tests;

use Drupal\Core\Url;
use Drupal\sms\Entity\SmsMessage;
use Drupal\sms\Direction;

/**
 * Integration tests for the SMS Framework.
 *
 * @group SMS Framework
 */
class SmsFrameworkWebTest extends SmsFrameworkWebTestBase {

  /**
   * Tests queue statistics located on Drupal report page.
   */
  public function testQueueReport() {
    /** @var \Drupal\sms\Provider\SmsProviderInterface $provider */
    $provider = \Drupal::service('sms.provider');

    /** @var \Drupal\sms\Entity\SmsMessageInterface $sms_message */
    $sms_message = SmsMessage::create();
    $sms_message
      ->setMessage($this->randomString())
      ->addRecipients($this->randomPhoneNumbers());

    for ($i = 0; $i < 2; $i++) {
      $clone = $sms_message->createDuplicate()
        ->setDirection(Direction::INCOMING);
      $provider->queue($clone);
    }
    for ($i = 0; $i < 4; $i++) {
      $clone = $sms_message->createDuplicate()
        ->setDirection(Direction::OUTGOING);
      $provider->queue($clone);
    }

    $this->drupalLogin($this->rootUser);
    $this->drupalGet(Url::fromRoute('system.status'));

    $this->assertRaw('There are 2 messages in the incoming queue.');
    $this->assertRaw('There are 4 messages in the outgoing queue.');
  }

}
