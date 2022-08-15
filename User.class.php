<?php

    class Usuario {

        private $user = null;
        private $pass = null;

        public function getUser() {
            return $this->user;
        }

        public function getPass() {
            return $this->pass;
        }

        public function setUser($user) {
            if($user && !empty($user)) {
                $this->user = $user;
            } 
        }

        public function setPass($pass) {
            if($pass && !empty($pass)) {
                $this->pass = $pass;
            } 
        }

        public function getListUsers($user) {

            $db = new DataBase();

            if($user && !empty($user)) {
                $this->setUser($user);
            }

            if($this->user)
                $whereUser = " AND `user_name` = :user ";

            $db->Prepare("SELECT * FROM rpa_users
                          WHERE 1=1 ".$whereUser);

            if($this->user)
                $db->BindParam(":user", $this->user, PDO::PARAM_INT);

            $db->Execute();

            return $db->FetchAllArray();

        }

        public function cadUser($user, $pass) {

            $db = new DataBase();

            if($user && !empty($user)) {
                $this->setUser($user);
            }

            if($pass && !empty($pass)) {
                $this->setPass($pass);
            }

            if(!$this->user || !$this->pass)
                return false;

            $db->Prepare("INSERT INTO rpa_users (
                            `user_name`, user_pass, user_datacad
                          ) 
                          VALUES (:user, :pass, now())
                          ON DUPLICATE KEY UPDATE 
                          user_pass=VALUES(user_pass)");

            
            $db->BindParam(":user", $this->user, PDO::PARAM_STR);
            $db->BindParam(":pass", $this->pass, PDO::PARAM_STR);

            $result = $db->Execute();

            return $result;

        }

       

    }

?>