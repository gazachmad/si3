<?php

use App\Core\Controller;

class Auth extends Controller
{
	protected function middleware()
    {
        return ['auth'];
    }

	public function index()
	{
		$this->view->render('admin/auth/login');
	}

	public function register()
	{
		$this->view->render('admin/auth/register');
	}
}
