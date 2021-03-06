<?php
/**
* User class
* This class contains all the methods required by a user
*
* @author David Kariuki (dk)
* @author Peter Kimani (dk)
* @copyright Copyright (c) 2021 All Rights Reserved.
*/


// User class
class User
{
    use Systemclass; // Call System class
    use Catalogue; // Call System class

    // Connection status value variable
    private $connectToDB;       // Create DatabaseConnection class object

    public $UUID;
    public $firstName;
    public $lastName;
    public $otherName;
    public $gender;
    public $nationalId;
    public $Email;
    public $userName;
    public $password;
    public $Address;
    public $city;
    public $role;
    public $status;
    public $dateCreated;
    public $lastModified;


    /**
    * Class constructor
    */
    function __construct()
    {

        // Creating objects of the required classes

        // Initialize database connection class instance
        $connectionInstance = DatabaseConnection::getConnectionInstance();

        // Initialize connection object
        $this->connectToDB  = $connectionInstance->getDatabaseConnection();
    }


    /**
    * Class destructor
    */
    function __destruct()
    {

    }

    /**
    * Function to add user to the database
    *
    * @param
    *
    * TODO - Check if method runs
    *
    */
    public function addUserToDatabase($userData, $table)
    {

        $response = [
            false,
        ];

        // Check if user data is passed as array
        if (is_array($userData)) {

            $arrayCount = count($userData); // Get array count

            // Check array count length
            if ($arrayCount > 0) {
                $ID = $this->unique_ID_generator();

                $fields = array(); // Array to hold user data fields
                $values = array("MD_".$ID); // Array to hold user data values

                $fields = array(
                    TABLE_USERS['FIELD_USER_ID'],
                    TABLE_USERS['FIELD_EMAIL'],
                    TABLE_USERS['FIELD_USERNAME'],
                    TABLE_USERS['FIELD_ROLE'],
                );

                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                $fieldsCombined = "`".$fieldsCombined."`";
                $placeholders = "?,?,?,?";
                $type = "isss";
                $values = array(
                    $ID,
                    $userData['Email'],
                    $userData["userName"],
                    $userData["role"]
                );
                

                $insert = $this->insert_to_database($table,$fieldsCombined,$placeholders,$type,$values);

                if($insert["status"]){
                    $fields = array(
                        TABLE_USERS['FIELD_FIRST_NAME'],
                        TABLE_USERS['FIELD_LAST_NAME'],
                        TABLE_USERS['FIELD_OTHER_NAME'],
                        TABLE_USERS['FIELD_GENDER'],
                        TABLE_USERS['FIELD_NATIONAL_ID'],
                        TABLE_USERS['FIELD_PASSWORD'],
                        TABLE_USERS['FIELD_ADDRESS'],
                        TABLE_USERS['FIELD_CITY'],
                        TABLE_USERS['FIELD_STATUS'],
                        TABLE_USERS['FIELD_LOG_ID']
                    );
                    $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                    $fieldsCombined = "`".$fieldsCombined."`";

                    $placeholders = "?,?,?,?,?,?,?,?,?,?";

                    $values = array(
                        [$userData['firstName'],"si"],
                        [$userData['lastName'],"si"],
                        [$userData['otherName'],"si"],
                        [$userData['gender'],"si"],
                        [$userData['nationalId'],"si"],
                        [$userData['password'],"si"],
                        [$userData['Address'],"si"],
                        [$userData['city'],"si"],
                        [$userData['status'],"si"],
                        [$userData['logID'],"si"],
                    );

                    $data_combined = array_combine($fields,$values);

                    $update = $this->database_update($table,$data_combined,$ID);

                    if($update["status"]){
                        $fields = array(
                            "*",
                        );
                        $order_by = "firstName";
                        $order_set = "ASC";
                        $offset = 0;
                        $reference = array(
                            "statement" => "UUID = ?",
                            "type"=>"i",
                            "values"=>[
                                $ID
                            ]
                        );

                        $response = $this->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                        return $response;


                    }else {
                        return $update;
                    }
                } else {
                    return  $insert;
                }
            }
        }

        return $response; // Return response array
    }



    /**
    * Function to update user by reference
    *
    */
    public function updateUserByReference($userData, $table,$ID){
        if($userData){
            $fields = array(
                TABLE_USERS['FIELD_FIRST_NAME'],
                TABLE_USERS['FIELD_LAST_NAME'],
                TABLE_USERS['FIELD_OTHER_NAME'],
                TABLE_USERS['FIELD_EMAIL'],
                TABLE_USERS['FIELD_USERNAME'],
                TABLE_USERS['FIELD_ROLE'],
                TABLE_USERS['FIELD_GENDER'],
                TABLE_USERS['FIELD_NATIONAL_ID'],
                TABLE_USERS['FIELD_ADDRESS'],
                TABLE_USERS['FIELD_CITY'],
                TABLE_USERS['FIELD_STATUS'],
                
            );
            $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
            $fieldsCombined = "`".$fieldsCombined."`";

            $placeholders = "?,?,?,?,?,?,?,?,?,?,?";

            $values = array(
                [$userData['firstName'],"si"],
                [$userData['lastName'],"si"],
                [$userData['otherName'],"si"],
                [$userData['Email'],"si"],
                [$userData["userName"],"si"],
                [$userData["role"],"si"],
                [$userData['gender'],"si"],
                [$userData['nationalId'],"si"],
                [$userData['Address'],"si"],
                [$userData['city'],"si"],
                [$userData['status'],"si"],
                
            );

            $data_combined = array_combine($fields,$values);

            $update = $this->database_update($table,$data_combined,$ID);

            if($update["status"]){
                $fields = array(
                    "*",
                );
                $order_by = "firstName";
                $order_set = "ASC";
                $offset = 0;
                $reference = array(
                    "statement" => "UUID = ?",
                    "type"=>"i",
                    "values"=>[
                        $ID
                    ]
                );

                $response = $this->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                return $response;


            }else {
                return $update;
            }
        } else{

        }
    }

    /**
    * Function to delete user by reference
    */
    public function deleteUserByReference(){

    }

    /**
    * Sample get by ref
    */
    public function get_by_ref($fields, $table, $reference = null, $type = null ,$limit = null){

        $response = [
            false,
        ];

        $tempArray = array();

        // Check if fields is passed as array
        if (is_array($fields)) {

            $arrayCount = count($fields); // Get array count

            // Check array count length
            if ($arrayCount > 0) {

                $fieldsCombined = implode(",", $fields); // Join array elements with a comma
                $stmt = null; // Shared statement variable

                // Check if reference is set
                if (isset($reference)) {
                    // Reference set

                    $keys   = [];   // Keys array
                    $values = [];   // Values array

                    /**
                    * Loop through reference using &(reference) to name the value with a different name * or alias. References are a means to access the same variable content by different * names.
                    *
                    * @example - Just likes a person who has two different names.
                    */
                    foreach ($reference as &$val) {

                        array_push($keys, $val[0] . " = ?"); // Add to keys array
                        $myVal = $val[1];
                        array_push($values, $myVal); // Add to values array
                    }

                    $keysCombined = implode(" AND ", $keys); // Join array elements with a ' AND '

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare(
                        "SELECT $fieldsCombined FROM $table WHERE $keysCombined "
                    );

                    $stmt->bind_param($type, ...$values); // Bind parameters

                } else {
                    // Reference not set

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare("SELECT $fieldsCombined FROM $table");
                }

                $stmt->execute(); // Execute statement
                $result = $stmt->get_result(); // Get result
                $stmt->close(); // Close statement

                // Loop through result fetching associative array
                while ($data = $result->fetch_assoc()) {

                    array_push($tempArray, $data); // Add data to the end of temp array
                    $response[0] = true; // Set response at index 0 to true
                }

                array_push($response, $tempArray); // Add temp array to response
            }
        } else {

            if ($fields == "*") {
                // Selecting *

                // Check for reference
                if (isset($reference)) {
                    // Reference set

                    $keys   = [];   // Keys array
                    $values = [];   // Values array

                    // Loop through reference
                    foreach ($reference as &$val) {

                        array_push($keys, $val[0] . " = ?"); // Add to keys array
                        $myVal = $val[1];
                        array_push($values, $myVal); // Add to values array
                    }

                    $keysCombined = implode(" AND ", $keys); // Join array elements with a ' AND '

                    // Create statement
                    $statement = "select * from tbl_products where " . $keysCombined;

                    echo $statement; // Debug
                    exit(); // Debug

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare("SELECT * FROM $table WHERE $keysCombined ");
                    $stmt->bind_param($type, ...$values); // Bind parameters

                } else {
                    // Reference not set

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare("SELECT * FROM $table");
                }

                $stmt->execute(); // Execute statement
                $result = $stmt->get_result(); // Get result
                $stmt->close(); // Close statement

                // Loop through result fetching associative array
                while ($data = $result->fetch_assoc()) {

                    array_push($tempArray, $data); // Add data to the end of temp array
                    $response[0] = true; // Set response at index 0 to true
                }

                array_push($response, $tempArray); // Add temp array to response
            }
        }

        return $response; // Return response array
    }

    public function update_password($userData, $table,$ID){
        if($userData){
            $fields = array(
                TABLE_USERS['FIELD_PASSWORD'],
            );
            $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
            $fieldsCombined = "`".$fieldsCombined."`";

            str_repeat("?,", count($fields));

            $values = array(
                [$userData['password'],"ss"],
            );

            $result = array(
                "status"=>false,
                "responseCode"=>1,
                "response"=>"Undefined response"
            );

            $stmt = $this->connectToDB->prepare("UPDATE $table SET $fields[0]=? WHERE Email = ?");
            if (false === $stmt) {
                $result['responseCode'] = 101;
                $result['response'] = 'update prepare_param() failed: ' . htmlspecialchars($this->connectToDB->error);
                return $result;
            }

            $rc = $stmt->bind_param($values[0][1], $values[0][0],$ID);
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

            $result["status"] = true;
            $result["responseCode"] = 0;
            $result["response"] = "Records Were added Successfully";

            $stmt->close(); 

            return $result;
        } else{

        }
    }

    /**
    * Function to read user by reference
    *
    */
    public function readUserByReference(){

    }

    /**
    * Function to read all users
    *
    */
    public function readAllUsers(){

    }

    /**
    * Sample get by ref
    */


    public function get_my_id($email){
        $table = "tbl_users";
        $fields = array(
            "*",
        );
        $order_by = "firstName";
        $order_set = "ASC";
        $offset = 0;
        $reference = array(
            "statement" => "Email = ?",
            "type"=>"s",
            "values"=>[
                $email
            ]
        );

        $response = $this->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

        if($response['status']){
            return $response;
        }else{
            return $response;
        }
    }

    public function assign_param($user){
        $this->UUID = $user['UUID'];
        $this->firstName = $user['firstName'];
        $this->lastName = $user['lastName'];
        $this->otherName = $user['otherName'];
        $this->gender = $user['gender'];
        $this->nationalId = $user['nationalId'];
        $this->Email = $user['Email'];
        $this->userName = $user['userName'];
        $this->password = $user['password'];
        $this->Address = $user['Address'];
        $this->city = $user['city'];
        $this->role = $user['role'];
        $this->status = $user['status'];
        $this->dateCreated = $user['dateCreated'];
        $this->lastModified = $user['lastModified'];
    }

}

// EOF : User.php
