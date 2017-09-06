<?php

require_once('PHPUnit/Extensions/AppiumTestCase.php');
require_once('PHPUnit/Extensions/AppiumTestCase/Element.php');

class Test extends PHPUnit_Extensions_AppiumTestCase
{
    public static $browsers = array(
        array(
            'host' => '0.0.0.1',
            'port' => 4722,
            'browserName' => 'Chrome',
            'desiredCapabilities' => array(
                'platformName' => 'Android',
                'deviceName' => 'testavd'
            )
        )
    );

    public function test()
    {
        $element = $this->byAccessibilityId('Element on screen');

        $this->assertInstanceOf('PHPUnit_Extensions_AppiumTestCase_Element', $element);
    }
}
