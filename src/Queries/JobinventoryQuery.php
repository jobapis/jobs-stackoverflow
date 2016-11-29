<?php namespace JobApis\Jobs\Client\Queries;

class JobinventoryQuery extends AbstractQuery
{
    /**
     * q
     *
     * The search query.
     *
     * @var string
     */
    protected $q;

    /**
     * l
     *
     * The search location.
     *
     * @var string
     */
    protected $l;

    /**
     * limit
     *
     * Number of results per page
     *
     * @var integer
     */
    protected $limit;

    /**
     * p
     *
     * Page
     *
     * @var integer
     */
    protected $p;

    /**
     * radius
     *
     * Miles away to search
     *
     * @var integer
     */
    protected $radius;

    /**
     * t
     *
     * Job title.
     *
     * @var string
     */
    protected $t;

    /**
     * company
     *
     * @var string
     */
    protected $company;

    /**
     * date
     *
     * Number of days back to search.
     *
     * @var integer
     */
    protected $date;

    /**
     * jobtype
     *
     * Valid options include:
     *  Full-time
     *  Contract
     *  Part-time
     *  Temporary
     *  Seasonal
     *
     * @var string
     */
    protected $jobtype;

    /**
     */

    /**
     * education
     *
     * Valid options include:
     *  Professional
     *  High School
     *  Doctorate
     *  Associate's Degree
     *  Some College
     *  Bachelor's Degree
     *
     * @var string
     */
    protected $education;

    /**
     * c
     *
     * Category (see website for options).
     *
     * @var string
     */
    protected $c;

    /**
     * o
     *
     * Job source (see website for options).
     *
     * @var string
     */
    protected $o;

    /**
     * experience
     *
     * Experience required (see website for options).
     *
     * @var string
     */
    protected $experience;

    /**
     * Get baseUrl
     *
     * @return  string Value of the base url to this api
     */
    public function getBaseUrl()
    {
        return 'http://www.jobinventory.com/rss';
    }

    /**
     * Get keyword
     *
     * @return  string Attribute being used as the search keyword
     */
    public function getKeyword()
    {
        return $this->q;
    }

    /**
     * Required parameters
     *
     * @return array
     */
    protected function requiredAttributes()
    {
        return [
            'q',
        ];
    }
}
