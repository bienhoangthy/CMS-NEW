<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mhistory extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_history";
}
