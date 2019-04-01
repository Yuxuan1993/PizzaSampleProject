<?php
// Functions to do the base web services needed
// Note that all needed web services are sent from this day directory
// The functions here should throw up to their callers, just like
// the functions in model.
//
// Post day number to server
// Returns if successful, or throws if not
function post_day($httpClient, $base_url, $day) {
    error_log('post_day to server: ' . $day);
    $url = $base_url . '/day/';
    $httpClient->request('POST', $url, ['json' => $day]);
}

// TODO: POST order and get back location (i.e., get new id), get all orders 
// in server and/or get a specific order by orderid

