<?php 

require_once(APPPATH.'core/MY_AlumniController.php');

class Recommendations extends MY_AlumniController {

	public function __construct()
	{
		parent::__construct();

		if(! User::current()->has_suggestion())
		{
			Alert::push('warning', 'Anda harus mengisi form kritik dan saran terlebih dahulu');
			redirect('suggestions/form');
		}
	}

	protected function view($template)
	{
		return parent::view($template)
			->set('active', 'recommendations')
			;
	}

	public function get_index()
	{
		if(! User::current()->has_recommendations())
			redirect('recommendations/form');
		
		redirect('recommendations/view');
	}

	public function get_form()
	{
		$this->view('recommendations/form')
			->prepend('Form 5: Rekomendasi')
			->display();
	}

	public function post_form()
	{
		extract($this->input->post());

		if($name == '' OR $address == '' OR $classyear == '' OR $contact == '')
		{
			Alert::push('error', 'Lengkapi form dan klik submit.');
			redirect_back();
		}

		Recommendation::add($this->input->post());

		$count = User::current()->recommendations_count();
		if($count < 3)
		{
			Alert::push('success', 'Rekomendasi telah terkirim, 
				silakan tambahkan <strong>'. (3 - $count) .' rekomendasi lagi</strong>');
			redirect_back();
		}
		else
		{
			Alert::push('success', 'Terima kasih telah mengisi seluruh form penelusuran studi ini.');
			redirect('recommendations/view');	
		}

	}

	public function get_view()
	{
		$this->view('recommendations/view')
			->prepend('Rekomendasi Anda')
			->display();
	}
}