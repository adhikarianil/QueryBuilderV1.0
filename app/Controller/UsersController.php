<?php
class UsersController extends AppController {
	var $components = array('RequestHandler');
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout', 'change_password', 'remember_password', 'remember_password_step_2');
	}

	public function index() {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You're now allowed to do this.");
		}
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		$this->set('data',"hello world");
		// this is a controller code for 
		$db = ConnectionManager::getDataSource("default"); // name of your database connection
		$places_of_interest = $db->fetchAll("show  all databases"); // ..
		$this->set('data',$places_of_interest); // stores the data into the array places of interest
		
	}

	public function login() {
$this->layout='user_login'; // sets the layout that will be used. if specified null,set login layout to null meaning by no layout is used js,css are all not set
//$this->autoRender=false; //disable auto css taken from default.ctp

		if ($this->request->is('post')) {
			try {
				# Retrieve user username for auth
				$this->request->data['User']['username'] = $this->User->getUsername($this->request->data['User']['email']);
			} catch (Exception $e) {
				# In case that this email dont exists in database
				$this->Session->setFlash($e->getMessage(), 'flash_fail');
				$this->redirect('/');
			}
			 
			 
			# Try to log in the user
			if ($this->Auth->login()) {
				if (!empty($this->request->data['User']['remember_me']) && $this->request->data['User']['remember_me'] == 'S') {
					$cookie = array();
					$cookie['username'] = $this->request->data['User']['username'];
					$cookie['password'] = $this->Auth->password($this->request->data['User']['password']);

					# Write cookie ( 30 Days )
					$this->Cookie->write('Auth.User', $cookie, true);
				}
				$this->redirect('/');

				# Redirect to home
				#$this->redirect($this->Auth->redirectUrl());
				
				
			} else {
				$this->Session->setFlash(__('Invalid username or password, try again'), 'flash_fail');
			}
		}
	}

	public function show_databases(){
	$this->set('data',"hello world");
			 }
	public function logout() {
		# Destroy the Cookie
		$this->Cookie->delete('Auth.User');

		# Destroy the session
		$this->redirect($this->Auth->logout());
	}


	public function view($username = null) {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You're now allowed to do this.");
		}

		$user = $this->User->findByUsername($username);
		$user = Hash::extract($user,'User');
		$this->User->id = $user['id'];

		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $user);
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();

			if ($this->User->save($this->request->data)) {
				if( AuthComponent::user('id') ) {
					# Store log
					CakeLog::info('The user '.AuthComponent::user('username').' (ID: '.AuthComponent::user('id').') registered user (ID: '.$this->User->id.')','users');
				}
				$this->Session->setFlash(__('The user has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				# Create a loop with validation errors
				$this->Error->set($this->User->invalidFields());
			}
		}
		$this->set('label', 'Register user');
		$this->render('_form');
	}

	public function edit($id = null) {

		# If its not an admin, he will edit his own profile only
		if (AuthComponent::user('role') != 'admin' || empty($id)) {
			$id = AuthComponent::user('id');
			$this->set('user', AuthComponent::user());
		} else {
			$this->User->id = $id;

			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			$this->set('user', $user = Hash::extract($this->User->findById($id),'User'));
		}


		if ($this->request->is('post') || $this->request->is('put')) {
			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
			}

			if ($this->User->save($this->request->data)) {
				# Store log
				CakeLog::info('The user '.AuthComponent::user('username').' (ID: '.AuthComponent::user('id').') edited user (ID: '.$this->User->id.')','users');

				$this->Session->setFlash(__('The user has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_fail');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
		$this->set('label', 'Edit user');
		$this->render('_form');
	}

	public function delete($id = null) {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You're now allowed to do this.");
		}

		$this->User->id = $id;

		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->User->delete()) {
			# Store log
			CakeLog::info('The user '.AuthComponent::user('username').' (ID: '.AuthComponent::user('id').') deleted user (ID: '.$this->User->id.')','users');

			$this->Session->setFlash(__('User deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('User was not deleted'), 'flash_fail');

		$this->redirect(array('action' => 'index'));
	}


	public function change_password() {
		$user = $this->User->read(null, AuthComponent::user('id'));
		$this->set('user', $user);

		if ($this->request->is('post')) {
			# Verify if password matches
			if ($this->request->data['User']['password'] === $this->request->data['User']['re_password']) {
				# Verify if user is logged in
				if (AuthComponent::user('id')) {
					$this->request->data['User']['id'] = AuthComponent::user('id');
				} else # Maybe hes comming from change password form
				{
					# Check the hash in database
					$user = $this->User->findByHashChangePassword($this->request->data['User']['hash']);

					if (!empty($user)) {
						$this->request->data['User']['id'] = $user['User']['id'];

						# Clean users hash in database
						$this->request->data['User']['hash_change_password'] = '';
					} else {
						throw new MethodNotAllowedException(__('Invalid action'));
					}
				}

				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash('Password updated successfully!', 'flash_success');
					$this->redirect(array('/home'));
				}
			} else {
				$this->Session->setFlash('Passwords do not match.', 'flash_fail');
			}
		}
	}


	/**
	 * Email form to inform the process of remembering the password.
	 * After entering the email is checked if this email is valid and if so, a message is sent containing a link to change your password
	 */
	public function remember_password() {
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);

			if (empty($user)) {
				$this->Session->setFlash('This email does not exist in our database.', 'flash_fail');
				$this->redirect(array('action' => 'login'));
			}

			$hash = $this->User->generateHashChangePassword();

			$data = array(
				'User' => array(
					'id' => $user['User']['id'],
					'hash_change_password' => $hash
				)
			);

			$this->User->save($data);

			$email = new CakeEmail();
			$email->template('remember_password', 'default')
					->config('gmail')
					->emailFormat('html')
					->subject(__('Remember password - ' . Configure::read('Application.name')))
					->to($user['User']['email'])
					->from(Configure::read('Application.from_email'))
					->viewVars(array('hash' => $hash))
					->send();

			$this->Session->setFlash('Check your e-mail to continue the process of recovering password.', 'flash_success');

		}
	}

	/**
	 * Step 2 to change the password.
	 * This step verifies that the hash is valid, if it is, show the form to the user to inform your new password
	 */
	public function remember_password_step_2($hash = null) {

		$user = $this->User->findByHashChangePassword($hash);

		if ($user['User']['hash_change_password'] != $hash || empty($user)) {
			throw new NotFoundException(__('Link invalid'));
		}

		# Sends the hash to the form to check before changing the password
		$this->set('hash', $hash);

		$this->render('/Users/change_password');

	}
	
	
	public function showtable($param)
	{
		$this->Session->write('database.select', $param);
		$this->User->query("use $param");
	$data=$this->User->query("show tables");
	$this->set('data',$data);
	$this->set('databasename',$param);
	}
	
	public function listfields(){
		$this->request->onlyAllow('Ajax');
		$database=$this->Session->read('database.select');
		$this->User->query("use $database");
		$param=$this->request->data['tableid'];
		$data=$this->User->query("DESCRIBE $param"); // display fields of table $param holds table name
		$this->autoRender=false;
		$this->layout = 'ajax';
		return json_encode($data);
		
		
	}
        public function listfieldsdata(){
		
		$this->request->onlyAllow('Ajax');
                //$connection = ConnectionManager::get('default');
		$database=$this->Session->read('database.select');
		$this->User->query("use $database");
		$param=$this->request->data['tableid'];
                //$param="users";
                //$field="id,username";
                $field=$this->request->data['tablefield'];
                //$data = $connection->execute('DESC test')->fetchAll('assoc');
                
                //$data=$this->User->query("DESCRIBE $param");
                $data=$this->User->query("select $field from  $param"); 
		//$data=$this->User->query("Select count(*) from users"); // display fields of table $param holds table name
		$this->autoRender=false;
		$this->layout = 'ajax';
		return json_encode($data);
		
	}


	public function profile(){
	}

}

?>
