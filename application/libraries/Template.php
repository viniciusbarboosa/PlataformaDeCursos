<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Template {
 
		function show($view, $data=array()){
 
			$CI = & get_instance();
 
			// Load header
			$CI->load->view('template/header',$data);
 
			// Load content
			$CI->load->view($view,$data);
 
			// Load footer
			$CI->load->view('template/footer',$data);
 
			// Scripts
			$CI->load->view('template/scripts',$data);
		}
}
 
/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
/*PARA INSERIR NO ARQUIVO*/
/*
"application/config/autoload.php" (linha 61):
$autoload['libraries'] = array('template');
Não se esqueça de alterar a linha 91 (para habilitar o uso de url):
$autoload['helper'] = array('url'); */ 