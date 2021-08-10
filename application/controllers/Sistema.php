<?php

defined ('BASEPATH') OR exit ('Ação não permitida');

class Sistema extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if (!$this->ion_auth->logged_in())  {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
          redirect('login');
        }

    }

    public function index() {

        $data = array(
            'titulo' => 'Editar informações do sistema',

            'scripts' => array(
                'vendor/mask/jquery.mask.min.js',
                'vendor/mask/app.js',
            ),

            'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
        );

        /*
        [sistema_id] => 1
        [sistema_razao_social] => Adega Alves - LTDA
        [sistema_nome_fantasia] => Adega Alves
        [sistema_cnpj] => 123.456.789/0001-10
        [sistema_ie] => 897.565.167.585
        [sistema_telefone_fixo] => (14)3445-7890
        [sistema_telefone_movel] => (14)99678-8945
        [sistema_email] => empresa@adega.com
        [sistema_site_url] => http://localhost/cipcompany/
        [sistema_cep] => 18670-000
        [sistema_endereco] => Rua Cel. Francisco Rodrigues
        [sistema_numero] => 729
        [sistema_cidade] => Areiópolis
        [sistema_estado] => SP
        [sistema_txt_ordem_servico] => 
        [sistema_data_alteracao] => 2021-06-05 12:15:49
        */

        $this->form_validation->set_rules('sistema_razao_social', 'Razão Social', 'required|min_length[5]|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', 'Nome Fantasia', 'required|min_length[5]|max_length[145]');
        $this->form_validation->set_rules('sistema_cnpj', 'CNPJ', 'required|exact_length[18]');
        $this->form_validation->set_rules('sistema_ie', 'IE', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_fixo', '', 'max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_movel', 'celular', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_email', 'e-mail', 'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('sistema_site_url', 'site', 'valid_url|max_length[100]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', 'endereço', 'required|max_length[145]');
        $this->form_validation->set_rules('sistema_numero', 'número', 'max_length[25]');
        $this->form_validation->set_rules('sistema_cidade', 'cidade', 'required|max_length[45]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('sistema_txt_ordem_servico', 'descrição', 'required|max_length[500]');

        if($this->form_validation->run()) {

            /*[sistema_razao_social] => Adega Alves - LTDA
            [sistema_nome_fantasia] => Adega Alves
            [sistema_cnpj] => 12.345.678/0001-10
            [sistema_ie] => 897.565.167.585
            [sistema_telefone_fixo] => (14)3445-7890
            [sistema_telefone_movel] => (14)99678-8945
            [sistema_email] => empresa@adega.com
            [sistema_site_url] => http://localhost/cipcompany/
            [sistema_cep] => 18670-000
            [sistema_endereco] => Rua Cel. Francisco Rodrigues
            [sistema_numero] => 729
            [sistema_cidade] => Areiópolis
            [sistema_estado] => SP
            [sistema_txt_ordem_servico] => Testando...*/

            $data = elements(
                array(
                'sistema_razao_social',
                'sistema_nome_fantasia',
                'sistema_cnpj',
                'sistema_ie',
                'sistema_telefone_fixo',
                'sistema_telefone_movel',
                'sistema_email',
                'sistema_site_url',
                'sistema_cep',
                'sistema_endereco',
                'sistema_numero',
                'sistema_cidade',
                'sistema_estado',
                'sistema_txt_ordem_servico',

                ), $this->input->post()
            );

            $data = html_scape($data);

            $this->core_model->update('sistema', $data, array('sistema_id' => ''));
            redirect('sistema');

        }else {

            //Erro de validação

            $this->load->view('layout/header', $data);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');

        }
    }
}