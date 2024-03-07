<?php

namespace App\Repositories\Interfaces;

use App\Models\BookDetail;

interface BookDetailsRepositoryInterface {


    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */
    public  function addbook($data) ;

    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */
    public function fetchallbook();

    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */

    public function findbook($id);

    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */ 

    public function updatebook($data);

    /**
    * Desciption : 
    *
    * @param :
    * @return : 
    */

    public function deletebook($id);


}
?>