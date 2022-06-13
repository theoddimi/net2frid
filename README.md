# Net2Grid Assignment
## _v1.1.0_

Net2Grid - Sending to and receiving messages from exchange on RabbitMQ.

# Installation
- `git clone https://github.com/theoddimi/net2grid.git`
- `composer install`
- `php bin/console doctrine:migrations:migrate`
- `symfony server:start --port=<port>`

# Start consuming from the exchange
Open a new command line window on the working directory and run:
- `symfony console messenger:consume grid -vv`

# Start sending messages to exchange
Open a browser and visit  http://127.0.0.1:<port>/send-grid-message to start sending messages to the queue.

# Notes
- All requests made to the API message consumer are stored to api_request table and the corresponding responses to api_response table
- We keep track of the transport by storing informations to message_transport table. When we send the message to exchange we set a transport row and we udate its status by the moment we receive it back.
- By the moment we receive the message, we store those to grid_message table.