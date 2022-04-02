var express = require('express');
var app = express();
var db  =  require('../db.js');


class User {   
    createUser = function(req,res){
        res.sendFile( "C:/xampp8/htdocs/Learning/Node" + "/views/user/" + "create.html" );
    }

    addUser = (req,res) => {
        console.log('Got body:', req.body);
        
        var name  = req.body.first_name;
        var email = req.body.email_address;
        var mobile = req.body.mobile_number;
        
        db.connect(function(err){
            var sql = "INSERT INTO users(name,email,mobile_number) VALUES('"+name+"','"+email+"',"+mobile+")";
            db.query(sql, function (err, result) {
                if (err) throw err;
                console.log("1 record inserted");
            });
        });
        res.sendStatus(200);
        //res.sendFile( "C:/xampp8/htdocs/Learning/Node" + "/views/user/" + "create.html" );
    }
}

module.exports = new User();




