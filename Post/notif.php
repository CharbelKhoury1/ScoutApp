<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the subscription details and user ID from the request body
  $data = json_decode(file_get_contents('php://input'), true);
  $subscription = $data['subscription'];
  $userId = $data['userId'];

  // Send the push notification to the user with the specified user ID
  sendPushNotification($subscription, $userId);

  // Send a response back to the client
  http_response_code(200);
  echo json_encode(['message' => 'Notification sent']);
}

function sendPushNotification($subscription, $userId) {
  // Perform any necessary checks and validations
  
  // Set up the necessary headers and payload for the push notification
  $payload = json_encode(['title' => 'New Notification', 'body' => 'You have a new notification']);
  $options = [
    'http' => [
      'header' => "Content-Type: application/json\r\n" .
                  "Authorization: Bearer YOUR_API_KEY\r\n",
      'method' => 'POST',
      'content' => $payload
    ]
  ];
  $context = stream_context_create($options);
  
  // Send the push notification to the user's subscription endpoint
  $result = file_get_contents($subscription['endpoint'], false, $context);
  
  // Handle the result if needed
  // ...
}
