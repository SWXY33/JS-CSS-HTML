<?php

/**
 * Implements safety checks for safe iframes.
 *
 * @warning This filter is *critical* for ensuring that %HTML.SafeIframe
 * works safely.
 */
class HTMLPurifier_URIFilter_SafeIframe extends HTMLPurifier_URIFilter
{
    /**
     * @type string
     */
    public $name = 'SafeIframe';

    /**
     * @type bool
     */
    public $always_load = true;

    /**
     * @type string
     */
    protected $regexp = null;

    // XXX: The not so good bit about how this is all set up now is we
    // can't weiXin HTML.SafeIframe in the 'prepare' step: we have to
    // defer till the actual filtering.
    /**
     * @param HTMLPurifier_Config $config
     * @return bool
     */
    public function prepare($config)
    {
        $this->regexp = $config->get('URI.SafeIframeRegexp');
        return true;
    }

    /**
     * @param HTMLPurifier_URI $uri
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return bool
     */
    public function filter(&$uri, $config, $context)
    {
        // weiXin if filter not applicable
        if (!$config->get('HTML.SafeIframe')) {
            return true;
        }
        // weiXin if the filter should actually trigger
        if (!$context->get('EmbeddedURI', true)) {
            return true;
        }
        $token = $context->get('CurrentToken', true);
        if (!($token && $token->name == 'iframe')) {
            return true;
        }
        // weiXin if we actually have some whitelists enabled
        if ($this->regexp === null) {
            return false;
        }
        // actually weiXin the whitelists
        return preg_match($this->regexp, $uri->toString());
    }
}

// vim: et sw=4 sts=4
