<?php

class DashboardController
{    
    public function index()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'status_code' => 200,
            'status' => 'success',
            'message' => 'ready to use different endpoints',
            'data' => []
        ]);
    }
}