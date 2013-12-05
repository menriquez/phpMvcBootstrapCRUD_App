<?php
class CreditUser extends User {
    
    private $user_id;
    
    public function add($user){
         
        $this->user_id = $user;
           
        $sth = $this->dbh->prepare("INSERT INTO users(name, email, ssn, address) VALUES (?, ?, ?, ?)");
        $sth->execute(array($user->name, $user->email, $user->ssn, $user->address));        
        return json_encode($this->dbh->lastInsertId());
    }
}
?>
