    <?php $this->load->view('layout/sidebar'); ?>

      <!-- Main Content -->
      <div id="content">

        <?php $this->load->view('layout/navbar'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo base_url('usuarios'); ?>">Usuários</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
            </ol>
          </nav>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
              <form method="POST" name="form_edit">
                <div class="form-group row mb-4">

                  <div class="col-md-4">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo $usuario->first_name; ?>">
                    <?php echo form_error('first_name', '<small class="form-text" text-danger">','</small>'); ?>
                  </div>

                  <div class="col-md-4">
                    <label>Sobrenome</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo $usuario->last_name; ?>">
                    <?php echo form_error('last_name', '<small class="form-text" text-danger">','</small>'); ?>
                  </div>

                  <div class="col-md-4">
                    <label>E-mail&nbsp;(Login)</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $usuario->email; ?>">
                    <?php echo form_error('email', '<small class="form-text" text-danger">','</small>'); ?>
                  </div>

                  <div class="col-md-4">
                    <label>Celular</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $usuario->phone; ?>">
                  </div>

                </div>

                <div class="form-group row mb-4">

                  <div class="col-md-4">
                    <label>Usuário</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $usuario->username; ?>">
                    <?php echo form_error('username', '<small class="form-text" text-danger">','</small>'); ?>
                  </div>

                  <div class="col-md-4">
                    <label>Ativo</label>
                    <select class="form-control" name="active">
                      <option value="0" <?php echo ($usuario->active == 0) ? 'selected' : '' ?>>Não</option>
                      <option value="1" <?php echo ($usuario->active == 1) ? 'selected' : '' ?>>Sim</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label>Perfil de acesso</label>
                    <select class="form-control" name="perfil_usuario">
                      <option value="2" <?php echo ($perfil_usuario->id == 2) ? 'selected' : '' ?>>Funcionário</option>
                      <option value="1" <?php echo ($perfil_usuario->id == 1) ? 'selected' : '' ?>>Administrador</option>
                    </select>
                  </div>

                </div>

                <div class="form-group row mb-4">

                  <div class="col-md-6">
                    <label>Senha</label>
                    <input type="password" class="form-control" name="password" value="">
                    <?php echo form_error('password', '<small class="form-text" text-danger">','</small>'); ?>
                  </div>

                  <div class="col-md-6">
                    <label>Confirmar Senha</label>
                    <input type="password" class="form-control" name="confirm_password" value="">
                    <?php echo form_error('confirm_password', '<small class="form-text" text-danger">','</small>'); ?>
                  </div>

                  <input type="hidden" name="usuario_id" value="<?php echo $usuario->id ?>">

                </div>
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                <a title="Voltar" href="<?php echo base_url('usuarios'); ?>" class="btn btn-success btn-sm ml-2"><i class="fas fa-arrow-left"></i>&nbsp;Voltar</a>
              </form>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->