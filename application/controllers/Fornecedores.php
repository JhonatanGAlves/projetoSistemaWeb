<?php

defined ('BASEPATH') OR exit('Ação não permitida');

class Fornecedores extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())  {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
            redirect('login');
        }

    }

    public function index() {

        $data = array(

            'titulo' => 'Fornecedores cadastrados',

            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js',
            ),

            'fornecedores' => $this->core_model->get_all('fornecedores'),
        );

//        echo '<pre>';
//        print_r($data['fornecedores']);
//        exit();

        $this->load->view('layout/header', $data);
        $this->load->view('fornecedores/index');
        $this->load->view('layout/footer');

    }


    public function edit($fornecedor_id = NULL) {

        if(!$fornecedor_id || !$this->core_model->get_by_id('fornecedores', array('fornecedor_id' => $fornecedor_id))) {
            $this->session->set_flashdata('error', 'Fornecedor não encontrado');
            redirect('fornecedores');
        }else {

            $this->form_validation->set_rules('fornecedor_razao', 'razão social', 'trim|required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('fornecedor_nome_fantasia', 'nome fantasia', 'trim|required|min_length[5]|max_length[150]');
            $this->form_validation->set_rules('fornecedor_cnpj', 'CNPJ', 'trim|required|min_length[14]|max_length[18]');
            $this->form_validation->set_rules('fornecedor_ie', 'I.E', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('fornecedor_email', 'e-mail', 'trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('fornecedor_telefone', 'telefone', 'trim|max_length[16]');
            $this->form_validation->set_rules('fornecedor_celular', 'celular', 'trim|max_length[16]');
            $this->form_validation->set_rules('fornecedor_contato', 'contato', 'trim|required|max_length[45]');
            $this->form_validation->set_rules('fornecedor_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('fornecedor_endereco', 'endereço', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('fornecedor_numero_endereco', 'número', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('fornecedor_bairro', 'bairro', 'trim|required|max_length[45]');
            $this->form_validation->set_rules('fornecedor_cidade', 'cidade', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('fornecedor_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('fornecedor_complemento', 'complemento', 'trim|required|max_length[145]');
            $this->form_validation->set_rules('fornecedor_obs', 'observação', 'max_length[500]');

            if($this->form_validation->run()) {

                $fornecedor_ativo = $this->input->post('fornecedor_ativo');

                if($this->db->table_exists('produtos')) {

                    if($fornecedor_ativo == 0 && $this->core_model->get_by_id('produtos', array('produto_fornecedor_id' => $fornecedor_id, 'produto_ativo' => 1))) {

                        $this->session->set_flashdata('error', 'Este fornecedor não pode ser desativado, pois está sendo utilizado em <i class="fab fa-product-hunt"></i>&nbsp;Produtos');
                        redirect('fornecedores');
                    }
                }

                $data = elements(
                    array(
                    'fornecedor_razao',
                    'fornecedor_nome_fantasia',
                    'fornecedor_cnpj',
                    'fornecedor_ie',
                    'fornecedor_email',
                    'fornecedor_contato',
                    'fornecedor_telefone',
                    'fornecedor_celular',
                    'fornecedor_endereco',
                    'fornecedor_numero_endereco',
                    'fornecedor_complemento',
                    'fornecedor_bairro',
                    'fornecedor_cep',
                    'fornecedor_cidade',
                    'fornecedor_estado',
                    'fornecedor_ativo',
                    'fornecedor_obs',


                ), $this->input->post()
            );

            $data['fornecedor_estado'] = strtoupper($this->input->post('fornecedor_estado'));

            $data = html_escape($data);

            $this->core_model->update('fornecedores', $data, array('fornecedor_id' => $fornecedor_id));
            redirect('fornecedores');
            }else {


                $data = array(

                    'titulo' => 'Atualizar fornecedor',
    
                    'scripts' => array(
                        'vendor/mask/jquery.mask.min.js',
                        'vendor/mask/app.js',
                    ),
    
                    'fornecedor' => $this->core_model->get_by_id('fornecedores', array('fornecedor_id' => $fornecedor_id)),
                );
    
                /* echo '<pre>';
                print_r($data['fornecedor'])/
                exit(); */
    
                /* [fornecedor_id] => 2
                [fornecedor_data_cadastro] => 2021-06-06 03:05:21
                [fornecedor_razao] => Ambev Brasil
                [fornecedor_nome_fantasia] => Ambev- novo
                [fornecedor_cnpj] => 69.564.885/0001-58
                [fornecedor_ie] => 432.628.417.979
                [fornecedor_telefone] => (14) 3445-3456
                [fornecedor_celular] => (14) 9678-3456
                [fornecedor_email] => empresa@ambev.com
                [fornecedor_contato] => Carlos
                [fornecedor_cep] => 18759-890
                [fornecedor_endereco] => Joaquim Pereira
                [fornecedor_numero_endereco] => 543
                [fornecedor_bairro] => Rodovia
                [fornecedor_complemento] => Rondom
                [fornecedor_cidade] => Agudos
                [fornecedor_estado] => SP
                [fornecedor_ativo] => 0
                [fornecedor_obs] => aaaaa */
    
                $this->load->view('layout/header', $data);
                $this->load->view('fornecedores/edit');
                $this->load->view('layout/footer');
                
            }
            
        }
    }

    public function add() {

        $this->form_validation->set_rules('fornecedor_razao', 'razão social', 'trim|required|min_length[5]|max_length[45]|is_unique[fornecedores.fornecedor_razao]');
        $this->form_validation->set_rules('fornecedor_nome_fantasia', 'nome fantasia', 'trim|required|min_length[5]|max_length[150]|is_unique[fornecedores.fornecedor_nome_fantasia]');
        $this->form_validation->set_rules('fornecedor_cnpj', 'CNPJ', 'trim|required|min_length[14]|max_length[18]|is_unique[fornecedores.fornecedor_cnpj]');
        $this->form_validation->set_rules('fornecedor_ie', 'I.E', 'trim|required|max_length[20]|is_unique[fornecedores.fornecedor_ie]');
        $this->form_validation->set_rules('fornecedor_email', 'e-mail', 'trim|required|valid_email|max_length[50]|is_unique[fornecedores.fornecedor_email]');
        $this->form_validation->set_rules('fornecedor_telefone', 'telefone', 'trim|max_length[16]|is_unique[fornecedores.fornecedor_telefone]');
        $this->form_validation->set_rules('fornecedor_celular', 'celular', 'trim|max_length[16]|is_unique[fornecedores.fornecedor_celular]');
        $this->form_validation->set_rules('fornecedor_contato', 'contato', 'trim|required|max_length[45]');
        $this->form_validation->set_rules('fornecedor_cep', 'CEP', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('fornecedor_endereco', 'endereço', 'trim|required|max_length[155]');
        $this->form_validation->set_rules('fornecedor_numero_endereco', 'número', 'trim|required|max_length[155]');
        $this->form_validation->set_rules('fornecedor_bairro', 'bairro', 'trim|required|max_length[45]');
        $this->form_validation->set_rules('fornecedor_cidade', 'cidade', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('fornecedor_estado', 'estado', 'trim|required|exact_length[2]');
        $this->form_validation->set_rules('fornecedor_complemento', 'complemento', 'trim|required|max_length[145]');
        $this->form_validation->set_rules('fornecedor_obs', 'observação', 'max_length[500]');

        if($this->form_validation->run()) {

            $data = elements(
                array(
            'fornecedor_razao',
            'fornecedor_nome_fantasia',
            'fornecedor_cnpj',
            'fornecedor_ie',
            'fornecedor_email',
            'fornecedor_contato',
            'fornecedor_telefone',
            'fornecedor_celular',
            'fornecedor_endereco',
            'fornecedor_numero_endereco',
            'fornecedor_complemento',
            'fornecedor_bairro',
            'fornecedor_cep',
            'fornecedor_cidade',
            'fornecedor_estado',
            'fornecedor_ativo',
            'fornecedor_obs',
                ), $this->input->post()
        );

        $data['fornecedor_estado'] = strtoupper($this->input->post('fornecedor_estado'));

        $data = html_escape($data);

        $this->core_model->insert('fornecedores', $data );
        redirect('fornecedores');

        }else {


            //Erro de validação

            $data = array(

                'titulo' => 'Cadastrar fornecedor',
    
                'scripts' => array(
                    'vendor/mask/jquery.mask.min.js',
                    'vendor/mask/app.js',
                ),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('fornecedores/add');
            $this->load->view('layout/footer');
        }

    }

    public function del($fornecedor_id = NULL) {
        if(!$fornecedor_id || !$this->core_model->get_by_id('fornecedores', array('fornecedor_id' => $fornecedor_id))) {
            $this->session->set_flashdata('error' , 'Fornecedor não encontrado');
            redirect('fornecedores');
        }else {
        $this->core_model->delete('fornecedores', array('fornecedor_id' => $fornecedor_id));
        redirect('fornecedores');
        }
    }

}