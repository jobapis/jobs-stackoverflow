<?php namespace JobApis\Jobs\Client\Test;

use JobApis\Jobs\Client\Queries\JobinventoryQuery;
use Mockery as m;

class JobinventoryQueryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = new JobinventoryQuery();
    }

    public function testItCanGetBaseUrl()
    {
        $this->assertEquals(
            'http://www.jobinventory.com/rss',
            $this->query->getBaseUrl()
        );
    }

    public function testItCanGetKeyword()
    {
        $keyword = uniqid();
        $this->query->set('q', $keyword);
        $this->assertEquals($keyword, $this->query->getKeyword());
    }

    public function testItReturnsFalseIfRequiredAttributesMissing()
    {
        $this->assertFalse($this->query->isValid());
    }

    public function testItReturnsTrueIfRequiredAttributesPresent()
    {
        $this->query->set('q', uniqid());

        $this->assertTrue($this->query->isValid());
    }

    public function testItCanAddAttributesToUrl()
    {
        $this->query->set('q', uniqid());
        $this->query->set('l', uniqid());

        $url = $this->query->getUrl();

        $this->assertContains('q=', $url);
        $this->assertContains('l=', $url);
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItThrowsExceptionWhenSettingInvalidAttribute()
    {
        $this->query->set(uniqid(), uniqid());
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItThrowsExceptionWhenGettingInvalidAttribute()
    {
        $this->query->get(uniqid());
    }

    public function testItSetsAndGetsValidAttributes()
    {
        $attributes = [
            'q' => uniqid(),
            'l' => uniqid(),
            'radius' => rand(1,100),
        ];

        foreach ($attributes as $key => $value) {
            $this->query->set($key, $value);
        }

        foreach ($attributes as $key => $value) {
            $this->assertEquals($value, $this->query->get($key));
        }
    }
}
