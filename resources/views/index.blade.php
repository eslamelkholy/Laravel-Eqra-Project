<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script>

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;

      var pusher = new Pusher('0e0882c25b1299c47bdb', {
        cluster: 'mt1'
      });

      var channel = pusher.subscribe('my-channel');
      channel.bind('post-added', function(data) {
        alert(JSON.stringify(data));
      });
    </script>
  </head>
  <body>
    <h1>Pusher Test</h1>
    <p>
      Try publishing an event to channel <code>my-channel</code>
      with event name <code>my-event</code>.
    </p>
  </body>
