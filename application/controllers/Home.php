<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model("courses_model");
		$this->load->model("team_model");
		$courses = $this->courses_model->show_course();
		$team = $this->team_model->show_course();
		$data = [
			"scripts" => [
				"scripts.js"
			],
			"courses"=> $courses,
			"team"=>$team
		];
		$this->template->show('home',$data);
	}
}
