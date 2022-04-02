
var express = require('express');
var app = express();
var User  =  require('./Model/user.js');
var bodyParser = require('body-parser')

var urlencodedParser = bodyParser.urlencoded({ extended: false })

app.get('/user', function(req, res){ 
    User.createUser(req,res)
});

app.post('/user/add', urlencodedParser , function(req, res){ 
    User.addUser(req,res)
});
 
 app.listen(3000);