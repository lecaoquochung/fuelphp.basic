<?php

class Controller_Comments extends Controller_Template
{

//	public function action_edit()
//	The edit function will take in two parameters: a comment id and message id.
	public function action_edit($id = null, $message_id = null)
	{
//		use the comment model to find the comment, based on its id.
		$comment = Model_Comment::find($id);
//		pretty much the same as creating a comment with a few minor tweaks admin_create
		if (Input::post())
	    {
	        $comment->name = Input::post('name');
	        $comment->comment = Input::post('comment');
	        $comment->message_id = $message_id;
	        if ($comment->save())
	        {
	            Session::set_flash('success', 'Updated comment #'.$id);
	            Response::redirect('messages/view/'.$comment->message_id);
	        }
	        else
	        {
	            Session::set_flash('error', 'Could not update comment #'.$id);
	        }
	    }
	    else
	    {
	        $this->template->set_global('comment', $comment, false);
	    }
		$this->template->title = 'Comments &raquo; Edit';
		$this->template->content = View::forge('comments/edit', $data);
	}

//	public function action_create()
	public function action_create($id = null)
	{
		/*
		*	Notice that we are setting the $id to null by default. 
		*	Now we need to check to make sure that they’ve completed the form, so we add an if statement:
		*
		*	This is using Fuel’s Input class, but we could have just as easily used "if ($_POST)” as well.
		*/
		if (Input::post()) //if ($_POST)
	    {
//			build a new comment model in order to save the comment into the database.
			$comment = Model_Comment::forge(array(
	            'name' => Input::post('name'),
	            'comment' => Input::post('comment'),
	            'message_id' => Input::post('message_id'),
	        ));
			
//			$comment is now an object that has the comment information in it, so we need to try and save the comment:
			if ($comment and $comment->save()) // ‘And’ is used here instead of ‘&&’ because it’s part of the Fuel coding standards. http://fuelphp.com/docs/general/coding_standards.html#comparison_logical
	        {
				/*
				http://fuelphp.com/docs/classes/session/usage.html#method_set_flash
				If the if statement is successful, it will save the comment to the database, 
				so we should now set a flash to show that to the user. 
				Session Flashes are for information with a limited lifespan, such as presenting success or failure information.
				So we can set our flash and redirect our user back to the message they were viewing:
				*/
				Session::set_flash('success', 'Added comment #'.$comment->id.'.');
            	Response::redirect('messages/view/'.$comment->message_id);
			 
	        }
			else
	        {
	            Session::set_flash('error', 'Could not save comment.');
	        }
	    }
		else
	    {
//		This means if they didn’t post anything, take the $id and turn it into a variable called $message that the view can use.
	        $this->template->set_global('message', $id, false);
	    }
		
		$this->template->title = 'Comments &raquo; Create';
		
		$views = array();
		$views['form'] = View::forge('comments/_form');
	 
		$this->template->content = View::forge('comments/create', $views);
	}
	
	// $comment->delete() instead of $comment->save(). Don't forget to pass the comment and message id!
	public function action_delete($id, $message_id)
	{
	    if ($comment = Model_Comment::find($id))
	    {
	        $comment->delete();
	        Session::set_flash('success', 'Deleted comment #'.$id);
	    }
	    else
	    {
	        Session::set_flash('error', 'Could not delete comment #'.$id);
	    }
	    Response::redirect('messages/view/'.$message_id);
	}

}
