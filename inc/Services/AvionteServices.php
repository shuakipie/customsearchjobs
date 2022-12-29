<?php


namespace Igj\Inc\Services;

use GuzzleHttp\Exception\ClientException;
use Igj\Inc\Traits\ConsumeExternalService as ConsumeExternalService;

class AvionteServices
{

    use ConsumeExternalService;


    public function __construct()
    {

    }

    public function getJobs(){
        return $this->makeRequest(
            'POST',
            '/staff/jsonjobsv3.aspx',
            [
                "ID" => "cXXXKMAk9/7tAYbYs//Nlg==",
                "proc" => "getalljobs"
            ],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            true
        );
    }

    public function getSingleJob($id){
        return $this->makeRequest(
            'POST',
            '/staff/jsonjobsv3.aspx',
            [
                "ID" => "cXXXKMAk9/7tAYbYs//Nlg==",
                "proc" => "getsinglejob",
                "postid" => $id
            ],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            true
        );
    }

}