<?php
/**
 *  Pull jobs from Greenhouse API
 */

/**
 * API request
 *
 * @return mixed|string
 */
function greenhouse_api_request()
{
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.greenhouse.io/v1/boards/recogni/embed/jobs?content=true');
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    } catch (Exception $e) {
        return $e->getMessage();
    }

}

/**
 * Set positions from Greenhouse to transient field
 *
 * @param $positions
 */
function storeGreenhousePostions($positions)
{
    // Get any existing copy of our transient data
    if (false === ($greenhouse_data = get_transient('greenhouse_positions'))) {
        // It wasn't there, so regenerate the data and save the transient for 2 hours
        $greenhouse_data = serialize($positions);
        set_transient('greenhouse_positions', $greenhouse_data, 2 * HOUR_IN_SECONDS);
    }
}

/**
 * Get positions from Greenhouse
 *
 * @return array|mixed
 */
function get_greenhouse_positions()
{
    // Get any existing copy of our transient data
    if (false === ($greenhouse_data = get_transient('greenhouse_positions'))) {
        // It wasn't there, so make a new API Request and regenerate the data
        $result = greenhouse_api_request();
        $positions = isset($result['jobs']) && !empty($result['jobs']) ? $result['jobs'] : array();
        if (!empty($positions)) {
            $greenhouse_data = array();
            foreach ($positions as $item) {
                $departments = array();
                $offices = array();
                if (!empty($item['departments'])) {
                    foreach ($item['departments'] as $department) {
                        $departments[] = trim($department['name']);
                    }
                }
                if (!empty($item['offices'])) {
                    foreach ($item['offices'] as $office) {
                        $offices[] = trim($office['name']);
                    }
                }
                $greenhouse_position = array(
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'updated_at' => $item['updated_at'],
                    //'content' => $item['content'],
                    'departments' => implode(', ', $departments),
                    'offices' => implode(', ', $offices)
                );
                array_push($greenhouse_data, $greenhouse_position);
            }
        }
        // Cache the Response
        storeGreenhousePostions($greenhouse_data);
    } else {
        // Get any existing copy of our transient data
        $greenhouse_data = unserialize(get_transient('greenhouse_positions'));
    }
    // Finally return the data

    return $greenhouse_data;
}

/**
 * Get all offices from all positions
 *
 * @return array
 */
function get_greenhouse_locations()
{
    $locations = array();
    $positions = get_greenhouse_positions();

    if ($positions != '') {
        foreach ($positions as $position) {
            if (!empty($position['offices'])) {
                $position_offices = explode(', ', $position['offices']);
                foreach ($position_offices as $office) {
                    $locations[] = $office;
                }
            }
        }

        $locations = array_unique($locations);
        sort($locations);
    }

    return $locations;
}

/**
 * Get all departments from all positions
 *
 * @return array
 */
function get_greenhouse_departments()
{
    $departments = array();
    $positions = get_greenhouse_positions();

    if ($positions != '') {
        foreach ($positions as $position) {
            if (!empty($position['departments'])) {
                $position_departments = explode(', ', $position['departments']);
                foreach ($position_departments as $department) {
                    $departments[] = $department;
                }
            }
        }

        $departments = array_unique($departments);
        sort($departments);
    }

    return $departments;
}

/**
 * Get position data by position id
 *
 * @param false $position_id
 * @return array|mixed
 */
function get_greenhouse_details($position_id = false)
{
    $positions = get_greenhouse_positions();

    if ($positions != '') {
        foreach ($positions as $item) {
            if ($position_id == $item['id']) {
                return $item;
            }
        }
    }

    return array();
}

/**
 * Setup job details page
 *
 */
//Add a wp query variable to redirect to
add_action('query_vars', 'set_query_new_var');
function set_query_new_var($vars)
{
    array_push($vars, 'job_page');
    array_push($vars, 'gh_jid');
    return $vars;
}

//Create a redirect
add_action('init', 'custom_add_rewrite_rule');
function custom_add_rewrite_rule()
{
    add_rewrite_rule('^careers/position$', 'index.php?job_page=1', 'top');
}

//Return the page template
add_filter('template_include', 'plugin_include_template');
function plugin_include_template($template)
{
    if (get_query_var('job_page')) {
        $template = locate_template(array('templates/job-details.php'));
    }
    return $template;
}

//Set noindex to meta robots for virtual page
add_filter('wpseo_robots', 'filter_wpseo_robots', 1, 1);
function filter_wpseo_robots_utm($robots_str)
{
    if (get_query_var('job_page')) {
        $robots_str = 'noindex, nofollow';
    }
    return $robots_str;
}