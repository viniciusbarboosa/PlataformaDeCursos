<section class="page-section" style="min-height:calc(100vh - 85px);">
        <div class="container">
           <div class="row">
            <div class="col-lg-6  text-center mx-auto">
           <div class="section-title">
                <H1>AREA RESTRITA</H1>
                <br>
            </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-lg-offset-5 col-lg-2   text-center mx-auto">
           <div class="form-group">
                <a id="btn_your_user" class="btn btn-link" user_id="<?= $user_id ?>"><i class="fa fa-user"></i></a>
                <a class="btn btn-link"  href="<?= base_url()?>areaRestrita/logoff"><i class="fas fa-door-open"></i></a>
            </div> 
            </div>
          </div>
        </div>

  
        <div class="container">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="tab_courses" data-bs-toggle="tab" href="#courses" role="tab">CURSOS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab_team" data-bs-toggle="tab" href="#team" role="tab">EQUIPE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab_users" data-bs-toggle="tab" href="#users" role="tab">USUÁRIOS</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="courses" role="tabpanel">
        <div class="container-fluid">
          <h2 class="text-center"><stron>Gerenciar Cursos</stron></h2>
          <a id="btn_add_course" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp; Adicionar Curso</i></a>
          <table id="dt_course" class="table table-striped table-bordered">
            <thead>
              <tr class="tableheader">
                <th class="dt-center">Nome</th>
                <th class="dt-center no-sort">Imagem</th>
                <th class="dt-center">Duração(H)</th>
                <th class="no-sort">Descrição</th>
                <th class="dt-center no-sort">Ações</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="team" role="tabpanel">
      <div class="container-fluid">
          <h2 class="text-center"><stron>Gerenciar Equipe</stron></h2>
          <a id="btn_add_member" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp; Adicionar Novo Membro</i></a>
          <table id="dt_team" class="table table-striped table-bordered">
            <thead>
              <tr class="tableheader">
              <th class="dt-center">Nome</th>
                <th class="dt-center no-sort">Foto</th>
                <th class="no-sort">Descrição</th>
                <th class="dt-center no-sort">Ações</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="users" role="tabpanel">
      <div class="container-fluid">
          <h2 class="text-center"><stron>Gerenciar Usuarios</stron></h2>
          <a id="btn_add_user" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp; Adicionar Usuarios</i></a>
          <table id="dt_users" class="table table-striped table-bordered">
            <thead>
              <tr class="tableheader">
                <th>Login</th>
                <th>Nome</th>
                <th>Email</th>
                <th class="dt-center no-sort">Ações</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    </section>



<!-- MODAL CURSOS -->
<div id="modal_course" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cursos</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="form_course">
          <input id="course_id" name="course_id" hidden>
          
          <div class="form-group">
            <label for="course_name" class="control-label">Nome</label>
            <input type="text" id="course_name" name="course_name" class="form-control" maxlength="100">
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Imagem</label>
            <div class="col-lg-10">
              <img id="course_img_path" src="" style="max-height: 400px; max-width:780px;"><br>
              <label class="btn btn-block btn-info">
                <i class="fa fa-upload"></i>&nbsp;&nbsp;Importar imagem
                <input type="file" id="btn_upload_course_img" accept="image/*" style="display: none;">
              </label><br>
              <input id="course_img" name="course_img" hidden>
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="course_duration" class="control-label">Duração (H)</label>
            <input type="number" step="0.1" id="course_duration" name="course_duration" class="form-control">
            <span class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="course_description" class="control-label">Descrição</label>
            <textarea id="course_description" name="course_description" class="form-control"></textarea>
            <span class="help-block"></span>
          </div>

          <div class="form-group text-center">
            <button type="submit" id="btn_save_course" class="btn btn-primary">
              <i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
            </button>
            <span class="help-block"></span>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>



    <!--MODAL TEAM-->
    <div id="modal_member" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Membro</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="form_member">
          <input id="member_id" name="member_id" hidden>
          
          <div class="form-group">
            <label class="col-lg-2 control-label">Nome</label>
            <div class="col-lg-10">
              <input id="member_name" name="member_name" class="form-control" maxlength="100">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Foto</label>
            <div class="col-lg-10">
              <img id="member_photo_path" src="" style="max-height: 400px; max-width:780px;"><br>
              <label class="btn btn-block btn-info">
                <i class="fa fa-upload"></i>&nbsp;&nbsp;Importar foto
                <input type="file" id="btn_upload_member_photo" accept="image/*" style="display: none;">
              </label><br>
              <input id="member_photo" name="member_photo" hidden>
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Descrição</label>
            <div class="col-lg-10">
              <textarea id="member_description" name="member_description" class="form-control"></textarea>
              <span class="help-block"></span>
            </div>
          </div>
          
          <br>

          <div class="form-group text-center">
            <button type="submit" id="btn_save_member" class="btn btn-primary">
              <i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
            </button>
            <span class="help-block"></span>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<!--MODAL USER-->
<div id="modal_user" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Usuário</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="form_user">
          <input id="user_id" name="user_id" hidden>
          
          <div class="form-group">
            <label class="col-lg-2 control-label">Login</label>
            <div class="col-lg-10">
              <input id="user_login" name="user_login" class="form-control" maxlength="30">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Nome Completo</label>
            <div class="col-lg-10">
              <input id="user_full_name" name="user_full_name" class="form-control" maxlength="100">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
              <input id="user_email" name="user_email" class="form-control" maxlength="100">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Confirmar Email</label>
            <div class="col-lg-10">
              <input id="user_email_confirm" name="user_email_confirm" class="form-control" maxlength="100">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Senha</label>
            <div class="col-lg-10">
              <input type="password" id="user_password" name="user_password" class="form-control">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Confirmar Senha</label>
            <div class="col-lg-10">
              <input type="password" id="user_password_confirm" name="user_password_confirm" class="form-control">
              <span class="help-block"></span>
            </div>
          </div>

          <div class="form-group text-center">
            <button type="submit" id="btn_save_user" class="btn btn-primary">
              <i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
            </button>
            <span class="help-block"></span>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>