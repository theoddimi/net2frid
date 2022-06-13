# Net2Grid Assignment
## _v1.1.0_

Net2Grid - Sending to and receiving messages from exchange on RabbitMQ.

# Installation
- `git clone https://github.com/theoddimi/net2frid.git`
- `composer install`
- `php bin/console doctrine:migrations:migrate`
- `symfony server:start --port=<port>`

# Start consuming from the exchange
Open a new command line window on the working directory and run:
- `symfony console messenger:consume grid -vv`

# Start sending messages to exchange
Open a browser and visit  http://127.0.0.1:<port>/send-grid-message to start sending messages to the queue.

#Notes
## All requests made to the API message consumer are stored inside api_request table 
and the corresponding responses in api_response table
## We keep track of the transport when we send the message to exchange and we update the transport status once we receive those.
## By the moment we receive the message we store those to grid_message table.