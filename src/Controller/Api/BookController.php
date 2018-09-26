<?php

namespace App\Controller\Api;


use App\Entity\Book;

class BookController
{

    public function __invoke(Book $data): Book
    {
        /*
         * we can do something here, call other services, send an email, ...
         */

        return $data;
    }
}
