<?php

    namespace app\controllers;

    use app\core\Controller;
    use app\core\Request;
    use app\models\Message;
    use app\requests\ContactUsRequest;
    use app\core\form\Form;

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
        public function contact(Request $request): string
        {
            $message = new Message();
            if ($request->isPost()) {
                $data = $request->getBody();
                $contactRequest = new ContactUsRequest();

                // Validate the request
                
                $validation = $contactRequest->validate($data);

                $message->name = $contactRequest->input('name');
                $message->email = $contactRequest->input('email');
                $message->subject = $contactRequest->input('subject');
                $message->message = $contactRequest->input('message');

                if (!$validation) {
                    $message->errors = $contactRequest->getErrors();
                } else {
                    $message->create();
                    sessionFlashSet('success', 'Thanks for contacting us.');
                    redirect('/contact');
                }
            
            }
            return $this->render('contact',[
                'model' => $message,
                'form' => new Form(),
            ]);
        }
    }
