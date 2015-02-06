<?php
/**
 * File is part of the Carbon Router package
 */

namespace Carbon\Router;

/**
 * A router for WordPress
 *
 * @package Carbon\Router
 */
class Routing
{
    /** @var Router Routing class */
    private $router;

    /**
     * Sets up router
     *
     * @param Router $router
     * @param int   $priority
     */
    public function __construct(Router $router, $priority = 200)
    {
        $this->router = $router;
        add_action('init', array($this, 'dispatch'), 0, $priority);
    }

    /**
     * Checks current route for matches stored in the Router instance and calls the callback if found
     */
    public function dispatch()
    {
        $this->router->dispatch();
    }

    /**
     * Adds a get route to a router
     *
     * @param  string   $method
     * @param  string   $route
     * @param  callable $callback
     */
    public function addRoute($method, $route, $callback)
    {
        $this->router->addRoute($method, $route, $callback);
    }

    /**
     * Respond to a request with a WordPress template and a new query
     *
     * @param string $template Path to a PHP file or a template in the current active theme
     * @param mixed  $query    Some sort of WordPress readable query variable
     * @param int    $status   Http status code
     */
    public function loadTemplate($template, $query = false, $status = 200)
    {
        $fullPath = is_readable($template);
        if (!$fullPath) {
            $template = locate_template($template);
        }
        $this->setupStatusCode($status);

        if ($query !== false) {
            $this->setupQuery($query);
        }

        if ($template !== false) {
            add_filter('template_include', function() use ($template) {
                return $template;
            });
        }
    }

    /**
     * @param int    $status   Http status code
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function setupStatusCode($status)
    {
        add_filter('status_header', function ($statusHeader, $header, $text, $protocol) use ($status) {
            $text = get_status_header_desc($status);
            $header = "$protocol $status $text";
            return $header;
        }, 10, 4);

        if ($status == 404) {
            return;
        }

        add_action('parse_query', function ($query) {
            if ($query->is_main_query()) {
                $query->is_404 = false;
            }
        });
        add_action('template_redirect', function() {
            global $wp_query;
            $wp_query->is_404 = false;
        });
    }

    /**
     * @param mixed  $query    Some sort of WordPress readable query variable
     */
    private function setupQuery($query)
    {
        add_action('do_parse_request', function() use ($query) {
            global $wp;
            if (is_callable($query)) {
                $query = call_user_func($query);
            }

            if (is_array($query)) {
                $wp->query_vars = $query;
            } elseif (!empty($query)) {
                parse_str($query, $wp->query_vars);
            } elseif ($query instanceof \WP_Query) {
                parse_str($query, $wp->query_vars);
            }
        });
    }
}
