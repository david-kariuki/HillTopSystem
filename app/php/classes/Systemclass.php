<?php
/**
* This class represents the system as a whole
* Any functionality that the system should automate or perform in reaction to users minimal interaction should go here.
* This represents the [app/php/config/functions.php] in an OOP format to enable code reuse
*/

// System class
trait Systemclass
{
    /**
    * This method takes in a token provided by other methods.
    * The token is verified against a system generated token to verify if the request comes from a valid user.
    * @param string $token
    * @return bool $verified
    */
    function verifyUser($token){
        $verified = false;
        /**
        * Code to verify goes here.
        * @todo generate code to verify.
        */
        return $verified;
    }


    /**
    * This method accepts a string as an input and returns a string as output.
    * when a string is passed with html sensitive characters, it returns an encoded string.
    * @param string $str_val
    * @return string $val
    */
    function encodeToHTML($strVal)
    {
        $val = htmlentities($strVal);
        return $val;
    }

    /**
    * This method decodes a string that is already encoded to html
    * @see [encodeToHTML()]
    * @param string $str_val
    * @return string $val
    */
    function decodeHTML($strVal)
    {
        $val = html_entity_decode($strVal);
        return $val;
    }

    
    public function unique_ID_generator(){
        $numbers1=range(0,9); // ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z']
        shuffle($numbers1);
        $numbers2=range(0,9);  // [0,1,2,3,4,5,6,7,8,9]
        shuffle($numbers2);
        $numbers3=range(0,9);  // [0,1,2,3,4,5,6,7,8,9]
        shuffle($numbers3);
        $string='';
        for($x=0; $x<3; ++$x){
            $string.=$numbers1[$x].$numbers2[$x].$numbers3[$x];
        }
        $result = (int)$string;
        return $result;
    }

    /**/
    public function token_generator(){

    }

    /**/
    public function notifications_checker(){

    }

    /**/
    public function inventory_checker(){

    }

    /**
     *This method is used universally to insert IDs and other fields that should not be null
     * @param string $table @example("TABLE_USERS['NAME']") this will ref the table name saved at constants @see[constants.php]
     * @param string $fieldsCombined @example ('UUID','firstName') this will ref the name of the fields the dat should be entered into in the database
     * @param string $placeHolders @example ("?,?,?") this should be characters used in the prepared statement as holders for values  
     * @param string $type @example("s,s,i,");
     * @param array $values @example(["allan","Nairobi"]) these are the values to be entered
     * @return array $result
     */
    public function insert_to_database($table,$fieldsCombined,$placeholders,$type,$values){
        $result = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );
        // Prepare INSERT statement
        $stmt = $this->connectToDB->prepare("INSERT INTO $table($fieldsCombined) VALUES($placeholders)");
        if (false == $stmt) {
            $result['responseCode'] = 101;
            $result['response'] = 'prepare_param() failed: ' . htmlspecialchars($this->connectToDB->error);
            return $result;
        }

        $bind = $stmt->bind_param($type, ...$values); // Bind parameters

        if(false == $bind){
            $result['responseCode'] = 102;
            $result['response'] = 'bind_param() failed: ' . htmlspecialchars($stmt->error);
            return $result;
        }
        $execute = $stmt->execute(); // Execute statement

        if(false == $execute){
            $result['responseCode'] = 103;
            $result['response'] = 'execute() failed: ' . htmlspecialchars($stmt->error);
            return $result;
        }

        $stmt->close(); // Close statement
        $result["status"] = true;
        $result["responseCode"] = 0;
        $result["response"] = "Records Were added Successfully";

        return $result;
    }

    /**/
    public function database_read($table,$fields,$order_by,$offset){
        // SELECT * FROM tbl_products ORDER BY productName ASC LIMIT 25 OFFSET $offset"

        $result = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );
        // Prepare INSERT statement
        $stmt = $this->connectToDB->prepare("SELECT $fields FROM $table ORDER BY $order_by ASC LIMIT 2 OFFSET $offset");
        if (false == $stmt) {
            $result['responseCode'] = 101;
            $result['response'] = 'prepare_param() failed: ' . htmlspecialchars($this->connectToDB->error);
            return $result;
        }

        $execute = $stmt->execute(); // Execute statement

        if(false == $execute){
            $result['responseCode'] = 103;
            $result['response'] = 'execute() failed: ' . htmlspecialchars($stmt->error);
            return $result;
        }

        $obj = $stmt->get_result();
        
        while ($data = $obj->fetch_assoc()){
            var_dump($data);
        }
    }

    /**/
    public function database_read_all($table,$fields,$order_by){
        // SELECT * FROM tbl_products ORDER BY productName ASC LIMIT 25 OFFSET $offset"

        $result = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );
        // Prepare INSERT statement
        $stmt = $this->connectToDB->prepare("SELECT $fields FROM $table ORDER BY $order_by ASC");
        if (false == $stmt) {
            $result['responseCode'] = 101;
            $result['response'] = 'prepare_param() failed: ' . htmlspecialchars($this->connectToDB->error);
            return $result;
        }

        $execute = $stmt->execute(); // Execute statement

        if(false == $execute){
            $result['responseCode'] = 103;
            $result['response'] = 'execute() failed: ' . htmlspecialchars($stmt->error);
            return $result;
        }

        $obj = $stmt->get_result();

        $response = array();
        
        while ($data = $obj->fetch_assoc()){
            array_push($response,$data);
        }

        return $response;
    }

    /**/
    public function database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference){
        //introduce variables
        $result = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>null
        );
        $temp_array = array();
        $statement = "SELECT ";
        $fields_combined = null;
        $values = null;
        $type = null;

        //check if fields is ana array
        if(is_array($fields)){

            /*
            if $fields is an array then the user intends to get specific fields
            as the response
            */

            // get the number of fields and render fields accordingly
            $array_count = count($fields);
            if($array_count < 0){
                $fields_combined = $fields; 
            } else {
                $fields_combined = implode(",", $fields);
            }
            $statement = $statement.$fields_combined." FROM ".$table;

            if(isset($reference)){
                $statement = $statement." WHERE ".$reference['statement'];
                $values = $reference['values'];
                $type = $reference['type'];
            }

            if($order_by != null && $order_set != null){
                $statement = $statement." ORDER BY ".$order_by." ".$order_set." LIMIT ".SPLITTER." OFFSET ".$offset;
            }else{
                $statement = $statement." LIMIT ".SPLITTER." OFFSET ".$offset;
            }

            

            $stmt =$this->connectToDB->prepare($statement);

            if (false == $stmt) {
                $result['responseCode'] = 101;
                $result['response'] = 'read prepare() failed: ' . htmlspecialchars($this->connectToDB->error);
                return $result;
            }

            if($reference != null){
                $bind = $stmt->bind_param($type, ...$values); // Bind parameters

                if(false == $bind){
                    $result['responseCode'] = 102;
                    $result['response'] = 'read bind_param() failed: ' . htmlspecialchars($stmt->error);
                    return $result;
                }
            }
            $execute = $stmt->execute(); // Execute statement

            if(false == $execute){
                $result['responseCode'] = 103;
                $result['response'] = 'read execute() failed: ' . htmlspecialchars($stmt->error);
                return $result;
            }

            $obj = $stmt->get_result();
            $resultset = $obj->fetch_all(MYSQLI_ASSOC);
            $num_row = count($resultset); 

            if($num_row > 0){

                foreach ($resultset as $row) {
                    array_push($temp_array,$row);
                }

                $result['status'] = true;
                $result['responseCode'] = 0;
                $result['response'] = $temp_array;
            } 

            return $result;

        }else{
            /*
            if $fields is not an array then the user intends to get all fields 
            as the response
            */
            return $fields;
        }
    }

    /**/
    public function database_update($table,$data_combined,$ID,$otherRef = null){
        
        $statement = null;

        if($otherRef == null){
            $statement = 'WHERE UUID = ?';
        }else{
            $statement = $otherRef;
        }
        $result = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );
        foreach($data_combined as $key => $value){
            $stmt = $this->connectToDB->prepare("UPDATE $table SET $key=? WHERE UUID = ?");
            if (false === $stmt) {
                $result['responseCode'] = 101;
                $result['response'] = 'update prepare_param() failed: ' . htmlspecialchars($this->connectToDB->error);
                return $result;
            }

            
            $rc = $stmt->bind_param($value[1], $value[0],$ID);
            if (false === $rc) {
                $result['responseCode'] = 102;
                $result['response'] = 'update bind_param() failed: ' . htmlspecialchars($stmt->error);
                return $result;
            }
            $rc = $stmt->execute();
            if (false === $rc) {
                $result['responseCode'] = 103;
                $result['response'] = 'update execute() failed: ' . htmlspecialchars($stmt->error);
                return $result;
            }

            $stmt->close(); 
        }

        $result["status"] = true;
        $result["responseCode"] = 0;
        $result["response"] = "Records Were added Successfully";

        return $result;
    }

    /**/
    public function database_delete($table,$data_combined,$ID,$otherRef = null){
        $statement = null;

        if($otherRef == null){
            $statement = 'WHERE UUID = ?';
        }else{
            $statement = $otherRef;
        }
        $result = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );
        foreach($data_combined as $key => $value){
            $stmt = $this->connectToDB->prepare("DELETE FROM $table $statement");
            if (false === $stmt) {
                $result['responseCode'] = 101;
                $result['response'] = 'update prepare_param() failed: ' . htmlspecialchars($this->connectToDB->error);
                return $result;
            }

            
            $rc = $stmt->bind_param($value[1], $value[0],$ID);
            if (false === $rc) {
                $result['responseCode'] = 102;
                $result['response'] = 'update bind_param() failed: ' . htmlspecialchars($stmt->error);
                return $result;
            }
            $rc = $stmt->execute();
            if (false === $rc) {
                $result['responseCode'] = 103;
                $result['response'] = 'update execute() failed: ' . htmlspecialchars($stmt->error);
                return $result;
            }

            $stmt->close(); 
        }

        $result["status"] = true;
        $result["responseCode"] = 0;
        $result["response"] = "Records Were updated Successfully";

        return $result;
    }

    /**/
    public function logOutUser(){

    }

    /** */
    public function curl_loader_text_return($url,$data){
        $ch = curl_init();
        $result = array(
            'status'=>0,
            'response'=> "error"
        );

        try {
            $ch = curl_init();
        
            // Check if initialization had gone wrong*    
            if ($ch === false) {
                throw new Exception('failed to initialize');
            }
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $content = curl_exec($ch);

            echo $content;
        
            // Check the return value of curl_exec(), too
            if ($content === false) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        
            /* Process $content here */
        
            // Close curl handle
            curl_close($ch);
        } catch(Exception $e) {
        
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }
    }

    public function curl_loader_json_return($url,$data){


    }
    public function csv_converter(array $array){
        if (count($array) == 0) {
            return null;
          }
          ob_start();
          $df = fopen("php://output", 'w');
          fputcsv($df, array_keys(reset($array)));
          foreach ($array as $row) {
             fputcsv($df, $row);
          }
          fclose($df);
          return ob_get_clean();
    }

    function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
    
        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
    
        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
}


// EOF : System.php