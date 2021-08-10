<?php

defined ('BASEPATH') OR exit('Ação não permitida');

class Usuarios extends CI_Controller {

    public function __construct () {
        parent::__construct();

        if (!$this->ion_auth->logged_in())  {
            $this->session->set_flashdata('info', 'Sua sessão expirou!');
            redirect('login');
        }

    }

    public function index() {

        if(!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar este menu Usuários');
            redirect('dashboard');
        }

        $data = array(

            'title' => 'Usuários cadastrados',

            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js',
            ),

            'usuarios' => $this->ion_auth->users()->result(),
        );

//        echo '<pre>';
//        print_r($data['usuarios']);
//        exit();

        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
    }

    public function add() {

        if(!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar este menu Usuários');
            redirect('dashboard');
        }

        $this->form_validation->set_rules('first_name', '', 'trim|required');
        $this->form_validation->set_rules('last_name', '', 'trim|required');
        $this->form_validation->set_rules('email', '', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', '', 'trim|required');
        $this->form_validation->set_rules('username', '', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'senha', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('confirm_password', 'confirma', 'matches[password]');

        if($this->form_validation->run()) {
            

            $username = $this->security->xss_clean($this->input->post('username'));
            $password = $this->security->xss_clean($this->input->post('password'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $additional_data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'active' => $this->input->post('active'),
                        );
            $group = array($this->input->post('perfil_usuario')); // Setando usuário.

            $additional_data = $this->security->xss_clean($additional_data);

            $group = $this->security->xss_clean($group);

            $this->ion_auth->register($username, $password, $email, $additional_data, $group);

//            echo '<pre>';
//            print_r($additional_data);
//            exit();
        
            $this->ion_auth->register($username, $password, $email, $additional_data, $group);

            if($this->ion_auth->register($username, $password, $email, $additional_data, $group)) {

                $this->session->set_flashdata('secesso', 'Dados salvos com sucesso');

            }else {

                $this->session->set_flashdata('error', 'Erro ao salvar os dados');

            }
            redirect('usuarios');

        } else {

            //Erro de validação

            $data = array(
                'title' => 'Cadastrar usuário',
            );

            $this->load->view('layout/header', $data);
            $this->load->view('usuarios/add');
            $this->load->view('layout/header');
        }
    }

    public function edit($usuario_id = NULL) {
        
        if (($this->session->userdata('user_id') != $usuario_id)) {
            $this->session->set_flashdata('error', 'Você não pode editar um usuário diferente do seu');
            redirect('usuarios');
        }

        if(!$usuario_id || !$this->ion_auth->user($usuario_id)->row()) {

            $this->session->set_flashdata('error', 'Usuário não encontrado');
            redirect('usuarios');
        }else {

                /*
                    [first_name] => Jhonatan
                    [last_name] => Alves
                    [email] => jhonatangalves96@gmail.com
                    [phone] => (14)99172-5235
                    [city] => Areiópolis
                    [state] => São Paulo
                    [country] => Brasil
                    [username] => Jhonatan
                    [active] => 1
                    [perfil_usuario] => 1
                    [password] => 
                    [confirm_password] => 
                    [usuario_id] => 1
                */

//            echo '<pre>';
//            print_r($this->input->post());
//            exit();

            $this->form_validation->set_rules('first_name', '', 'trim|required');
            $this->form_validation->set_rules('last_name', '', 'trim|required');
            $this->form_validation->set_rules('email', '', 'trim|required|valid_email|callback_email_check');
            $this->form_validation->set_rules('username', '', 'trim|required|callback_username_check');
            $this->form_validation->set_rules('password', 'senha', 'min_length[6]|max_length[255]');
            $this->form_validation->set_rules('confirm_password', 'confirma', 'matches[password]');

            if ($this->form_validation->run()) {

                $data = elements(
                        array(
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'username',
                    'active',
                    'password',
                        ), $this->input->post()
                );

                $data = $this->security->xss_clean($data); // Ele limpa a variavel caso tenha elementos maliciosos no JavaScript
              
                /*Verifica se foi passado o password*/
                $password = $this->input->post('password');
                
                if(!$password) {
                    unset($data['password']);
                }

                if ($this->ion_auth->update($usuario_id, $data)) {

                    $perfil_usuario_db = $this->ion_auth->get_users_groups($usuario_id)->row();

                    $perfil_usuario_post = $this->input->post('perfil_usuario');

                    /*Se for diferente, atualiza o grupo*/
                    if ($perfil_usuario_db->id != $perfil_usuario_post) {

                        $this->ion_auth->remove_from_group($perfil_usuario_db->id, $usuario_id);
                        $this->ion_auth->add_to_group($perfil_usuario_post, $usuario_id);

                    }

                    $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
                }else {
                    $this->session->set_flashdata('error', 'Erro ao salvar os dados');
                }

                if($this->ion_auth->is_admin()) {
                    redirect('usuarios');
                }else {
                    redirect('dashboard');
                }
                
            }else {
                $data = array(
                    'title' => 'Editar usuário',
                    'usuario' => $this->ion_auth->user($usuario_id)->row(),
                    'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                );
    
                $this->load->view('layout/header', $data);
                $this->load->view('usuarios/edit');
                $this->load->view('layout/header');
            }
        }       
    }

    public function del($usuario_id = NULL) {

        if(!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar este menu Usuários');
            redirect('dashboard');
        }
        
        if(!$usuario_id || !$this->ion_auth->user($usuario_id)->row()) {
            $this->session->set_flashdata('error', 'Usuário não encontrado');
            redirect('usuarios');
        }

        if($this->ion_auth->is_admin($usuario_id)) {
            $this->session->set_flashdata('error', 'O administrador não pode ser excluído');
            redirect('usuarios');
        }
        if($this->ion_auth->delete_user($usuario_id)) {
            $this->session->set_flashdata('sucesso', 'Usuário excluído com sucesso');
            redirect('usuarios');
        }else {
            $this->session->set_flashdata('error', 'O funcionario não pode ser excluído');
            redirect('usuarios');
        }
    }

    public function email_check($email) {

        $usuario_id = $this->input->post('usuario_id');

        if ($this->core_model->get_by_id('users', array('email'=> $email, 'id !=' => $usuario_id))) {

            $this->form_validation->set_message('email_check', 'Este e-mail já existe.');
            
            return FALSE;

        }else {
            return TRUE;
        }

    }

    public function username_check($username) {

        $usuario_id = $this->input->post('usuario_id');

        if ($this->core_model->get_by_id('users', array('username'=> $username, 'id !=' => $usuario_id))) {

            $this->form_validation->set_message('username_check', 'Este usuário já existe.');
            
            return FALSE;

        }else {
            return TRUE;
        }

    }
}