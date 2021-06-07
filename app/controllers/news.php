<?php

class news {

    public function newsList($active_page = null) {

        if(!$active_page)
            $active_page = 1;

        $news_q = newsModel::where('name','<>','');

        $news_count = $news_q->count();
        $per_page = 12;

        $pages_count = floor($news_count/$per_page);
        if($news_count%$per_page!=0)
            $pages_count++;

        $offset = $active_page*$per_page-$per_page;

        $news = $news_q->limit($offset, $per_page)->get();

        $view = new views('news_list');
        $view->with('news',$news);
        $view->with('pages_count',$pages_count);
        return $view->render();
    }

    public function newsDetails($news_name) {
        $news = newsModel::where('code_name','=',$news_name)->first();
        if($news) {

            $error = [];
            if(users::check()&&request::exist('comment_desc','post')) {
                $comment_desc = clearInputString(request::get('comment_desc','post'));
                if($comment_desc=='')
                    $error['comment_desc'] = 'Wpisz treść komentarza';

                if(!count($error)) {
                    $user = users::getUser();
                    newsCommentModel::create([
                        'news_id'=>$news->id,
                        'user_id'=>$user->id,
                        'added_date'=>date('Y-m-d G:i:s'),
                        'comment'=>$comment_desc
                    ]);
                }
            }

            $comments = newsCommentModel::where('news_id','=',$news->id)->select([
                'added_date',
                'comment',
                '(select users.email from users where users.id = news_comments.user_id ) as user_email '
            ])->get(false);

            $view = new views('news_details');
            $view->with('news',$news);
            $view->with('comments',$comments);
            $view->with('error',$error);
            return $view->render();
        }
        else {
            $view = new views('404');
            return $view->render();
        }
    }

    public function adminList() {
        $news = newsModel::get();

        $view = new views('admin_news_list');
        $view->with('news',$news);
        return $view->render();
    }

    public function adminForm($news_id = null) {

        $error = [];

        if(!$news_id) {
            $name = '';
            $description = '';
        }
        else {
            $product = newsModel::find($news_id);
            if($product) {
                $name = $product->name;
                $description = $product->description;
            }
            else
                redirect('/admin-artykuly');
        }

        if(request::exist('name','post')) {

            $name = request::get('name','post');
            if($name=='')
                $error['name'] = 'Podaj nazwę produktu';

            $description = request::get('description','post');
            if($description=='')
                $error['description'] = 'Podaj opis produktu';

            if(count($error)==0) {
                if(!$news_id) {
                    newsModel::create([
                        'name' => $name,
                        'code_name' => codeLinkSpecialChars($name),
                        'description' => $description,
                        'added_date' => date('Y-m-d G:i:s')
                    ]);
                }
                else {
                    $product->name = $name;
                    $product->code_name = codeLinkSpecialChars($name);
                    $product->description = $description;
                    $product->save();
                }

                redirect('/admin-artykuly');
            }
        }

        $view = new views('admin_news_form');
        $view->with('name',$name);
        $view->with('description',$description);
        $view->with('error',$error);
        return $view->render();
    }

    public function adminDelete($prod_id) {
        $news = newsModel::find($prod_id);
        if($news) {
            $news->delete();
        }

        redirect('/admin-artykuly');
    }

    

}