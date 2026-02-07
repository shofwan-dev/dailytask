# ✅ Task Duplicate Feature

## 🎯 **Fitur Baru: Duplikat Task**

Fitur untuk menduplikasi task yang sudah ada dengan satu klik.

---

## 📋 **Implementasi:**

### **1. Route** 🛣️
**File**: `routes/web.php`

```php
Route::post('/tasks/{task}/duplicate', [TaskController::class, 'duplicate'])
    ->name('tasks.duplicate');
```

---

### **2. Controller Method** 🎮
**File**: `app/Http/Controllers/TaskController.php`

```php
public function duplicate(Task $task)
{
    // Check ownership
    if ($task->user_id !== Auth::id()) {
        return redirect()->route('tasks.index')
            ->with('error', '❌ Unauthorized!');
    }

    // Create duplicate task
    $duplicateTask = $task->replicate();
    $duplicateTask->title = $task->title . ' (Copy)';
    $duplicateTask->status = 'pending';
    $duplicateTask->wa_notified = false;
    $duplicateTask->save();

    return redirect()->route('tasks.index')
        ->with('success', '📋 Task berhasil diduplikasi!');
}
```

**Cara Kerja:**
1. ✅ **Check ownership** - Pastikan user adalah pemilik task
2. ✅ **Replicate task** - Duplikasi semua field task
3. ✅ **Modify title** - Tambahkan " (Copy)" ke judul
4. ✅ **Reset status** - Set status ke "pending"
5. ✅ **Reset notification** - Set `wa_notified` ke false
6. ✅ **Save** - Simpan task baru
7. ✅ **Redirect** - Kembali ke task list dengan pesan sukses

---

### **3. UI Button** 🎨
**File**: `resources/views/tasks/index.blade.php`

**Lokasi**: Di action buttons, antara toggle status dan edit button

```blade
<!-- Duplicate Button -->
<form method="POST" action="{{ route('tasks.duplicate', $task) }}" class="inline">
    @csrf
    <button type="submit" class="p-2 rounded-lg hover:bg-purple-50 transition text-purple-500 hover:text-purple-700" title="Duplikat Task">
        <lord-icon
            src="https://cdn.lordicon.com/puvaffet.json"
            trigger="hover"
            colors="primary:#9333ea,secondary:#e9d5ff"
            style="width:24px;height:24px">
        </lord-icon>
    </button>
</form>
```

**Design:**
- ✅ **Icon**: Lord Icon `puvaffet.json` (copy/duplicate icon)
- ✅ **Color**: Purple (primary: #9333ea)
- ✅ **Hover**: Purple-50 background
- ✅ **Tooltip**: "Duplikat Task"
- ✅ **Animation**: Hover trigger

---

## 🎨 **Action Buttons Order:**

```
┌────────────────────────────────────┐
│ Task Card                          │
│                                    │
│ [✓] [📋] [✏️] [🗑️]                │
│  │   │    │    │                  │
│  │   │    │    └─ Delete          │
│  │   │    └────── Edit            │
│  │   └─────────── Duplicate (NEW) │
│  └─────────────── Toggle Status   │
└────────────────────────────────────┘
```

**Button Order:**
1. **Toggle Status** - Check/uncheck (green/gray)
2. **Duplicate** - Copy icon (purple) ← **NEW**
3. **Edit** - Pencil icon (blue)
4. **Delete** - Trash icon (red)

---

## ✅ **Fitur Duplikasi:**

### **Yang Diduplikasi:**
- ✅ **Title** - Dengan suffix " (Copy)"
- ✅ **Description** - Sama persis
- ✅ **Due Date** - Sama persis
- ✅ **Due Time** - Sama persis
- ✅ **User ID** - Tetap milik user yang sama

### **Yang Di-Reset:**
- ✅ **Status** - Selalu "pending"
- ✅ **wa_notified** - Selalu false
- ✅ **ID** - Auto-generated (baru)
- ✅ **Timestamps** - created_at & updated_at baru

---

## 🔒 **Security:**

- ✅ **Ownership Check** - Hanya owner yang bisa duplikat
- ✅ **CSRF Protection** - Token CSRF required
- ✅ **Authorization** - Return error jika unauthorized

---

## 📱 **User Flow:**

```
1. User klik tombol Duplicate (purple icon)
   ↓
2. POST request ke /tasks/{id}/duplicate
   ↓
3. Controller check ownership
   ↓
4. Replicate task dengan modifikasi
   ↓
5. Save task baru
   ↓
6. Redirect ke task list
   ↓
7. Show success message: "📋 Task berhasil diduplikasi!"
   ↓
8. Task baru muncul di list dengan title "(Copy)"
```

---

## 🧪 **Testing Scenarios:**

**Success Case:**
1. ✅ Klik duplicate button
2. ✅ Task baru muncul dengan title " (Copy)"
3. ✅ Status = pending
4. ✅ wa_notified = false
5. ✅ Due date & time sama
6. ✅ Description sama
7. ✅ Success message muncul

**Edge Cases:**
1. ✅ Duplicate task yang sudah done → Jadi pending
2. ✅ Duplicate task yang sudah notified → wa_notified = false
3. ✅ Duplicate task orang lain → Error unauthorized
4. ✅ Duplicate multiple times → Setiap duplikasi tambah " (Copy)"

---

## 💡 **Use Cases:**

**1. Recurring Tasks**
- User punya task yang berulang
- Duplikat task lalu edit tanggal

**2. Template Tasks**
- User punya task template
- Duplikat lalu edit detail

**3. Similar Tasks**
- User punya task serupa
- Duplikat lalu modifikasi sedikit

**4. Backup Tasks**
- User ingin backup task sebelum edit
- Duplikat dulu baru edit original

---

## 📁 **Files Modified:**

1. ✅ `routes/web.php`
   - Added duplicate route

2. ✅ `app/Http/Controllers/TaskController.php`
   - Added duplicate() method

3. ✅ `resources/views/tasks/index.blade.php`
   - Added duplicate button in actions

---

## 🎉 **Benefits:**

- ✅ **Quick duplication** - One click to duplicate
- ✅ **Time saving** - No need to re-enter all data
- ✅ **Safe** - Original task tidak terpengaruh
- ✅ **Flexible** - Bisa edit hasil duplikasi
- ✅ **User-friendly** - Icon jelas, tooltip informatif

---

**Perfect! Fitur duplikat task sudah siap digunakan!** 🎉
