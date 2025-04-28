<?php

namespace App\Libraries;

class MetaTags
{
    protected static $instance;

    // Initialize with default meta tags. These serve as fallback values.
    protected $metaTags = [
        'title'       => '',             
        'description' => 'This is the default description.', 
        'keywords'    => 'default, keywords',              
    ];

    public function __construct()
    {
        // Now assign the default title from your configuration
        $this->metaTags['title'] = config('site-title', 'Autolist');
    }

    /**
     * Get the singleton instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Set a meta tag value.
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public function set(string $key, string $value): self
    {
        // Update the key if it exists. Optionally, you could check here to
        // prevent setting an empty value if you prefer to keep the default.
        if (array_key_exists($key, $this->metaTags) && trim($value) !== '') {
            $this->metaTags[$key] = $value;
        }
        return $this;
    }

    /**
     * Get the combined page title.
     *
     * Combines the page title with the site name from config (e.g. "Home Page - Website Title").
     *
     * @return string
     */
    public function getTitle(): string
    {
        $siteTitle = config('site-title', 'Autolist');
        $pageTitle = trim($this->metaTags['title']) ?: 'Default Home Page';

        // Recommended format: "Page Title - Website Title"
        return $pageTitle . ' - ' . $siteTitle;
    }

    /**
     * Render the meta tags HTML.
     *
     * @return string
     */
    public function renderMetaTags(): string
    {
        $html = "\n";

        // Render the description meta tags if available.
        if (!empty(trim($this->metaTags['description']))) {
            $html .= "\n\t" . '<meta name="description" content="' . e($this->metaTags['description']) . '" />'
                   . "\n\t" . '<meta name="twitter:description" content="' . e($this->metaTags['description']) . '" />'
                   . "\n\t" . '<meta property="og:description" content="' . e($this->metaTags['description']) . '" />'
                   . "\n\t" . '<meta itemprop="description" content="' . e($this->metaTags['description']) . '" />';
        }

        // Render the keywords meta tag if available.
        if (!empty(trim($this->metaTags['keywords']))) {
            $html .= "\n\t" . '<meta name="keywords" content="' . e($this->metaTags['keywords']) . '" />';
        }

        $metaAppends = "\n\t" . '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'
            . "\n\t" . '<meta name="viewport" content="width=device-width, initial-scale=1">'
            . "\n\t" . '<meta http-equiv="x-ua-compatible" content="ie=edge">';

        return $html . "\t" . $metaAppends . "\n";
    }
}
