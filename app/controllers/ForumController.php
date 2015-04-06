<?php
class ForumController extends BaseController {
    public function index() {
	$groups = ForumGroup::all();
	$categories = ForumCategory::all();
	return View::make('forum.index')
            ->with('groups', $groups)
            ->with('categories', $categories);
    }
    public function category($id) {
	$category = ForumCategory::find($id);
	if ($category == null) {
            return Redirect::route('forum-home')
                ->with('fail', "That category doesn't exist.");
	}
	$threads = $category->threads()->get();
	return View::make('forum.category')
            ->with('category', $category)
            ->with('threads', $threads);
    }
    public function thread($id) {
	$thread = ForumThread::find($id);
	if ($thread == null) {
            return Redirect::route('forum-home')
                ->with('fail', "That thread doesn't exist.");
	}
	$author = $thread->author()->first()->username;
	return View::make('forum.thread')
            ->with('thread', $thread)
            ->with('author', $author);
    }
    public function storeGroup() {
	$validator = Validator::make(Input::all(), array(
            'group_name' => 'required|unique:forum_groups,title'
	));
	if ($validator->fails()) {
            return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal', '#group_form');
	} else {
            $group = new ForumGroup;
            $group->title = Input::get('group_name');
            $group->author_id = Auth::user()->id;
            if($group->save()) {
		return Redirect::route('forum-home')
                    ->with('success', 'The group was created');
            } else {
		return Redirect::route('forum-home')
                    ->with('fail', 'An error occured while saving the new group.');
            }
	}
    }
    public function deleteGroup($id) {
	$group = ForumGroup::find($id);
	if($group == null) {
            return Redirect::route('forum-home')
                ->with('fail', 'That group doesn\'t exist.');
	}
	$categories = $group->categories();
	$threads = $group->threads();
	$comments = $group->comments();
	$delCa = true;
	$delT = true;
	$delCo = true;
	if($categories->count() > 0) {
            $delCa = $categories->delete();
	}
	if($threads->count() > 0) {
            $delT = $threads->delete();
	}
	if($comments->count() > 0) {
            $delCo = $comments->delete();
        }
	if ($delCa && $delT && $delCo && $group->delete()) {
            return Redirect::route('forum-home')
                ->with('success', 'The group was deleted.');
	} else {
            return Redirect::route('forum-home')
                ->with('fail', 'An error occured while deleting the group.');
	}
    }
    public function deleteCategory($id) {
	$category = ForumCategory::find($id);
	if($category == null) {
            return Redirect::route('forum-home')
                ->with('fail', 'That category doesn\'t exist.');
	}
	$threads = $category->threads();
	$comments = $category->comments();
	$delT = true;
	$delCo = true;
	if($threads->count() > 0) {
            $delT = $threads->delete();
	}
	if($comments->count() > 0) {
            $delCo = $comments->delete();
	}
	if ($delT && $delCo && $category->delete()) {
            return Redirect::route('forum-home')
                ->with('success', 'The category was deleted.');
	} else {
            return Redirect::route('forum-home')
                ->with('fail', 'An error occured while deleting the category.');
	}
    }
    public function storeCategory($id) {
	$validator = Validator::make(Input::all(), array(
            'category_name' => 'required'
	));
	if ($validator->fails()) {
            return Redirect::route('forum-home')
                ->withInput()
                ->withErrors($validator)
                ->with('category-modal', '#category_modal')
                ->with('group-id', $id);
	} else {
            $group = ForumGroup::find($id);
            if ($group == null) {
		return Redirect::route('forum-home')
                    ->with('fail', "That group doesn't exist.");
            }
            $category = new ForumCategory;
            $category->title = Input::get('category_name');
            $category->author_id = Auth::user()->id;
            $category->group_id = $id;
            if($category->save()) {
		return Redirect::route('forum-home')
                    ->with('success', 'The category was created');
            } else {
		return Redirect::route('forum-home')
                    ->with('fail', 'An error occured while saving the new category.');
            }
	}
    }
    public function storeThread($id) {
	$category = ForumCategory::find($id);
        if ($category == null) {
            return Redirect::route('forum-home')
               ->with('fail', "You posted to an invalid category.");
	}
	$validator = Validator::make(Input::all(), array(
            'thread_title'	=>	'required|min:2|max:255',
            'thread_body'	=>	'required|max:65000'
	));
	if ($validator->fails()) {
            return Redirect::route('forum-category', $id)
                ->withInput()
                ->withErrors($validator)
                ->with('modal', '#thread_form');
	} else {
            $thread = new ForumThread;
            $thread->title = Input::get('thread_title');
            $thread->body = Input::get('thread_body');
            $thread->category_id = $id;
            $thread->group_id = $category->group_id;
            $thread->author_id = Auth::user()->id;
            if ($thread->save()) {
		return Redirect::route('forum-thread', $thread->id)
                    ->with('success', "Your thread has been saved.");
            } else {
		return Redirect::route('forum-category', $id)
                    ->with('fail', "An error occured while saving your thread.");
            }
	}
    }
    public function deleteThread($id) {
	$thread = ForumThread::find($id);
	if ($thread == null) {
            return Redirect::route('forum-home')
                ->with('fail', "That thread doesn't exist");
	}
	$category_id = $thread->category_id;
	$comments = $thread->comments;
	if ($comments->count() > 0) {
            foreach ($comments as $coment) {
                $coment->delete();
            }
            if ($comments->count() == 0 && $thread->delete()){
		return Redirect::route('forum-category', $category_id)
                    ->with('success', "The thread was deleted.");
            } else {
		return Redirect::route('forum-category', $category_id)
                    ->with('fail', "An error occured while deleting the thread.");
            }
	} else {
            if ($thread->delete()) {
		return Redirect::route('forum-category', $category_id)
                    ->with('success', "The thread was deleted.");
            } else {
		return Redirect::route('forum-category', $category_id)
                    ->with('fail', "An error occured while deleting the thread.");
            }
	}
    }
    public function storeComment($id) {
	$thread = ForumThread::find($id);
	if ($thread == null) {
            Redirect::route('forum')
                ->with('fail', "That thread does not exist.");
	}
	$validator = Validator::make(Input::all(), array(
            'body' => 'required|min:1'
	));
	if ($validator->fails()) {
            return Redirect::route('forum-thread', $id)
                ->withInput()
                ->withErrors($validator)
                ->with('fail', "Please fill in the form correctly.");
	} else {
            $comment = new ForumComment();
            $comment->body = Input::get('body');
            $comment->author_id = Auth::user()->id;
            $comment->thread_id = $id;
            $comment->category_id = $thread->category->id;
            $comment->group_id = $thread->group->id;
            if ($comment->save()) {
		return Redirect::route('forum-thread', $id)
                    ->with('success', "The comment was saved.");
            } else {
		return Redirect::route('forum-thread', $id)
                    ->with('fail', "An error occured wile saving.");
            }
	}
    }
    public function deleteComment($id) {
	$comment = ForumComment::find($id);
	if ($comment == null) {
            return Redirect::route('forum')
                ->with('fail', "That comment does not exist.");
	}
	$threadid = $comment->thread->id;
	if ($comment->delete()) {
            return Redirect::route('forum-thread', $threadid)
                ->with('success', "The comment was deleted.");
	} else {
            return Redirect::route('forum-thread', $threadid)
                ->with('fail', "An error occured while deleting the comment.");
	}
    }
    public function postLike($id) {
        $comment = ForumComment::find($id);
        if ($comment->isLike()) {
            $comment->likes()->where('user_id', Auth::user()->id)->delete();
        } else {
            CommentLike::insert(array(
                'user_id' => Auth::user()->id,
                'comment_id' => $id));
        }
        return $comment->likes()->get()->count();
    }
}