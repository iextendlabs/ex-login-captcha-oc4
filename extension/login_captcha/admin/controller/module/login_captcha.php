<?php
namespace Opencart\Admin\Controller\Extension\LoginCaptcha\Module;
/**
 * Class LoginCaptcha
 *
 * @package  Opencart\Admin\Controller\Extension\LoginCaptcha\Module
 */
class LoginCaptcha extends \Opencart\System\Engine\Controller {
    /**
     * Index 
     *
     * @return void
     */
    public function index(): void {
        $this->load->language('extension/login_captcha/module/login_captcha');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/login_captcha/module/login_captcha', 'user_token=' . $this->session->data['user_token'])
        ];

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['module_login_captcha_status'] = $this->config->get('module_login_captcha_status');


        $data['action'] = $this->url->link('extension/login_captcha/module/login_captcha.save', 'user_token=' . $this->session->data['user_token']);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/login_captcha/module/login_captcha', $data));
    }
    
    public function save(): void {
        $this->load->language('extension/login_captcha/module/login_captcha');
        $this->load->model('setting/setting');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->model_setting_setting->editSetting('module_login_captcha', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect(
                $this->url->link('extension/login_captcha/module/login_captcha', 'user_token=' . $this->session->data['user_token'])
            );
        }
    }
}
