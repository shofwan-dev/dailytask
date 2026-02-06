# DailyTask API Documentation

## Authentication

All API endpoints require authentication using Laravel Sanctum or session-based authentication.

## Endpoints

### Authentication

#### POST /login
Login to the application

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password",
  "remember": true
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "redirect": "/tasks"
}
```

#### POST /register
Register a new user

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone_number": "628123456789",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Registration successful",
  "redirect": "/tasks"
}
```

#### POST /logout
Logout from the application

**Response:**
```json
{
  "success": true,
  "redirect": "/login"
}
```

---

### Tasks

#### GET /tasks
Get all tasks for authenticated user

**Response:**
```json
{
  "tasks": [
    {
      "id": 1,
      "user_id": 1,
      "title": "Submit Laporan Bulanan",
      "description": "Selesaikan dan submit laporan keuangan bulan Januari",
      "due_date": "2026-02-08",
      "due_time": "17:00:00",
      "status": "pending",
      "wa_notified": false,
      "created_at": "2026-02-06T04:59:07.000000Z",
      "updated_at": "2026-02-06T04:59:07.000000Z",
      "is_overdue": false
    }
  ]
}
```

#### GET /tasks/create
Show create task form

#### POST /tasks
Create a new task

**Request Body:**
```json
{
  "title": "New Task",
  "description": "Task description (optional)",
  "due_date": "2026-02-10",
  "due_time": "15:00"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Task created successfully",
  "task": {
    "id": 2,
    "title": "New Task",
    "status": "pending",
    ...
  }
}
```

#### PATCH /tasks/{id}
Update task status

**Request Body:**
```json
{
  "status": "done"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Task updated successfully"
}
```

#### POST /tasks/{id}/toggle
Toggle task status (pending ↔ done)

**Response:**
```json
{
  "success": true,
  "status": "done"
}
```

#### DELETE /tasks/{id}
Delete a task

**Response:**
```json
{
  "success": true,
  "message": "Task deleted successfully"
}
```

---

## WhatsApp API Integration

### Endpoint
```
POST https://mpwa.mutekar.com/send-message
```

### Request Headers
```
Content-Type: application/json
```

### Request Body
```json
{
  "api_key": "your_api_key_here",
  "sender": "628888xxxx",
  "number": "628123456789",
  "message": "Your message here",
  "footer": "DailyTask App"
}
```

### Response (Success)
```json
{
  "status": "success",
  "message": "Message sent successfully",
  "data": {
    "message_id": "xxx",
    "timestamp": "2026-02-06T12:00:00Z"
  }
}
```

### Response (Error)
```json
{
  "status": "error",
  "message": "Invalid API key or sender",
  "code": "AUTH_ERROR"
}
```

---

## Scheduler Commands

### Send Task Reminders
```bash
php artisan tasks:send-reminders
```

This command:
1. Queries all tasks that are:
   - Status: `pending`
   - `wa_notified`: `false`
   - Due date/time has passed
2. Sends WhatsApp reminder to each task owner
3. Marks task as `wa_notified: true`

### Schedule Configuration
Located in `routes/console.php`:

```php
Schedule::command('tasks:send-reminders')
    ->everyTenMinutes()
    ->withoutOverlapping()
    ->runInBackground();
```

---

## Error Codes

| Code | Description |
|------|-------------|
| 401 | Unauthorized - User not authenticated |
| 403 | Forbidden - User doesn't own the resource |
| 404 | Not Found - Resource doesn't exist |
| 422 | Validation Error - Invalid input data |
| 500 | Server Error - Internal server error |

---

## Rate Limiting

- **Web Routes**: 60 requests per minute per IP
- **API Routes**: 60 requests per minute per user

---

## Webhooks (Future Enhancement)

### Task Completed Webhook
```
POST https://your-webhook-url.com/task-completed
```

**Payload:**
```json
{
  "event": "task.completed",
  "task_id": 1,
  "user_id": 1,
  "completed_at": "2026-02-06T12:00:00Z"
}
```

### Task Overdue Webhook
```
POST https://your-webhook-url.com/task-overdue
```

**Payload:**
```json
{
  "event": "task.overdue",
  "task_id": 1,
  "user_id": 1,
  "due_date": "2026-02-05",
  "overdue_hours": 24
}
```

---

## Testing

### Using cURL

**Login:**
```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "demo@dailytask.com",
    "password": "password"
  }'
```

**Create Task:**
```bash
curl -X POST http://localhost:8000/tasks \
  -H "Content-Type: application/json" \
  -H "Cookie: laravel_session=YOUR_SESSION_COOKIE" \
  -d '{
    "title": "Test Task",
    "description": "This is a test",
    "due_date": "2026-02-10",
    "due_time": "15:00"
  }'
```

### Using Postman

1. Import the collection (coming soon)
2. Set environment variables:
   - `base_url`: http://localhost:8000
   - `email`: demo@dailytask.com
   - `password`: password

---

## Support

For issues or questions:
- GitHub Issues: [repository-url]/issues
- Email: support@dailytask.com
- Documentation: [repository-url]/wiki
