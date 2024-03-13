# changes
## backend
- moved laravel-echo-server.json and laravel-echo-server.lock to backend
- check "/broadcast" route in routes/api.php
- check providers/broadcatserviceprovider(I added this line: `Broadcast::routes(['middleware' => ['auth:sanctum']]);`)
- I added user name to the event(events/sendMessage)

## frontend
- removed sonner (toast notifications) fetch the new syncareer repo and work with it
- changed router/index.js temporarly
- you will find chat code in pages/user/mostafatest.js (use best practices that i gave you as comments)