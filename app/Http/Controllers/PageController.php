<?php
namespace App\Http\Controllers;
use App\Page;

class PageController extends Controller {

	public $page;
	
	/**
	 * Display a listing of pages
	 *
	 * @return Response
	 */
	public function __construct(Page $page)
	{
		$this->page = $page;	
	}
	
	
	public function index()
	{
		$pages = $this->page->all();

		return View::make('pages.index', compact('pages'));
	}

	/**
	 * Show the form for creating a new page
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('pages.create');
	}

	/**
	 * Store a newly created page in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), $this->page->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$this->page->create($data);

		return Redirect::route('pages.index');
	}

	/**
	 * Display the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		
		$page =$this->page->where('slug','=',$slug)->get();


		return View::make('pages.show', compact('page'));
	}

	/**
	 * Show the form for editing the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = $this->pge->find($id);

		return View::make('pages.edit', compact('page'));
	}

	/**
	 * Update the specified page in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$page = $this->page->findOrFail($id);

		$validator = Validator::make($data = Input::all(), $this->page->rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$page->update($data);

		return Redirect::route('pages.index');
	}

	/**
	 * Remove the specified page from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->page->destroy($id);

		return Redirect::route('pages.index');
	}
	
	public function form()
	{
		
		$validator = Validator::make($data = Input::all(), $this->page->rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		if(! $email_test = $this->checkValidEmail($data['email']))
		{
			return Redirect::back()->withErrors(['email'=>'Are you sure!'])->withInput();
		}
		
		$this->page->sendFormEmails($data);
		return View::make('pages.response', compact('data'));
		
	}
	

	 public function checkValidEmail($email)
    {
        $email_test = false;
        $access_key = '2a13670597eadb7cc5495aef7e8d75ae';



// Initialize CURL:
		$ch = curl_init('http://apilayer.net/api/check?access_key='.$access_key.'&email='.$email.'');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Store the data:
		$json = curl_exec($ch);
		curl_close($ch);

		// Decode JSON response:
		$validationResult = json_decode($json, true);

// Access and use your preferred validation result objects
		if( ! $validationResult["mx_found"])
		{
			return $email_test;
		}
		
		if( $validationResult["catch_all"])
		{
			return $email_test;
		}
		if( $validationResult["disposable"])
		{
			return $email_test;
		}

		if( $validationResult["score"] < .60)
		{
			
			return $email_test;
		}
		  
		$email_test = true;

        return $email_test;
	}

	
	public function privacy()
	{
		return View::make('pages.privacy');
		
	}
}
