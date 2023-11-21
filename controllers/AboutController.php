<?php

/**
 * Description of AboutController
 *
 * @author jan
 */
class AboutController extends Controller {
    
        public function process(array $parameters): void
        {
            $this->head['title'] = 'O aplikaci';

            $this->view = 'about';
        }
}
