<?php namespace JobApis\Jobs\Client\Providers;

use JobApis\Jobs\Client\Job;

class StackoverflowProvider extends AbstractProvider
{
    /**
     * Returns the standardized job object
     *
     * @param array $payload
     *
     * @return \JobApis\Jobs\Client\Job
     */
    public function createJobObject($payload)
    {
        $job = new Job([
            'description' => $payload['description'],
            'location' => $payload['location'],
            'name' => $payload['title'],
            'title' => $payload['title'],
            'url' => $payload['link'],
        ]);

        // Set date posted
        $job->setDatePostedAsString($payload['pubDate']);

        // Set skills
        if (isset($payload['category']) && is_array($payload['category'])) {
            $skills = [];
            foreach ($payload['category'] as $category) {
                $skills[] = $category;
            }
            $job->setSkills(implode(', ', $skills));
        }

        return $job;
    }

    /**
     * Job response object default keys that should be set
     *
     * @return  array
     */
    public function getDefaultResponseFields()
    {
        return [
            'description',
            'link',
            'location',
            'pubDate',
            'title',
        ];
    }

    /**
     * Get format
     *
     * @return  string Currently only 'json' and 'xml' supported
     */
    public function getFormat()
    {
        return 'xml';
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath()
    {
        return 'channel.item';
    }
}
