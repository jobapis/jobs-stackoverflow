<?php namespace JobApis\Jobs\Client\Providers\Test;

use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\Job;
use JobApis\Jobs\Client\Providers\JobinventoryProvider;
use JobApis\Jobs\Client\Queries\JobinventoryQuery;
use Mockery as m;

class JobinventoryProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = m::mock('JobApis\Jobs\Client\Queries\JobinventoryQuery');

        $this->client = new JobinventoryProvider($this->query);
    }

    public function testItCanGetDefaultResponseFields()
    {
        $fields = [
            'title',
            'link',
            'description',
            'pubDate',
        ];
        $this->assertEquals($fields, $this->client->getDefaultResponseFields());
    }

    public function testItCanGetListingsPath()
    {
        $this->assertEquals('channel.item', $this->client->getListingsPath());
    }

    public function testItCanGetFormat()
    {
        $this->assertEquals('xml', $this->client->getFormat());
    }

    public function testItCanCreateJobObjectWhenLocationAndCompanyNotSet()
    {
        $payload = $this->createJobArray();

        $this->query->shouldReceive('get')
            ->twice()
            ->andReturn(null);

        $results = $this->client->createJobObject($payload);

        $this->assertInstanceOf(Job::class, $results);
        $this->assertEquals($payload['title'], $results->getTitle());
        $this->assertEquals($payload['title'], $results->getName());
        $this->assertEquals($payload['description'], $results->getDescription());
        $this->assertEquals($payload['link'], $results->getUrl());
    }

    public function testItCanCreateJobObjectWhenLocationSet()
    {
        $location = uniqid();
        $payload = $this->createJobArray();

        $this->query->shouldReceive('get')
            ->with('l')
            ->once()
            ->andReturn($location);
        $this->query->shouldReceive('get')
            ->with('company')
            ->once()
            ->andReturn(null);

        $results = $this->client->createJobObject($payload);

        $this->assertInstanceOf(Job::class, $results);
        $this->assertEquals($payload['title'], $results->getTitle());
        $this->assertEquals($payload['title'], $results->getName());
        $this->assertEquals($payload['description'], $results->getDescription());
        $this->assertEquals($payload['link'], $results->getUrl());
        $this->assertEquals($location, $results->getLocation());
    }

    public function testItCanCreateJobObjectWhenCompanySet()
    {
        $company = uniqid();
        $payload = $this->createJobArray();

        $this->query->shouldReceive('get')
            ->with('company')
            ->once()
            ->andReturn($company);
        $this->query->shouldReceive('get')
            ->with('l')
            ->once()
            ->andReturn(null);

        $results = $this->client->createJobObject($payload);

        $this->assertInstanceOf(Job::class, $results);
        $this->assertEquals($payload['title'], $results->getTitle());
        $this->assertEquals($payload['title'], $results->getName());
        $this->assertEquals($payload['description'], $results->getDescription());
        $this->assertEquals($payload['link'], $results->getUrl());
        $this->assertEquals($company, $results->getCompany());
    }

    /**
     * Integration test for the client's getJobs() method.
     */
    public function testItCanGetJobs()
    {
        $options = [
            'q' => uniqid(),
            'l' => uniqid(),
            't' => uniqid(),
        ];

        $guzzle = m::mock('GuzzleHttp\Client');

        $query = new JobinventoryQuery($options);

        $client = new JobinventoryProvider($query);

        $client->setClient($guzzle);

        $response = m::mock('GuzzleHttp\Message\Response');

        $jobs = $this->createXmlResponse();

        $guzzle->shouldReceive('get')
            ->with($query->getUrl(), [])
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($jobs);

        $results = $client->getJobs();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertCount(2, $results);
    }

    /**
     * Integration test with actual API call to the provider.
     */
    public function testItCanGetJobsFromApi()
    {
        if (!getenv('REAL_CALL')) {
            $this->markTestSkipped('REAL_CALL not set. Real API call will not be made.');
        }

        $keyword = 'engineering';

        $query = new JobinventoryQuery([
            'q' => $keyword,
        ]);

        $client = new JobinventoryProvider($query);

        $results = $client->getJobs();

        $this->assertInstanceOf('JobApis\Jobs\Client\Collection', $results);

        foreach($results as $job) {
            $this->assertEquals($keyword, $job->query);
        }
    }

    private function createJobArray()
    {
        return [
            'title' => uniqid(),
            'link' => uniqid(),
            'description' => uniqid(),
            'pubDate' => '2015-'.rand(1,12).'-'.rand(1,31).' 00:48:39',
        ];
    }

    private function createXmlResponse()
    {
        return "<?xml version='1.0' encoding='UTF-8' ?><rss version='2.0'><channel><title>Hotel Jobs in Chicago, IL // JobInventory.com</title><item><title>Hotel Specialist Agents</title><link>http://www.jobinventory.com/d/Hotel-Specialist-Agents-Jobs-Chicago-IL-1391153840.html</link><description>Full-time/Regular 9:00 AM to 6:00 PM. 40 hours per week. (Overtime as required) The <b>hotel</b> ... Specialist Agents would pre pay all <b>hotel</b> rooms and help support the reservations team. JOB OVERVIEW work</description><pubDate>2015-04-11 00:48:39</pubDate></item><item><title>Maintenance_Hourly1</title><link>http://www.jobinventory.com/d/Maintenance_hourly1-Jobs-Chicago-IL-1583775509.html</link><description>Data not provided</description><pubDate>2016-05-17 18:13:26</pubDate></item></channel></rss>";
    }
}
