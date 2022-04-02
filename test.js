var http = require('http');
var lis =   require('./list');

http.createServer(function(req,res){
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write("hello"+lis.Listout());
    res.end();
}).listen(8080);