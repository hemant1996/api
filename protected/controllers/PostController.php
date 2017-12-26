<?php

class PostController extends Controller {

	public function actionIndex() {
		$criteria = new CDbCriteria;
		$criteria->select = array('id', 'author_name', 'title', 'contents', 'category');
		$posts = Post::model()->findAll($criteria);
		$json = CJSON::encode($posts);
		echo $json;
	}
	public function actionPview($id) {

		$posts = Post::model()->findByPk($id);
		$data = array(
			'id' => $posts->id,
			'author' => $posts->author_name,
			'title' => $posts->title,
			'content' => $posts->contents,
			'category' => $posts->category,
		);
		$data['comments'] = array();
		foreach ($posts->comments as $c) {
			$arr = array(
				'id' => $c->id,
				'comment' => $c->content,
				'author' => $c->author_name);
			array_push($data['comments'], $arr);
		}
		$json = CJSON::encode($data);
		echo $json;

	}

	public function actionCview($id) {

		$post = Comment::model()->findByPk($id);
		$json = CJSON::encode($post);
		$length = count($json);
		echo $json;
	}
	public function actionPcreate($id, $auth, $titl, $contnt, $catego) {
		$retstatus = array();
		$post = new Post;
		if ($post->exists("title=:title", array(':title' => $titl))) {
			$retstatus['statusCode'] = 0;
			$retstatus['statusMessage'] = "This Post already exists";
		} else {
			Post::create(array(
				"id" => $id,
				"author_name" => $auth,
				"title" => $titl,
				"contents" => $contnt,
				"category" => $catego,
			));
			$retstatus['statusCode'] = 1;
			$retstatus['statusMessage'] = "Blog Post Successful";
		}

		echo CJSON::encode($retstatus);
	}
	public function actionCcreate($id, $pid, $auth, $comm) {
		$refstatus = array();
		Comment::create(array(
			"id" => $id,
			"author_name" => $auth,
			"post" => $pid,
			"content" => $comm,

		));
		$refstatus['statusCode'] = 1;
		$refstatus['statusMessage'] = "Comment Post Successful";
		echo CJSON::encode($refstatus);
	}

}
