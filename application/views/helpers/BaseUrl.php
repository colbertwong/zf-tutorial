<?php
/**
 * Created by PhpStorm.
 * User: colbe
 * Date: 2018/2/25
 * Time: 18:11
 */

class Zend_View_Helper_BaseUrl
{
    public function baseUrl()
    {
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl();
    }
}