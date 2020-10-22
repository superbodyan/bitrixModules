<?php
namespace superBIT;

trait cURL
{
    protected function initPostRequest($params)
    {
        $ch = curl_init($params['URL']);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params['FIELDS']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        return curl_exec($ch);
    }
}