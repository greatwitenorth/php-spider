<?php
namespace VDB\Spider\Filter\Prefetch;

use VDB\Spider\Filter\PreFetchFilter;
use VDB\Spider\Uri\FilterableUri;
use VDB\Uri\Http;
use VDB\Uri\UriInterface;

/**
 * @author matthijs
 */
class RestrictExtensions implements PreFetchFilter
{
    private $ext = array();

    /**
     * @param array $ext
     */
    public function __construct($ext)
    {
        $this->ext = array_map('strtolower', $ext);
    }

    public function match(FilterableUri $uri)
    {
        /*
         * if the URI does not contain the seed, it is not allowed
         */
        $ext = pathinfo(parse_url($uri->toString(),PHP_URL_PATH),PATHINFO_EXTENSION);

        if (in_array(strtolower($ext), $this->ext)) {
            $uri->setFiltered(true, 'On restricted extension list');
            return true;
        }

        return false;
    }
}
