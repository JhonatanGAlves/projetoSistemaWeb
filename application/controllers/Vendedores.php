<?php

defined ('BASEPATH') OR exit('Ação não permitida');

class Vendedores extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())  {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
            redirect('login');
        }

    }

    public function index() {

        $data = array(

            'titulo' => 'Vendedores cadastrados',

            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js',
            ),

            'vendedores' => $this->core_model->get_all('vendedores'),
        );

/*      echo '<pre>';
        print_r($data['vendedores']);
        exit(); */

        $this->load->view('layout/header', $data);
        $this->load->view('vendedores/index');
        $this->load->view('layout/footer');

    }


    public function edit($vendedor_id = NULL) {

        if(!$vendedor_id || !$this->core_model->get_by_id('vendedores', array('vendedor_id' => $vendedor_id))) {
            $this->session->set_flashdata('error', 'Vendedor não encontrado');
            redirect('vendedores');
        }else {

            $this->form_validation->set_rules('vendedor_nome_completo', 'nome', 'trim|required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('vendedor_cpf', 'CPF', 'trim|required|exact_length[14]');
            $this->form_validation->set_rules('vendedor_rg', 'RG', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('vendedor_email', 'e-mail', 'trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('vendedor_telefone', 'telefone', 'trim|max_length[16]');
            $this->form_validation->set_rules('vendedor_celular', 'celular', 'trim|max_length[16]');
            $this->form_validation->set_rules('vendedor_contato', 'contato', 'trim|required|max_length[45]');
            $this->form_validation->set_rules('vendedor_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('vendedor_endereco', 'endereço', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('vendedor_numero_endereco', 'número', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('vendedor_bairro', 'bairro', 'trim|required|max_length[45]');
            $this->form_validation->set_rules('vendedor_cidade', 'cidade', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('vendedor_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('vendedor_complemento', 'complemento', 'trim|required|max_length[145]');
            $this->form_validation->set_rules('vendedor_obs', 'observação', 'max_length[500]');

            if($this->form_validation->run()) {
                $data = elements(
                    array(
                    'vendedor_codigo',
                    'vendedor_nome_completo',
                    'vendedor_cpf',
                    'vendedor_rg',
                    'vendedor_email',
                    'vendedor_contato',
                    'vendedor_telefone',
                    'vendedor_celular',
                    'vendedor_endereco',
                    'vendedor_numero_endereco',
                    'vendedor_complemento',
                    'vendedor_bairro',
                    'vendedor_cep',
                    'vendedor_cidade',
                    'vendedor_estado',
                    'vendedor_ativo',
                    'vendedor_obs',


                ), $this->input->post()
            );

            $data['vendedor_estado'] = strtoupper($this->input->post('vendedor_estado'));

            $data = html_escape($data);

            $this->core_model->update('vendedores', $data, array('vendedor_id' => $vendedor_id));
            redirect('vendedores');
            }else {


                $data = array(

                    'titulo' => 'Atualizar vendedor',
    
                    'scripts' => array(
                        'vendor/mask/jquery.mask.min.js',
                        'vendor/mask/app.js',
                    ),
    
                    'vendedor' => $this->core_model->get_by_id('vendedores', array('vendedor_id' => $vendedor_id)),
                );
    
                /* echo '<pre>';
                print_r($data['vendedor'])/
                exit(); */
    
                $this->load->view('layout/header', $data);
                $this->load->view('vendedores/edit');
                $this->load->view('layout/footer');
                
            }
            
        }
    }

    public function add() {

        /* [vendedor_id] => 1
        [vendedor_codigo] => 09842571
        [vendedor_data_cadastro] => 2020-01-27 22:24:17
        [vendedor_nome_completo] => Lucio Antonio de Souza
        [vendedor_cpf] => 946.873.070-00
        [vendedor_rg] => 36.803.319-3
        [vendedor_telefone] => 
        [vendedor_celular] => (41) 99999-9999
        [vendedor_email] => vendedor@gmail.com
        [vendedor_cep] => 80530-000
        [vendedor_endereco] => Rua das vendas
        [vendedor_numero_endereco] => 45
        [vendedor_complemento] => 
        [vendedor_bairro] => Centro
        [vendedor_cidade] => Curitiba
        [vendedor_estado] => PR
        [vendedor_ativo] => 1
        [vendedor_obs] =>  */

        $this->form_validation->set_rules('vendedor_nome_completo', 'nome', 'trim|required|min_length[5]|max_length[45]');
        $this->form_validation->set_rules('vendedor_cpf', 'CPF', 'trim|required|exact_length[14]|is_unique[vendedores.vendedor_cpf]');
        $this->form_validation->set_rules('vendedor_rg', 'RG', 'trim|required|max_length[20]|is_unique[vendedores.vendedor_rg]');
        $this->form_validation->set_rules('vendedor_email', 'e-mail', 'trim|required|valid_email|max_length[50]|is_unique[vendedores.vendedor_email]');
        $this->form_validation->set_rules('vendedor_telefone', 'telefone', 'trim|max_length[16]|is_unique[vendedores.vendedor_telefone]');
        $this->form_validation->set_rules('vendedor_celular', 'celular', 'trim|max_length[16]|is_unique[vendedores.vendedor_celular]');
        $this->form_validation->set_rules('vendedor_contato', 'contato', 'trim|required|max_length[45]');
        $this->form_validation->set_rules('vendedor_cep', 'CEP', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('vendedor_endereco', 'endereço', 'trim|required|max_length[155]');
        $this->form_validation->set_rules('vendedor_numero_endereco', 'número', 'trim|required|max_length[155]');
        $this->form_validation->set_rules('vendedor_bairro', 'bairro', 'trim|required|max_length[45]');
        $this->form_validation->set_rules('vendedor_cidade', 'cidade', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('vendedor_estado', 'estado', 'trim|required|exact_length[2]');
        $this->form_validation->set_rules('vendedor_complemento', 'complemento', 'trim|required|max_length[145]');
        $this->form_validation->set_rules('vendedor_obs', 'observação', 'max_length[500]');

        if($this->form_validation->run()) {
            
            $data = elements(
                array(
                'vendedor_nome_completo',
                'vendedor_cpf',
                'vendedor_rg',
                'vendedor_email',
                'vendedor_contato',
                'vendedor_telefone',
                'vendedor_celular',
                'vendedor_endereco',
                'vendedor_numero_endereco',
                'vendedor_complemento',
                'vendedor_bairro',
                'vendedor_cep',
                'vendedor_cidade',
                'vendedor_estado',
                'vendedor_ativo',
                'vendedor_obs',
                    ), $this->input->post()
        );

        $data['vendedor_estado'] = strtoupper($this->input->post('vendedor_estado'));

        $data = html_escape($data);

        $this->core_model->insert('vendedores', $data );
        redirect('vendedores');

        }else {

            $data = array(

                'titulo' => 'Cadastrar vendedor',

                'scripts' => array(
                    'vendor/mask/jquery.mask.min.js',
                    'vendor/mask/app.js',
                ), 
            );

            // echo '<pre>';
            // print_r($data['vendedores']);
            // exit();

            $this->load->view('layout/header', $data);
            $this->load->view('vendedores/add');
            $this->load->view('layout/footer'); 
        }
    }

    public function del($vendedor_id = NULL) {
        if(!$vendedor_id || !$this->core_model->get_by_id('vendedores', array('vendedor_id' => $vendedor_id))) {
            $this->session->set_flashdata('error' , 'Vendedor não encontrado');
            redirect('vendedores');
        }else {
        $this->core_model->delete('vendedores', array('vendedor_id' => $vendedor_id));
        redirect('vendedores');
        }
    }

}