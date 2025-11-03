<?php
/**
 * SEO Helper Class
 * Provides SEO-related functions
 */

class SEO {
    private $title = '';
    private $description = '';
    private $keywords = '';
    private $canonical = '';
    private $ogTags = [];
    private $twitterTags = [];
    private $schema = [];
    
    /**
     * Set page title
     */
    public function setTitle($title, $append = true) {
        if ($append) {
            $this->title = $title . ' | Calculator';
        } else {
            $this->title = $title;
        }
        return $this;
    }
    
    /**
     * Set meta description
     */
    public function setDescription($description) {
        $this->description = substr($description, 0, 160);
        return $this;
    }
    
    /**
     * Set meta keywords
     */
    public function setKeywords($keywords) {
        if (is_array($keywords)) {
            $keywords = implode(', ', $keywords);
        }
        $this->keywords = $keywords;
        return $this;
    }
    
    /**
     * Set canonical URL
     */
    public function setCanonical($url) {
        $this->canonical = $url;
        return $this;
    }
    
    /**
     * Set Open Graph tags
     */
    public function setOGTags($title, $description, $image = null, $url = null) {
        $this->ogTags = [
            'og:title' => $title,
            'og:description' => $description,
            'og:type' => 'website',
            'og:url' => $url ?: $this->getCurrentUrl(),
            'og:image' => $image ?: BASE_URL . '/assets/images/og-image.jpg',
            'og:site_name' => 'Calculator'
        ];
        return $this;
    }
    
    /**
     * Set Twitter Card tags
     */
    public function setTwitterTags($title, $description, $image = null) {
        $this->twitterTags = [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $title,
            'twitter:description' => $description,
            'twitter:image' => $image ?: BASE_URL . '/assets/images/twitter-card.jpg',
            'twitter:site' => '@calculator'
        ];
        return $this;
    }
    
    /**
     * Add schema markup
     */
    public function addSchema($type, $data) {
        $this->schema[] = array_merge(['@context' => 'https://schema.org', '@type' => $type], $data);
        return $this;
    }
    
    /**
     * Generate meta tags
     */
    public function generateMetaTags() {
        $html = '';
        
        // Title
        if ($this->title) {
            $html .= '<title>' . $this->escape($this->title) . '</title>' . PHP_EOL;
        }
        
        // Description
        if ($this->description) {
            $html .= '<meta name="description" content="' . $this->escape($this->description) . '">' . PHP_EOL;
        }
        
        // Keywords
        if ($this->keywords) {
            $html .= '<meta name="keywords" content="' . $this->escape($this->keywords) . '">' . PHP_EOL;
        }
        
        // Canonical
        if ($this->canonical) {
            $html .= '<link rel="canonical" href="' . $this->escape($this->canonical) . '">' . PHP_EOL;
        }
        
        // Open Graph
        foreach ($this->ogTags as $property => $content) {
            $html .= '<meta property="' . $property . '" content="' . $this->escape($content) . '">' . PHP_EOL;
        }
        
        // Twitter
        foreach ($this->twitterTags as $name => $content) {
            $html .= '<meta name="' . $name . '" content="' . $this->escape($content) . '">' . PHP_EOL;
        }
        
        // Schema
        if (!empty($this->schema)) {
            foreach ($this->schema as $schemaData) {
                $html .= '<script type="application/ld+json">' . PHP_EOL;
                $html .= json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL;
                $html .= '</script>' . PHP_EOL;
            }
        }
        
        return $html;
    }
    
    /**
     * Generate breadcrumb schema
     */
    public function generateBreadcrumb($items) {
        $listItems = [];
        
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null
            ];
        }
        
        return $this->addSchema('BreadcrumbList', ['itemListElement' => $listItems]);
    }
    
    /**
     * Generate calculator schema
     */
    public function generateCalculatorSchema($name, $description, $url) {
        return $this->addSchema('SoftwareApplication', [
            'name' => $name,
            'description' => $description,
            'url' => $url,
            'applicationCategory' => 'UtilityApplication',
            'operatingSystem' => 'Web Browser',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD'
            ]
        ]);
    }
    
    /**
     * Generate sitemap
     */
    public static function generateSitemap() {
        $db = Database::getInstance();
        $calculators = $db->fetchAll("SELECT slug, category, updated_at FROM calculators WHERE is_active = 1");
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        // Homepage
        $xml .= self::generateSitemapUrl(BASE_URL, date('Y-m-d'), 'daily', '1.0');
        
        // Calculators
        foreach ($calculators as $calc) {
            $url = BASE_URL . '/calculators/' . $calc['category'] . '/' . $calc['slug'];
            $xml .= self::generateSitemapUrl($url, $calc['updated_at'], 'monthly', '0.8');
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
    
    /**
     * Generate sitemap URL entry
     */
    private static function generateSitemapUrl($loc, $lastmod, $changefreq, $priority) {
        $xml = '  <url>' . PHP_EOL;
        $xml .= '    <loc>' . htmlspecialchars($loc) . '</loc>' . PHP_EOL;
        $xml .= '    <lastmod>' . date('Y-m-d', strtotime($lastmod)) . '</lastmod>' . PHP_EOL;
        $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
        $xml .= '    <priority>' . $priority . '</priority>' . PHP_EOL;
        $xml .= '  </url>' . PHP_EOL;
        
        return $xml;
    }
    
    /**
     * Get current URL
     */
    private function getCurrentUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Escape HTML
     */
    private function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}