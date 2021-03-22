<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class ViewModel extends CI_Model {

    private $user_menu;
    private $manage_menu;

    function __construct()
    {
        parent::__construct();

        $this->user_menu = array(
            
        );

        $this->manage_menu = array(
            "Dashboard"   => array(
                "icon"  => "people",
                "link"  => "admin/users",
                "grouptext" => "Users"
            ),
            "Problem" => array(
                "icon"  => "add_to_queue",
                "link"  => "admin/problem",
                "grouptext" => "Managment"
            ),
            "Setting" => array(
                "icon"  => "settings_input_antenna",
                "link"  => "dropdown",
                "id"    => "setting_menu",
                "grouptext" => "Change Setting",
                "Product" => array(
                    "title" => "Product",
                    "link"  => "admin/product"
                ),
                "Subject" => array(
                    "title" => "Subject",
                    "link"  => "admin/subject"
                ),
                "Subject Type" => array(
                    "title" => "Subject Type",
                    "link"  => "admin/subjecttype"
                ),
                "Module" => array(
                    "title" => "Module",
                    "link"  => "admin/module"
                ),
                "Product Type" => array(
                    "title" => "Product Type",
                    "link"  => "admin/producttype"
                ),
                "Price" => array(
                    "title" => "Price",
                    "link"  => "admin/price"
                ),
                "Duration" => array(
                    "title" => "Duration",
                    "link"  => "admin/duration"
                ),
                "Generate" => array(
                    "title" => "Generate",
                    "link"  => "admin/generate"
                ),
                "Connect" => array(
                    "title" => "Connect",
                    "link"  => "admin/connect"
                ),
                "600" => array(
                    "title" => "600",
                    "link"  => "admin/600"
                ),
            ),
            "" => array(
                "icon"  => "lock_outline",
                "link"  => "admin/logout",
                "grouptext" => "LogOut"
            ),
        );
    }

    function loadSideBar($page, $rank = 0)
    {
        if($rank == 2)
            $data['list'] = $this->manage_menu;
        else
            $data['list'] = $this->user_menu;
        $this->load->view($page, $data);
    }

    function page404()
    {
        $data = array(
            'heading' => '404 Page Not Found',
            'message' => '<p>The page you requested was not found.</p>'
        );
        $this->load->view('errors/html/error_404', $data);
    }

    function getFormattedTimeAllowed($timeAllowed) {
        $res = array();
        list($value, $unit) = explode(" ", $timeAllowed);
        $value = intval($value);
        $displayValue = $value < 10 ? "0{$value}" : strval($value); 
        if (strpos(strtolower($unit), 'hour') !== false) {
            $res['value'] = $value * 60 * 60 * 1000; //[$value, 0, 0];
            $res['format'] = [$displayValue, "00", "00"];
        } else {
            $res['value'] = $value * 60 * 1000;
            if ($value > 60) {
                $hour = intval($value / 60);
                $minute = $value - 60;
                $displayHour = $hour < 10 ? "0{$hour}" : strval($hour);
                $displayMinute = $minute < 10 ? "0{$minute}" : strval($minute);
                //$res['value'] = [$hour, $minute, 0];
                $res['format'] = [$displayHour, $displayMinute, "00"];
            } else {
                //$res['value'] = [0, $value, 0];
                $res['format'] = ["00", $displayValue, "00"];
            }
        }
        return $res;
    }
}
?>