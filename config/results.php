<?php
return [
    'results' => [
        ////////////////////////////////////////////////////////////////////////
        // Common
        ////////////////////////////////////////////////////////////////////////

        'update_success'        => [200, 'Updated successfully'],
        'delete_success'        => [200, 'Deleted successfully'],
        'not_authorised'        => [401, 'No valid authentication credentials'],
        'forbidden'             => [403, 'Insufficient permissions to access this resource'],
        'not_found'             => [404, 'Resource does not exist'],
        'method_not_allowed'    => [405, 'Method not allowed. Must be one of: %s'],
        'invalid_content_type'  => [415, 'Request header \'Content-Type: application/json\' required'],
        'validation_fail'       => [422, 'Input validation error'],
        'required_data_missing' => [422, 'Required input missing']

        ////////////////////////////////////////////////////////////////////////
        // Application results
        ////////////////////////////////////////////////////////////////////////
    ]
];