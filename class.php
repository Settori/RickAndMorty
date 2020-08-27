<?php

    class zadanieDB {
        private $db_host = "";
        private $db_user = "";
        private $db_pass = "";
        private $db_name = "";
        private $con;
        
        //Function for establishing connection with the database
        public function connect() {
			if ($connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass)) {
				if (mysqli_select_db($connect, $this->db_name)) {
					$this->con = $connect;
					mysqli_query($this->con, "SET NAMES 'utf8'");
					return true;
				} else {
					throw new Exception("Database selection failed");
				}
			} else {
				throw new Exception("Not connected to the database");
			}
		}
        
		
        
        
		/********************************************** USERS ************************************************/
        

        //Function for registering new accounts
        public function register($email, $password) {

            //Checking if email is correct
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email is not correct");
            }

            //Checking if password is at least 6 characters long
            if (strlen($password) < 6) {
                throw new Exception("Password to short");
            }

            //Checking if connection with the database has been established
            if ($this->con) {

                //Generate user token
                $token = $this->generate_hash($email);

                //Hashing user password
                $_pass = $this->generate_hash($password);

                //Checking if email is already in use
                if (mysqli_num_rows(mysqli_query($this->con, "SELECT email FROM users WHERE email = '$email'")) > 0) {
                    throw new Exception("Email already in use");
                }

                //Putting new account data to the database
                $query = "INSERT INTO users (email, password, token) VALUES ('$email', '$_pass', '$token')";
                if (mysqli_query($this->con, $query)) {

                    //Login after registration
                    $this->login($email, $password);
                    return true;

                } else {
                    throw new Exception("Can't fetch data");
                }
            } else {
                throw new Exception("Not connected to the database");
            }
        }
        

        //Function for login
        public function login($email, $password) {

            //Checking if connection with the database has been established
            if ($this->con) {

                //Hashing user password
                $_pass = $this->generate_hash($password);

                //If user data are correct, set user cookie
                $query = "SELECT token FROM users WHERE email = '$email' AND password = '$_pass'";
                if ($row = mysqli_fetch_assoc(mysqli_query($this->con, $query))) {
                    setcookie("user", $row['token'], time() + (86400 * 30), "/");
                    return true;
                } else {
                    throw new Exception("Cannot login, wrong data");
                }
            } else {
                throw new Exception("Not connected to the database");
            }
        }


        //Function for getting user data using token
        public function get_user_data_from_token($token) {

            //Checking if connection with the database has been established
            if ($this->con) {
                $query = "SELECT id, email FROM users WHERE token = '$token'";
                if ($row = mysqli_fetch_assoc(mysqli_query($this->con, $query))) {
                    return $row;
                } else {
                    throw new Exception("Cannot get user data");
                }
            } else {
                throw new Exception("Not connected to the database");
            }
        }


        
        
        /********************************************** CHARACTERS ************************************************/


        //Function for rating characters
        public function rate_character($token, $character_id, $rate) {

            //Checking if connection with the database has been established
            if ($this->con) {

                //Checking if rate is between 1 and 5
                if ($rate >=1 && $rate <=5 ) {

                    //Getting user ID
                    $user_id = $this->get_user_data_from_token($token)['id'];

                    //Checking if user already rated this character. If so, it updates the rating
                    if (mysqli_num_rows(mysqli_query($this->con, "SELECT id FROM ratings WHERE character_id = $character_id AND user_id = $user_id")) > 0) {
                        $query = "UPDATE ratings SET rate = $rate WHERE character_id = $character_id AND user_id = $user_id";
                    }

                    //If not, create new entry with rate 
                    else {
                        $query = "INSERT INTO ratings (character_id, user_id, rate) VALUES ($character_id, $user_id, $rate)";
                    }

                    //Calling MySQL query
                    if (mysqli_query($this->con, $query)) {
                        return true;
                    }
                    else {
                        throw new Exception("The character could not be assessed");
                    }
                }
                else {
                    throw new Exception("Rate is not between 1 and 5");
                }
            } else {
                throw new Exception("Not connected to the database");
            }
        }


        //Function for searching characters
        public function search_character($token, $character_name, $status='all', $gender='all') {

            //Checking if connection with the database has been established
            if ($this->con) {

                //Params for calling R&M API
                $params = "";
                if ($status != 'all') $params .= "&status=$status";
                if ($gender != 'all') $params .= "&gender=$gender";

                //Getting data from API, and replace spaces with '+'
                if (!$json = file_get_contents("https://rickandmortyapi.com/api/character/?name=" . str_replace(" ", "+", $character_name) . $params)) {
                    throw new Exception("No data was found");
                }

                //Decoding JSON data
                $obj = json_decode($json);

                //Creating characters array
                $characters = array();

                //Putting each character to characters array
                foreach ($obj->results as $character) {
                    $data = array();    //Character buffer
                    $data['id'] = $character->id;
                    $data['name'] = $character->name;
                    $data['image'] = $character->image;
                    $data['rate'] = $this->get_character_rate($token, $character->id);
                    array_push($characters, $data);
                }

                //Return characters array
                return $characters;

            } else {
                throw new Exception("Not connected to the database");
            }
        }


        //Function getting characters rate for logged in user
        public function get_character_rate($token, $character_id) {

            //Checking if connection with the database has been established
            if ($this->con) {

                //Getting user ID
                $user_id = $this->get_user_data_from_token($token)['id'];

                //Checking if user rated the character, if so return the rate
                if  ($row = mysqli_fetch_assoc(mysqli_query($this->con, "SELECT rate FROM ratings WHERE character_id = $character_id AND user_id = $user_id"))) {
                    $rate = $row['rate'];
                }

                //If not, return zero
                else {
                    $rate = 0;
                }
                return $rate;
            } else {
                throw new Exception("Not connected to the database");
            }
        }


        
        
        /*********************** OTHER FUNCTIONS *************************/
        

        //Function for generating hash from input
        public function generate_hash($content) {
            return sha1($content . "3j98wryhea0sf8y");
        }

        
	}

?>