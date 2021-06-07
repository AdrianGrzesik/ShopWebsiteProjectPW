<?php

class home {

    public function homePage() {
        $view = new views('home');
        return $view->render();
    }

    public function contactPage() {
        $view = new views('contact');
        return $view->render();
    }

}