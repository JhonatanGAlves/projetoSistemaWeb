    <?php $this->load->view('layout/sidebar'); ?>

      <!-- Main Content -->
      <div id="content">

        <?php $this->load->view('layout/navbar'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo base_url('clientes'); ?>">Clientes</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
            </ol>
          </nav>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
              <form class="user" method="POST" name="form_add">

                  <div class="col-md-2">
                    <label>Tipo de cliente</label>
                    <select class="custom-select" name="cliente_tipo">
                      <option value="1">Pessoa física</option>
                      <option value="1">Pessoa jurídica</option>
                    </select>
                  </div>
                
                <fieldset class="mt-5 border p-2">

                  <legend class="font-small"><i class="fas fa-user-tie"></i>&nbsp;Dados pessoais</legend>

                  <div class="form-group row mb-3">
                    
                    <div class="col-md-4 mb-3">
                      <label>Nome</label>
                      <input type="text" class="form-control form-control-user" name="cliente_nome" value="<?php echo set_value('cliente_nome'); ?>">
                      <?php echo form_error('cliente_nome', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label>Sobrenome</label>
                      <input type="text" class="form-control form-control-user" name="cliente_sobrenome" value="<?php echo set_value('cliente_sobrenome'); ?>">
                      <?php echo form_error('cliente_sobrenome', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-2">
                      <label>Data de nascimento</label>
                      <input type="date" class="form-control form-control-user" name="cliente_data_nascimento" value="<?php echo set_value('cliente_data_nascimento'); ?>">
                      <?php echo form_error('cliente_data_nascimento', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>                    

                  </div>

                  <div class="form-group row mb-3">

                    <div class="col-md-3">
                      <label>CPF&nbsp;/&nbsp;CNPJ</label>
                      <input type="text" class="form-control form-control-user" name="cliente_cpf_cnpj" value="<?php echo set_value('cliente_cpf_cnpj'); ?>">
                      <?php echo form_error('cliente_cpf_cnpj', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-3">
                      <label>RG&nbsp;/&nbsp;I.E</label>
                      <input type="text" class="form-control form-control-user" name="cliente_rg_ie" value="<?php echo set_value('cliente_rg_ie'); ?>">
                      <?php echo form_error('cliente_rg_ie', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label>E-mail</label>
                      <input type="email" class="form-control form-control-user" name="cliente_email" value="<?php echo set_value('cliente_email'); ?>">
                      <?php echo form_error('cliente_email', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                  </div>

                  <div class="form-group row mb-3">

                    <div class="col-md-6">
                      <label>Telefone</label>
                      <input type="text" class="form-control form-control-user sp_celphones" name="cliente_telefone" value="<?php echo set_value('cliente_telefone'); ?>">
                      <?php echo form_error('cliente_telefone', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-6">
                      <label>Celular</label>
                      <input type="text" class="form-control form-control-user sp_celphones" name="cliente_celular" value="<?php echo set_value('cliente_celular'); ?>">
                      <?php echo form_error('cliente_celular', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                  </div>

                </fieldset>

                <fieldset class="mt-4 border p-2">

                  <legend class="font-small"><i class="fas fa-map-marker-alt"></i>&nbsp;Dados de endereço</legend>

                  <div class="form-group row mb-3">

                    <div class="col-md-6">
                      <label>Endereço</label>
                      <input type="text" class="form-control form-control-user" name="cliente_endereco" value="<?php echo set_value('cliente_endereco'); ?>">
                      <?php echo form_error('cliente_endereco', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-2">
                      <label>Número</label>
                      <input type="text" class="form-control form-control-user" name="cliente_numero_endereco" value="<?php echo set_value('cliente_numero_endereco'); ?>">
                      <?php echo form_error('cliente_numero_endereco', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-4">
                      <label>Complemento</label>
                      <input type="text" class="form-control form-control-user" name="cliente_complemento" value="<?php echo set_value('cliente_complemento'); ?>">
                      <?php echo form_error('cliente_complemento', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>
                  
                  </div>

                  <div class="form-group row mb-3">

                    <div class="col-md-4">
                      <label>Bairro</label>
                      <input type="text" class="form-control form-control-user" name="cliente_bairro" value="<?php echo set_value('cliente_bairro'); ?>">
                      <?php echo form_error('cliente_bairro', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-3">
                      <label>CEP</label>
                      <input type="text" class="form-control form-control-user cep" name="cliente_cep" value="<?php echo set_value('cliente_cep'); ?>">
                      <?php echo form_error('cliente_cep', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-4">
                      <label>Cidade</label>
                      <input type="text" class="form-control form-control-user" name="cliente_cidade" value="<?php echo set_value('cliente_cidade'); ?>">
                      <?php echo form_error('cliente_cidade', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>

                    <div class="col-md-1">
                      <label>Estado</label>
                      <input type="text" class="form-control form-control-user uf" name="cliente_estado" value="<?php echo set_value('cliente_estado'); ?>">
                      <?php echo form_error('cliente_estado', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>
                   
                  </div>

                </fieldset>

                <fieldset class="mt-4 border p-2">

                  <legend class="font-small"><i class="fas fa-tools"></i>&nbsp;Configurações</legend>

                  <div class="form-group row">

                    <div class="col-md-4">
                      <label>Cliente ativo</label>
                      <select class="custom-select" name="cliente_ativo">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                      </select>
                    </div>

                    <div class="col-md-8">
                      <label>Observação</label>
                      <textarea class="form-control form-control-user" name="cliente_obs"></textarea>
                      <?php echo form_error('cliente_obs', '<small class="form-text" text-danger">','</small>'); ?>
                    </div>
                  
                  </div>
                
                </fieldset>

                <button type="submit" class="btn btn-primary btn-sm mt-3 ml-3">Salvar</button>
                <a title="Voltar" href="<?php echo base_url('clientes'); ?>" class="btn btn-success btn-sm mt-3 ml-2"><i class="fas fa-arrow-left"></i>&nbsp;Voltar</a>
              </form>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->