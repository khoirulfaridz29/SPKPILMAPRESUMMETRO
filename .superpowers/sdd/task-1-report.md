# Task 1 Report: Fix Sidebar Dropdown Bug

**Status:** ✅ Done

**Commit:** `6c0a965`

**Change:** Removed `data-bs-parent="#collapseRubrik"` from the per-jenjang inner collapse at `resources/views/layouts/dashboard.blade.php:533`.

**Verification:**
- `data-bs-parent="#collapseRubrik"` no longer present on the inner collapse div.
- Inner collapse now behaves as a nested independent collapse, allowing the parent rubrik section to close properly.
- Expected: scroll jumps when toggling rubrik section are eliminated.
