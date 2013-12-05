<?php

class User {
	
	private $dbh;
	
	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);		
	}

    // gimme a 'C'..
    public function add($user){        
        $sth = $this->dbh->prepare("INSERT INTO users(name, email, ssn, address) VALUES (?, ?, ?, ?)");
        $sth->execute(array($user->name, $user->email, $user->ssn, $user->address));        
        return json_encode($this->dbh->lastInsertId());
    }
    
    // gimme a 'R'..
	public function getUsers(){				
		$sth = $this->dbh->prepare("SELECT * FROM users");
		$sth->execute();
		return json_encode($sth->fetchAll());
	}
    
    // gimme a 'U'..
    public function updateValue($user){        
        $sth = $this->dbh->prepare("UPDATE users SET ". $user->field ."=? WHERE id=?");
        $sth->execute(array($user->newvalue, $user->id));
        return json_encode(1);    
    }


    // gimme a 'D'...
	public function delete($user){				
		$sth = $this->dbh->prepare("DELETE FROM users WHERE id=?");
		$sth->execute(array($user->id));
		return json_encode(1);
	}
    
    // CRUD!!

    //
    // this function would ideally be in its own class and would use AJAX or cURL to hit a RESTful server somewhere in the cloud...
    // ....but it's only an unpaid quick n dirty demo :)
    //
    public function getScore($user){   
             
        $ssn=$user->ssn;
        $sth = $this->dbh->prepare("SELECT * FROM creditscores WHERE ssn='$ssn'");
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_OBJ);
        
        $sth = $this->dbh->prepare("UPDATE users SET score=? WHERE id=?");
        
        $sth->execute(array($row->score, $user->id));
        error_log("$row->score\n $user->ssn\n$user->id",3,"debug.txt");

        $sth = $this->dbh->prepare("SELECT * FROM users");
        $sth->execute();
        
        return json_encode($sth->fetchAll());    
    }
}
?>