# Task 1: Fix Sidebar Dropdown Bug

**Files:**
- Modify: `resources/views/layouts/dashboard.blade.php:533`

**Problem:** Sidebar rubrik dropdown has 2 bugs:
1. Can't close the dropdown after opening
2. Page scrolls/jumps when clicking menu items below with rubrik open

**Fix:** Remove `data-bs-parent="#collapseRubrik"` from the inner per-jenjang collapse at line 533.

**Before:**
```
<div class="collapse {{ $isSJActive ? 'show' : '' }}" id="collapseJenjang{{ $sj->id }}" data-bs-parent="#collapseRubrik">
```

**After:**
```
<div class="collapse {{ $isSJActive ? 'show' : '' }}" id="collapseJenjang{{ $sj->id }}">
```

**Test:** Run `php artisan serve --port=8000` then visit http://127.0.0.1:8000/ — toggle rubrik dropdown open/close, click per-jenjang items, verify no scroll jump.
