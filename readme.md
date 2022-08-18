Hi there,
Simple  urls can be tested with MAMP Apache Server running in public directory 

HTTP  Resource                  Description
GET   /users                    get a list of all users
GET	  /users/{id}	              get a user by user id
GET 	/messages/	              get a list of messages
GET	  /messages/receiver/{id}	  get a list of messages received by user id
GET	  /messages/sender/{id}	    get a list of messages sent by user id
POST	/messages/send	          send a new message params sender,toid and msg
