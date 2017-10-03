<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mposition extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_position";
}
