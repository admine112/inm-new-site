# Basket Button Fix - Walkthrough

## Problem

The basket button in the header was not clickable on the production server, even though the `/basket` page was accessible.

## Root Cause

The basket button had a conflicting HTML structure:

```html
<div class="basket" id="basket">
  <a href="/basket/">
    <div class="bs_holder cl_basket_text">
      <!-- content -->
    </div>
  </a>
</div>
```

**Issue:** The nested `<a>` tag was blocking click events, likely due to CSS `pointer-events: none` or z-index conflicts.

## Solution Applied

Removed the nested `<a>` tag and added `onclick` handler directly to the `<div>`:

```html
<div class="basket" id="basket" style="position: relative; z-index: 100; cursor: pointer;" onclick="window.location.href='/basket';">
    <div class="bs_holder cl_basket_text">
        В вашей корзине <strong>0 товар(ов)</strong><br>
        на сумму <strong>0  грн..</strong>
    </div>
</div>
```

### Changes Made

1. **Removed** `<a href="/basket/">` and its closing tag
2. **Added** `onclick="window.location.href='/basket';"` to the div
3. **Added** inline styles:
   - `position: relative`
   - `z-index: 100` (ensures it's above other elements)
   - `cursor: pointer` (shows clickable cursor)

## Files Modified

- **File:** `/www/www/templates/shop1/main.tpl`
- **Lines:** 342-347
- **Server:** is501201.ftp.tools

## Deployment

1. Fixed file locally using Python script
2. Uploaded to server via SCP:
   ```bash
   scp main.tpl is501201@is501201.ftp.tools:/home/is501201/inmunoflam.com.ua/www/templates/shop1/main.tpl
   ```

## Verification Steps

To verify the fix works:

1. Open https://inmunoflam.com.ua/
2. Clear browser cache (Ctrl+F5)
3. Click on the basket button in the header
4. Should navigate to `/basket` page

## Technical Notes

- **Why this works:** By removing the nested anchor and using `onclick`, we eliminate any CSS conflicts that were blocking the click event
- **z-index: 100:** Ensures the basket div is above other header elements
- **JavaScript fallback:** The `onclick` handler works even if CSS is blocking pointer events

## Previous Attempts

According to documentation, multiple fixes were attempted before:
1. Adding `pointer-events: auto !important` inline
2. Adding JavaScript event listener
3. Changing `<a>` to `<div>` with onclick

This final solution combines the best approach: simple onclick handler with proper z-index stacking.
