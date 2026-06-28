#!/bin/bash

# Start WebSocket server in the background
# The output is redirected to /dev/null so it doesn't interfere with the apache logs
node PTWebSocket/Server.js > /dev/null 2>&1 &

# Start Apache in the foreground
# This will be the main process for the web service
heroku-php-apache2 public/
