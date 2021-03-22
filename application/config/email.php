<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.elasticemail.com';
    $config['smtp_port'] = '2525'; 
    $config['smtp_user'] = 'info@module.com'; 
    $config['smtp_pass'] = ''; 
    //$config['smtp_crypto'] = 'tls';
    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
?>