var mysql  = require('mysql');

var connection = mysql.createConnection({
    host        : 'localhost',
    user        : 'root',
    password    : '',
    database    : 'node_project'
});

module.exports = connection;