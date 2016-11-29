<?php namespace JobApis\Jobs\Client\Queries;

class StackoverflowQuery extends AbstractQuery
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
     * pg
     *
     * Page number
     *
     * @var integer
     */
    protected $pg;

    /**
     * d
     *
     * Distance from location
     *
     * @var integer
     */
    protected $d;

    /**
     * sort
     *
     * Sort order. Should be one of the following:
     *  "p" = newest
     *  "i" = match
     *  "y" = salary
     *
     * @var string
     */
    protected $sort;

    /**
     * u
     *
     * Unit of distance ("Miles" is the only option I've seen)
     *
     * @var string
     */
    protected $u;

    /**
     * tl
     *
     * Technology liked
     *
     * @var string
     */
    protected $tl;

    /**
     * td
     *
     * Technology disliked
     *
     * @var string
     */
    protected $td;

    /**
     * s
     *
     * Minimum salary
     *
     * @var integer
     */
    protected $s;

    /**
     * c
     *
     * Currency (eg: USD)
     *
     * @var string
     */
    protected $c;

    /**
     * e
     *
     * Offers equity (eg: "true")
     *
     * @var boolean
     */
    protected $e;

    /**
     * r
     *
     * Offers remote (eg: "true")
     *
     * @var boolean
     */
    protected $r;

    /**
     * v
     *
     * Offers Visa sponsorship (eg: "true")
     *
     * @var boolean
     */
    protected $v;

    /**
     * t
     *
     * Offers Relocation (eg: "true")
     *
     * @var boolean
     */
    protected $t;

    /**
     * ms
     *
     * Minimum experience
     *
     * @var string
     */
    protected $ms;

    /**
     * mxs
     *
     * Max experience
     *
     * @var string
     */
    protected $mxs;

    /**
     * j
     *
     * Job type:
     *  "permanent"
     *  "contract"
     *
     * @var string
     */
    protected $j;

    /**
     * cl
     *
     * Companies to include
     *
     * @var string
     */
    protected $cl;

    /**
     * cd
     *
     * Companies to exclude
     *
     * @var string
     */
    protected $cd;

    /**
     * i
     *
     * Industry
     *
     * @var string
     */
    protected $i;

    /**
     * Get baseUrl
     *
     * @return  string Value of the base url to this api
     */
    public function getBaseUrl()
    {
        return 'https://stackoverflow.com/jobs/feed';
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
}
