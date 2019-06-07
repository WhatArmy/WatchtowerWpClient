<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-07
 * Time: 16:03
 */

namespace WhatArmy\Watchtower;

use \WP_REST_Request as WP_REST_Request;
use \WP_REST_Response as WP_REST_Response;

class Api
{
    protected $access_token;

    const API_VERSION = 'v1';
    const API_NAMESPACE = 'wht';

    /**
     * Api constructor.
     */
    public function __construct()
    {
        $this->access_token = get_option('watchtower')['access_token'];

        add_action('rest_api_init', function () {
            $this->routes();
        });
    }

    /**
     * Routing List
     */
    private function routes()
    {
        register_rest_route($this->route_namespace(), 'test', $this->resolve_action('test_action'));
    }

    public function test_action(WP_REST_Request $request)
    {
        $core = new Core;
        return $this->make_response($core->test());
    }

    private function make_response($data = [], $status_code = 200)
    {
        $response = new WP_REST_Response($data);
        $response->set_status($status_code);

        return $response;
    }


    /**
     * @param  \WP_REST_Request  $request
     * @return bool
     */
    public function check_permission(WP_REST_Request $request)
    {
        return $request->get_param('access_token') == $this->access_token;
    }

    /**
     * @param $callback
     * @param  string  $method
     * @return array
     */
    private function resolve_action($callback, $method = 'POST')
    {
        return array(
            'methods'             => $method,
            'callback'            => [$this, $callback],
            'permission_callback' => [$this, 'check_permission']
        );
    }

    private function route_namespace()
    {
        return join('/', [self::API_NAMESPACE, self::API_VERSION]);
    }
}