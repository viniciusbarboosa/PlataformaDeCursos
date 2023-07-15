        <!-- About-->
    <section class="page-section" style="min-height:calc(100vh - 85px);">
        <div class="container">
           <div class="row">
            <div class="col-lg-6  text-center mx-auto">
           <div class="section-title">
                <H1>LOGIN</H1>
                <form id="login_form" method="post" action="<?= base_url()?>AreaRestrita/ajax_login">
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"   style="background-color: #f2f2f2; display: flex; justify-content: center; align-items: center; width: 40px;">
                                        <span class="fas fa-user"></span>
                                    </div>
                                    <input type="text" placeholder="Usuario" name="username" id="username" class="form-control">
                                </div>
                                <span class="help-block"></span>  
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"  style="background-color: #f2f2f2; display: flex; justify-content: center; align-items: center; width: 40px;">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                    <input type="password" placeholder="Senha" name="password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button  id="btn_login" type="submit" class="btn btn-secondary w-100">Botão</button>
                            </div>
                            <span class="help-block"></span>  
                        </div>
                    </div>

                </form>
            </div> 
            </div>
          </div>
        </div>
    </section>