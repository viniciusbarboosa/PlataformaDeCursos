<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AreaRestrita extends CI_Controller {

	public function index()
	{
		if($this->session->userdata("user_id")){
			$data = [
				"styles" =>[
				  "datatables.min.css",
				  "dataTables.bootstrap5.min.css",
				  "areaRestrita.css"
				],
				"scripts" => [
					"datatables.min.js",
					"dataTables.bootstrap5.min.js",
					"util.js",
					"restrict.js"
				],
				"user_id" => $this->session->userdata("user_id")
			];
			$this->template->show("areaRestrita",$data);
		}else{
			$this->load->model("users_model");
			//print_r ($this->users_model->get_user_data('teste'));
			$data = [
				"scripts" => [
					"util.js",
					"login.js"
				],
				"styles"=>[
					"login.css"
				]
			];
			//GERAR SENHA
			//echo password_hash("123",PASSWORD_DEFAULT);
			$this->template->show('login',$data);
		}


	}

	public function logoff(){
		$this->session->sess_destroy();	
		header("Location:".base_url()."areaRestrita");
	}

	public function ajax_login(){

		IF(! $this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido");
		}

		$json = [];
		$json["status"] = 1;
		$json["error_list"] = [];

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if(empty($username)){
			$json["status"] = 0;
			$json["error_list"]["#username"] = "Usuário não pode ser vazio";
		}else{
			$this->load->model("users_model");
			$result = $this->users_model->get_user_data($username);
			if($result){
				$user_id = $result->user_id;
				$password_hash = $result->password_hash;
				if(password_verify($password,$password_hash)){
					$this->session->set_userdata("user_id",$user_id);
				}else{
					$json["status"] = 0;
				}
			}else{
				$json["status"] = 0;
			}
			if ($json["status"] == 0){
				$json["error_list"]["#btn_login"] = "Usuário e/ou Senha Invalida";
			}
		}
		
		echo json_encode($json);
	}

	public function ajax_import_image(){
		$config["upload_path"] = "./tmp/";
		$config["allowed_types"] = "gif|png|jpg|jpeg";
		$config["overwrite"] = TRUE;

		//BIBLIOTECA ENVIAR IMAGENS
		$this->load->library("upload",$config);

		$json = array();
		$json["status"] = 1;
		//LEMBRAR QUE PEGA DO JS
		if(!$this->upload->do_upload("image_file")){
			$json["status"] = 0;
			$json["error"] = $this->upload->display_errors("","");
		}else{ 
			if($this->upload->data()["file_size"]<= 1024){
				$file_name = $this->upload->data()["file_name"];
				$json["img_path"] = base_url()."tmp/".$file_name;
				//$json["img_path"] = "./tmp/".$file_name;
			}else{
				$json["status"] = 0;
				$json["error"] = "O arquivo não deve ser maior que 1MB";
			}
		}

		echo json_encode($json);
	}

	public function ajax_save_course(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("courses_model");

		$data = $this->input->post();

		if(empty($data["course_name"])){
			$json["error_list"]["#course_name"] = "Nome do curso é obrigatorio";
		}else{
			if($this->courses_model->is_duplicated("course_name",$data["course_name"],$data["course_id"])){
				$json["error_list"]["#course_name"] = "Nome de curso ja existe";
			}
		}
		//TRANFORMA EM FLOAT PRIMEIRO
		//print_r($data); 
		$data["course_duration"] = floatval($data["course_duration"]);
		if(empty($data["course_duration"])){
			$json["error_list"]["#course_name"] = "Duração do curso é obrigatorio";
		}else{
			if(!($data["course_duration"] > 0 && $data["course_duration"] < 100)){
				$json["error_list"]["#course_name"] = "Duração deve ser maior que 0 horas e maior que 100 horas";
			}
		}

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		}else{
	
//  JEITO ERRADO DE DA UPDATE NA IMG VERIFICAR DPS SALVA NO TEMP
		/*	if(!empty($data["course_img"])){
				$file_name = basename($data["course_img"]);
				$old_path = getcwd()."temp/" .$file_name;
				$new_path = getcwd()."public/assets/img/cursos/".$file_name;
				rename($old_path,$new_path);
				$data["course_img"] = "public/assets/img/cursos/".$file_name;
			} */

			//JEITO 2 DE FAZER
			if (!empty($data["course_img"])) {
				$file_name = basename($data["course_img"]);
				$temp_path = $data["course_img"]; 
				$new_path = getcwd() . "/public/assets/img/cursos/" . $file_name;
			
				if (copy($temp_path, $new_path)) {
					$data["course_img"] = "public/assets/img/cursos/" . $file_name;
				} else {
					unset($data["course_img"]);
				}
			}
			
			

			if(empty($data["course_id"])){
				unset($data["course_id"]);
				$this->courses_model->insert($data);
			}else{
				$course_id = $data["course_id"];
				//TIRAR O ID DO DATA PRA NAO MUDAR ID NO BANCO
				unset($data["course_id"]);
				$this->courses_model->upload($course_id,$data);
			}

		}

		echo json_encode(($json));
	}

	public function ajax_save_member() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("team_model");

		$data = $this->input->post();

		if (empty($data["member_name"])) {
			$json["error_list"]["#member_name"] = "Nome do membro é obrigatório!";
		} 

		if (!empty($json["error_list"])) {
			$json["status"] = 0;
		} else {

			//JEITO ANTIGO
		/*	if (!empty($data["member_photo"])) {

				$file_name = basename($data["member_photo"]);
				$old_path = getcwd() . "tmp/" . $file_name;
				$new_path = getcwd() . "public/assets/img/equipe/" . $file_name;
				rename($old_path, $new_path);

				$data["member_photo"] = "/public/assets/images/equipe/" . $file_name;

			} else {
				unset($data["member_photo"]);
			}*/

			//JEITO NOVO
			if (!empty($data["member_photo"])) {
				$file_name = basename($data["member_photo"]);
				$temp_path = $data["member_photo"]; 
				$new_path = getcwd() . "/public/assets/img/equipe/" . $file_name;
			
				if (copy($temp_path, $new_path)) {
					$data["member_photo"] = "public/assets/img/equipe/" . $file_name;
				} else {
						unset($data["member_photo"]);
					}
				}
			}

			if (empty($data["member_id"])) {
				$this->team_model->insert($data);
			} else {
				$member_id = $data["member_id"];
				unset($data["member_id"]);
				$this->team_model->update($member_id, $data);
			}
		

		echo json_encode($json);
	}

	public function ajax_save_user(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("users_model");
		$data = $this->input->post();

		if(empty($data["user_login"])){
			$json["error_list"]["#user_login"] = "Login é obrigatorio";
		}else{
			if($this->users_model->is_duplicated("user_login",$data["user_login"],$data["user_id"])){
				$json["error_list"]["#user_login"] = "Login ja existe";
			}
		}

		if(empty($data["user_full_name"])){
			$json["error_list"]["#user_full_name"] = "Nome Completo é obrigatorio";
		}

		if(empty($data["user_email"])){
			$json["error_list"]["#user_email"] = "Email é obrigatorio";
		}else{
			if($this->users_model->is_duplicated("user_email",$data["user_email"],$data["user_id"])){
				$json["error_list"]["#user_email"] = "Email ja existe";
			} else{
				if($data["user_email"] != $data["user_email_confirm"]){
					$json["error_list"]["#user_email"] = "";
					$json["error_list"]["#user_email_confirm"] = "Emails não são iguais confirme seu email";
				}
			}
		}

		if(empty($data["user_password"])){
			$json["error_list"]["#user_password"] = "Senha é obrigatorio";
		}else{
				if($data["user_password"] != $data["user_password_confirm"]){
					$json["error_list"]["#user_password"] = "";
					$json["error_list"]["#user_password_confirm"] = "Senhas não são iguais confirme a Senha";
				}
		}

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		}else{
			//TROCAR PASSWORD PRA  PASSWORD_HASH
			$data["password_hash"] = password_hash($data["user_password"],PASSWORD_DEFAULT);

			unset($data["user_password"]);
			unset($data["user_password_confirm"]);
			unset($data["user_email_confirm"]);
		
			if(empty($data["user_id"])){
				unset($data["user_id"]);
				$this->users_model->insert($data);
			}else{
				$user_id = $data["user_id"];
				//TIRAR O ID DO DATA PRA NAO MUDAR ID NO BANCO
				unset($data["user_id"]);
				$this->users_model->update($user_id,$data);
			}

		}

		echo json_encode(($json));
	}

	public function ajax_get_user_data(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = [];

		$this->load->model("users_model");

		$user_id = $this->input->post("user_id");
		$data = $this->users_model->get_data($user_id)->result_array()[0];
		$json["input"]["user_id"] = $data["user_id"];
		$json["input"]["user_login"] = $data["user_login"];
		$json["input"]["user_full_name"] = $data["user_full_name"];
		$json["input"]["user_email"] = $data["user_email"];
		$json["input"]["user_email_confirm"] = $data["user_email"];
		$json["input"]["user_password"] = $data["password_hash"];
		$json["input"]["user_password_confirm"] = $data["password_hash"];

		echo json_encode(($json));
	}

	public function ajax_get_course_data(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = [];

		$this->load->model("courses_model");

		$course_id = $this->input->post("course_id");
		$data = $this->courses_model->get_data($course_id)->result_array()[0];
		$json["input"]["course_id"] = $data["course_id"];
		$json["input"]["course_name"] = $data["course_name"];
		$json["input"]["course_duration"] = $data["course_duration"];
		$json["input"]["course_description"] = $data["course_description"];

		$json["img"]["course_img_path"] = base_url().$data["course_img"];
		
		echo json_encode(($json));
	}

	public function ajax_get_member_data(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = [];

		$this->load->model("team_model");

		$member_id = $this->input->post("member_id");
		$data = $this->team_model->get_data($member_id)->result_array()[0];
		$json["input"]["member_id"] = $data["member_id"];
		$json["input"]["member_name"] = $data["member_name"];
		$json["input"]["member_description"] = $data["member_description"];

		$json["img"]["member_photo_path"] = base_url().$data["member_photo"];
		
		echo json_encode(($json));
	}

	public function ajax_delete_course_data(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("courses_model");
		$course_id = $this->input->post("course_id");
		$this->courses_model->delete($course_id);
		
		echo json_encode(($json));
	}

	public function ajax_delete_member_data(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("team_model");
		$member_id = $this->input->post("member_id");
		$this->team_model->delete($member_id);
		
		echo json_encode(($json));
	}

	public function ajax_delete_user_data(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("users_model");
		$user_id = $this->input->post("user_id");
		$this->users_model->delete($user_id);
		
		echo json_encode(($json));
	}

	public function ajax_list_course(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("courses_model");
		$courses = $this->courses_model->get_datatable();

		//FAZER DESSE JEITO PRA PEGAR AS LINHAS NA COLUNA VIA AJAX 
		//ADICIONE NO DATA 
		$data = [];
		foreach ($courses as $course){
			$row = [];
			$row[] = $course->course_name;

			//VERIFICAR SE TEM IMG E PASSAR TBM NO ARRAY MESMO SE TIVER VAZIO 
			if($course->course_img){
				$row[] = '<img src="'.base_url().$course->course_img.'" style="max-height: 100px; max-width:100px;">';
			}else{
				$row[] = "";
			}

			$row[] = $course->course_duration;
			$row[] = '<div class="description">'.$course->course_description.'</div>';

			//BOTOES
			$row[] = '<div style="display: inline-block;">
						<button id="btn-edit-course" class="btn btn-primary btn-edit-course" course_id="'.$course->course_id.'" >
							<i class="fas fa-pencil-alt"></i>
						</button>

						<button class="btn btn-danger btn-del-course" course_id="'.$course->course_id.'" >
						<i class="fas fa-trash"></i>
						</button>
					
					</div>';

					$data[] = $row;
		}
		//PASSAAR COM  OS DADOS DO DATA TABLES
		$json = [
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->courses_model->record_total(),
			"recordsFiltered" => $this->courses_model->record_filtred(),
			"data" => $data,
		];

		echo json_encode(($json));

	}

	public function ajax_list_users(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("users_model");
		$users = $this->users_model->get_datatable();

		//FAZER DESSE JEITO PRA PEGAR AS LINHAS NA COLUNA VIA AJAX 
		//ADICIONE NO DATA 
		$data = [];
		foreach ($users as $user){
			$row = [];
			$row[] = $user->user_login;
			$row[] = $user->user_full_name;
			$row[] = $user->user_email;

			//BOTOES
			$row[] = '<div style="display: inline-block;">
						<button class="btn btn-primary btn-edit-user" user_id="'.$user->user_id.'" >
							<i class="fas fa-pencil-alt"></i>
						</button>

						<button class="btn btn-danger btn-del-user" user_id="'.$user->user_id.'" >
						<i class="fas fa-trash"></i>
					</button>
					
					</div>';

					$data[] = $row;
		}
		//PASSAAR COM  OS DADOS DO DATA TABLES
		$json = [
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->users_model->record_total(),
			"recordsFiltered" => $this->users_model->record_filtred(),
			"data" => $data,
		];

		echo json_encode(($json));

	}

	public function ajax_list_member(){
		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("team_model");
		$team = $this->team_model->get_datatable();

		//FAZER DESSE JEITO PRA PEGAR AS LINHAS NA COLUNA VIA AJAX 
		//ADICIONE NO DATA 
		$data = [];
		foreach ($team as $member){
			$row = [];
			$row[] = $member->member_name;

			//VERIFICAR SE TEM IMG E PASSAR TBM NO ARRAY MESMO SE TIVER VAZIO 
			if($member->member_photo){
				$row[] = '<img src="'.base_url().$member->member_photo.'" style="max-height: 100px; max-width:100px;">';
			}else{
				$row[] = "";
			}

			$row[] = '<div class="description" style="font-size: 12px; max-width: 200px; word-wrap: break-word;"">'.$member->member_description.'</div>';

			//BOTOES
			$row[] = '<div style="display: inline-block;">
						<button class="btn btn-primary btn-edit-member" member_id="'.$member->member_id.'" >
							<i class="fas fa-pencil-alt"></i>
						</button>

						<button class="btn btn-danger btn-del-member" member_id="'.$member->member_id.'" >
						<i class="fas fa-trash"></i>
					</button>
					
					</div>';

					$data[] = $row;
		}
		//PASSAAR COM  OS DADOS DO DATA TABLES
		$json = [
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->team_model->record_total(),
			"recordsFiltered" => $this->team_model->record_filtred(),
			"data" => $data,
		];

		echo json_encode(($json));

	}


}
