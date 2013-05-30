<?php
class Controller_Messages extends Controller_Template{

	public function action_index()
	{
//		put the view and messages into their own variables.
		$messages = Model_Message::find('all');
		
//		declare an array called $comment_links, and then loop through the messages
		$comment_links = array();
		
	    foreach ($messages as $message)
	    {
			/*
			We need to retrieve the comments associated with this particular message, 
			so we query the database for comments that match the message’s id. 
			So far we have been using models to retrieve information from the database, 
			and we could do that here using the Model's query method, but Fuel also has a DB class that we'd like to show you. 
			*/
			$query = DB::select()
            ->from('comments')
            ->where('message_id', $message->id)
            ->execute();
			
			/*
			The DB::select() method builds a SQL query to retrieve all the comments. 
			This is analogous to “SELECT * FROM 'comments' WHERE message_id = $message->id“
			
			We just need to count the number of results and add that number to the $comment_links array. 
			To make the message's comments easy to access, we’re going to make the comment array key match the message id:
			*/
			$count = count($results);
       		$comment_links[$message->id] = "View | $count Comment(s)";
	    }
		
    	$view = View::forge('messages/index');
	    $view->set('comment_links', $comment_links);
	    $view->set('messages', $messages);
	    $this->template->title = 'Messages';
	    $this->template->content = $view;
		
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('messages');
		
		if ( ! $data['message'] = Model_Message::find($id))
		{
			Session::set_flash('error', 'Could not find message #'.$id);
			Response::redirect('messages');
			return;
		}
		
		$comments = Model_Comment::query()->where('message_id', $id)->get();
 		
	    $data = array(
	        'message' => $message,
	        'comments' => $comments
	    );
		
		$this->template->title = "Message";
		$this->template->content = View::forge('messages/view', $data);
		
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Message::validate('create');
			
			if ($val->run())
			{
				$message = Model_Message::forge(array(
					'name' => Input::post('name'),
					'message' => Input::post('message'),
				));

				if ($message and $message->save())
				{
					Session::set_flash('success', 'Added message #'.$message->id.'.');

					Response::redirect('messages');
				}

				else
				{
					Session::set_flash('error', 'Could not save message.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Messages";
		$this->template->content = View::forge('messages/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('messages');

		if ( ! $message = Model_Message::find($id))
		{
			Session::set_flash('error', 'Could not find message #'.$id);
			Response::redirect('messages');
		}

		$val = Model_Message::validate('edit');

		if ($val->run())
		{
			$message->name = Input::post('name');
			$message->message = Input::post('message');

			if ($message->save())
			{
				Session::set_flash('success', 'Updated message #' . $id);

				Response::redirect('messages');
			}

			else
			{
				Session::set_flash('error', 'Could not update message #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$message->name = $val->validated('name');
				$message->message = $val->validated('message');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('message', $message, false);
		}

		$this->template->title = "Messages";
		$this->template->content = View::forge('messages/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('messages');

		if ($message = Model_Message::find($id))
		{
			$message->delete();

			Session::set_flash('success', 'Deleted message #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete message #'.$id);
		}

		Response::redirect('messages');

	}


}
