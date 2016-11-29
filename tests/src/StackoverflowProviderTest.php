<?php namespace JobApis\Jobs\Client\Providers\Test;

use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\Job;
use JobApis\Jobs\Client\Providers\StackoverflowProvider;
use JobApis\Jobs\Client\Queries\StackoverflowQuery;
use Mockery as m;

class StackoverflowProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = m::mock('JobApis\Jobs\Client\Queries\StackoverflowQuery');

        $this->client = new StackoverflowProvider($this->query);
    }

    public function testItCanGetDefaultResponseFields()
    {
        $fields = [
            'description',
            'link',
            'location',
            'pubDate',
            'title',
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

    public function testItCanCreateJobObject()
    {
        $payload = $this->createJobArray();

        $results = $this->client->createJobObject($payload);

        $this->assertInstanceOf(Job::class, $results);
        $this->assertEquals($payload['title'], $results->getTitle());
        $this->assertEquals($payload['title'], $results->getName());
        $this->assertEquals($payload['location'], $results->getLocation());
        $this->assertEquals($payload['description'], $results->getDescription());
        $this->assertEquals($payload['link'], $results->getUrl());
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

        $query = new StackoverflowQuery($options);

        $client = new StackoverflowProvider($query);

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

        $query = new StackoverflowQuery([
            'q' => $keyword,
        ]);

        $client = new StackoverflowProvider($query);

        $results = $client->getJobs();
        var_dump($results); exit;

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
            'location' => uniqid(),
            'description' => uniqid(),
            'pubDate' => 'Fri, '.rand(1,30).' Nov '.rand(2015, 2016).' 18:36:18 Z',
        ];
    }

    private function createXmlResponse()
    {
        return "<?xml version=\"1.0\" encoding=\"utf-8\"?><rss xmlns:a10=\"http://www.w3.org/2005/Atom\" version=\"2.0\"><channel xmlns:os=\"http://a9.com/-/spec/opensearch/1.1/\"><title>r language jobs - Stack Overflow</title><link>http://stackoverflow.com/jobs</link><description>r language jobs - Stack Overflow</description><image><url>http://cdn.sstatic.net/Sites/stackoverflow/img/favicon.ico?v=4f32ecc8f43d</url><title>r language jobs - Stack Overflow</title><link>http://stackoverflow.com/jobs</link></image><os:totalResults>832</os:totalResults><item><guid isPermaLink=\"true\">https://stackoverflow.com/jobs/117083/full-stack-engineer-sandstorm-design</guid><link>https://stackoverflow.com/jobs/117083/full-stack-engineer-sandstorm-design</link><a10:author><a10:name>Sandstorm Design</a10:name></a10:author><category>php</category><category>drupal</category><category>python</category><category>javascript</category><category>jquery</category><title>Full Stack Engineer at Sandstorm Design (Chicago, IL)</title><description>&lt;p&gt;Sandstorm Design is seeking an Full Stack Engineer to join our team!&lt;/p&gt;&lt;br /&gt;&lt;p&gt;Join a creative, collaborative and nimble team to help architect and build innovative websites and web applications.&lt;/p&gt;&lt;br /&gt;&lt;p&gt;The Full Stack Engineer is dynamic individual responsible for implementing front-end and back-end development on client websites and web applications utilizing HTML, CSS, JavaScript, jQuery, PHP, Python and other relevant programming languages. Other responsibilities include Drupal and other application architecture; server configuration; developing, maintaining and following coding standards and best practices; working with the creative and sales teams to estimate upcoming projects and proposals; staying informed of new web development trends and technologies in order to bring ideas and suggestions to current and future projects. Other duties as requested.&lt;/p&gt;&lt;br /&gt;&lt;p&gt;You&amp;rsquo;ll work in a fun, energetic environment that builds careers and makes news. Founded in 1998 by a &lt;a href=\"https://www.sandstormdesign.com/who-we-are#our-team\" rel=\"nofollow\"&gt;successful female entrepreneur&lt;/a&gt;, Sandstorm has earned nationwide recognition for being an industry leader and sustaining a track record of satisfied clients.&lt;/p&gt;&lt;br /&gt;&lt;p&gt;If this sounds like the right fit, &lt;a href=\"https://www.sandstormdesign.com/join-our-team\" rel=\"nofollow\"&gt;apply online&lt;/a&gt; or email your cover letter and resume to&amp;nbsp;jobs@sandstormdesign.com. If it&amp;rsquo;s not quite right for you, please share this opportunity with someone in your network.&lt;/p&gt;</description><pubDate>Sat, 05 Nov 2016 14:33:45 Z</pubDate><a10:updated>2016-11-05T14:33:45Z</a10:updated><location xmlns=\"http://stackoverflow.com/jobs/\">Chicago, IL</location></item><item><guid isPermaLink=\"true\">https://stackoverflow.com/jobs/128590/senior-full-stack-engineer-triggr-health</guid><link>https://stackoverflow.com/jobs/128590/senior-full-stack-engineer-triggr-health</link><a10:author><a10:name>Triggr Health</a10:name></a10:author><category>android</category><category>ios</category><category>nodejs</category><category>react-native</category><category>python</category><title>Senior Full Stack Engineer at Triggr Health (Chicago, IL)</title><description>&lt;p&gt;We are building apps on both Android and iOS, a customer-facing web application, a robust web services API, machine learning-driven analytics, and large-scale data processing. As a full-stack engineer, you must be hyper-focused on how the product impacts every patient, provider, and team member.&lt;/p&gt;</description><pubDate>Tue, 15 Nov 2016 22:59:17 Z</pubDate><a10:updated>2016-11-15T22:59:17Z</a10:updated><location xmlns=\"http://stackoverflow.com/jobs/\">Chicago, IL</location></item></channel></rss>";
    }
}
