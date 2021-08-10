<?php

defined ('BASEPATH') OR exit('Ação não permitida');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in())  {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
            redirect('login');
        }

    }

    public function index() {

        $data = array(

            'titulo' => 'Clientes cadastrados',

            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js',
            ),

            'clientes' => $this->core_model->get_all('clientes'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('clientes/index');
        $this->load->view('layout/footer');

    }

    public function add() {

            $this->form_validation->set_rules('cliente_nome', 'nome', 'trim|required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('cliente_sobrenome', 'sobrenome', 'trim|required|min_length[5]|max_length[150]');
            $this->form_validation->set_rules('cliente_data_nascimento', 'data', 'required');
            $this->form_validation->set_rules('cliente_cpf_cnpj', 'CPF/CNPJ', 'trim|required|min_length[14]|max_length[18]|is_unique[clientes.cliente_cpf_cnpj]');
            $this->form_validation->set_rules('cliente_rg_ie', 'RG/I.E', 'trim|required|max_length[20]|is_unique[clientes.cliente_rg_ie]');
            $this->form_validation->set_rules('cliente_email', 'e-mail', 'trim|required|valid_email|max_length[50]|is_unique[clientes.cliente_email]');
            $this->form_validation->set_rules('cliente_telefone', 'telefone', 'trim|max_length[16]|is_unique[clientes.cliente_telefone]');
            $this->form_validation->set_rules('cliente_celular', 'celular', 'trim|max_length[16]|is_unique[clientes.cliente_celular]');
            $this->form_validation->set_rules('cliente_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('cliente_endereco', 'endereço', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('cliente_numero_endereco', 'número', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('cliente_bairro', 'bairro', 'trim|required|max_length[45]');
            $this->form_validation->set_rules('cliente_cidade', 'cidade', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('cliente_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('cliente_complemento', 'complemento', 'trim|required|max_length[145]');
            $this->form_validation->set_rules('cliente_obs', 'observação', 'max_length[500]');
            
            if ($this->form_validation->run()) {

                $data = elements(
                        array(
                    'cliente_nome',
                    'cliente_sobrenome',
                    'cliente_data_nascimento',
                    'cliente_cpf_cnpj',
                    'cliente_rg_ie',
                    'cliente_email',
                    'cliente_telefone',
                    'cliente_celular',
                    'cliente_endereco',
                    'cliente_numero_endereco',
                    'cliente_complemento',
                    'cliente_bairro',
                    'cliente_cep',
                    'cliente_cidade',
                    'cliente_estado',
                    'cliente_ativo',
                    'cliente_obs',
                    'cliente_tipo',


                        ), $this->input->post()
                );

                $data['cliente_estado'] = strtoupper($this->input->post('cliente_estado'));

                $data = html_escape($data);

                $this->core_model->insert('clientes', $data);
                redirect('clientes');

            }else {

                //Erro de validação

                $data = array(

                    'titulo' => 'Cadastrar cliente',
        
                    'scripts' => array(
                        'vendor/mask/jquery.mask.min.js',
                        'vendor/mask/app.js',
                        'js/clientes.js'
                    ),
                );

//                echo '<pre>';
//                print_r($data['cliente']);
//                exit();
        
                $this->load->view('layout/header', $data);
                $this->load->view('clientes/add');
                $this->load->view('layout/footer');
            }
    }

    public function edit($cliente_id = NULL) {

        if(!$cliente_id || !$this->core_model->get_by_id('clientes', array('cliente_id' => $cliente_id))) {
            $this->session->set_flashdata('error', 'Cliente não encontrado');
            redirect('clientes');
        }else {
            
            $this->form_validation->set_rules('cliente_nome', 'nome', 'trim|required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('cliente_sobrenome', 'sobrenome', 'trim|required|min_length[5]|max_length[150]');
            $this->form_validation->set_rules('cliente_data_nascimento', 'data', 'required');
            $this->form_validation->set_rules('cliente_cpf_cnpj', 'CPF/CNPJ', 'trim|required|min_length[14]|max_length[18]');
            $this->form_validation->set_rules('cliente_rg_ie', 'RG/I.E', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('cliente_email', 'e-mail', 'trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('cliente_telefone', 'telefone', 'trim|max_length[16]');
            $this->form_validation->set_rules('cliente_celular', 'celular', 'trim|max_length[16]');
            $this->form_validation->set_rules('cliente_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('cliente_endereco', 'endereço', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('cliente_numero_endereco', 'número', 'trim|required|max_length[155]');
            $this->form_validation->set_rules('cliente_bairro', 'bairro', 'trim|required|max_length[45]');
            $this->form_validation->set_rules('cliente_cidade', 'cidade', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('cliente_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('cliente_complemento', 'complemento', 'trim|required|max_length[145]');
            $this->form_validation->set_rules('cliente_obs', 'observação', 'max_length[500]');
            
            if ($this->form_validation->run()) {

                /*
                [cliente_nome] => Jhonatan
                [cliente_sobrenome] => Alves
                [cliente_data_nascimento] => 1996-01-23
                [cliente_cpf_cnpj] => 12.345.678/0001-10
                [cliente_rg_ie] => 54.388.546-3
                [cliente_email] => jhonatangalves96@gmail.com
                [cliente_telefone] => (14) 4567-3245
                [cliente_celular] => (14) 99134-2345
                [cliente_endereco] => Rua Cel. Francisco Rodrigues
                [cliente_numero_endereco] => 729
                [cliente_complemento] => Casa
                [cliente_bairro] => Centro
                [cliente_cep] => 18670-000
                [cliente_cidade] => Areiópolis
                [cliente_estado] => SP
                [cliente_ativo] => 0
                [cliente_obs] => Hehe
                [cliente_tipo] => 2
                [cliente_id] => 1*/

                $data = elements(
                        array(
                    'cliente_nome',
                    'cliente_sobrenome',
                    'cliente_data_nascimento',
                    'cliente_cpf_cnpj',
                    'cliente_rg_ie',
                    'cliente_email',
                    'cliente_telefone',
                    'cliente_celular',
                    'cliente_endereco',
                    'cliente_numero_endereco',
                    'cliente_complemento',
                    'cliente_bairro',
                    'cliente_cep',
                    'cliente_cidade',
                    'cliente_estado',
                    'cliente_ativo',
                    'cliente_obs',
                    'cliente_tipo',


                        ), $this->input->post()
                );

                $data['cliente_estado'] = strtoupper($this->input->post('cliente_estado'));

                $data = html_escape($data);

                $this->core_model->update('clientes', $data, array('cliente_id' => $cliente_id));
                redirect('clientes');

            }else {

                //Erro de validação

                $data = array(

                    'titulo' => 'Atualizar cliente',
        
                    'scripts' => array(
                        'vendor/mask/jquery.mask.min.js',
                        'vendor/mask/app.js',
                    ),
        
                    'cliente' => $this->core_model->get_by_id('clientes', array('cliente_id' => $cliente_id)),
                );

//                echo '<pre>';
//                print_r($data['cliente']);
//                exit();
        
                $this->load->view('layout/header', $data);
                $this->load->view('clientes/edit');
                $this->load->view('layout/footer');
            }

        }
    }

    public function del($cliente_id = NULL) {
        if(!$cliente_id || !$this->core_model->get_by_id('clientes', array('cliente_id' => $cliente_id))) {
            $this->session->set_flashdata('error' , 'Cliente não encontrado');
            redirect('clientes');
        }else {
        $this->core_model->delete('clientes', array('cliente_id' => $cliente_id));
        redirect('clientes');
        }
    }
}