<?php

use lib\ApplicationDB;

class Visit
{

    public function __construct()
    {       
        $conection = new ApplicationDB();
        $conection->query("WITH upsert AS (UPDATE visit SET count=count+1 WHERE data=current_date RETURNING *)
        INSERT INTO visit (data, count) SELECT current_date, 1 WHERE NOT EXISTS (SELECT * FROM upsert);");
    }
 
}