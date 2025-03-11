<?php

    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
    use app\core\Request;

    /**
     * Class SiteController
     *
     * Handles the site's main pages and contact functionality.
     */
    class SiteController extends Controller
    {
        /**
         * Renders the home page.
         *
         * @return string The rendered home page view.
         */
        public function home(): string
        {
            $params = [
                'name' => sessionGet('user')->first_name ?? 'Guest',
            ];
            return $this->render('home', $params);
        }

        /**
         * Renders the contact page.
         *
         * @return string The rendered contact page view.
         */
        public function contact(): string
        {
            return $this->render('contact');
        }

        /**
         * Handles the submission of the contact form.
         *
         * @param Request $request The HTTP request instance containing form data.
         * @return array The submitted form data.
         */
        public function handleContact(Request $request): array
        {
            $body = $request->getBody();
            return $body;
        }
    }
