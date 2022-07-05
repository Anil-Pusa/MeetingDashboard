<?php

if (!function_exists('apiRequest')) {
    /**
     * Make a Guzzle (CURL) request to remote server for the resource.
     *
     * @return response
     */
    function apiRequest($url, $method = 'GET', $post_params)
    {
        $response = [];
        $client = new \GuzzleHttp\Client();
        try {
            if ($method == 'POST') {
                $response = $client->request('POST', $url, $post_params);
                $response = $response->getBody()->getContents();
            } else if ($method == 'POST_RETRUN_JSON') {
                $response = $client->request('POST', $url, $post_params);
                $response = $response->getBody();
            } else if ($method == 'GET') {
                $response = $client->request('GET', $url, $post_params);
                $response = $response->getBody()->getContents();
            } else if($method == 'PUT') {
                $response = $client->request('PUT', $url, $post_params);
             }
        } catch (\Exception $exception) {
            if ($method == 'POST_RETRUN_JSON') {
                return $exception->getResponse()->getBody(true);
            } else {
                // dd($exception->getCode());
                return $exception->getMessage();
            }
        }
        return $response;
    }
}