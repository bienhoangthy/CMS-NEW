<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class msetting extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_setting";
}
