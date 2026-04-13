# Lilly's Nook Audit Report

Date: April 13, 2026
Scope: Read-only review of the full Laravel project. No application code was changed.

## Summary

The project is mostly coherent, and the test suite is currently passing. I found a small number of concrete issues that can break pages or create production risk. Those issues have now been fixed and revalidated:

- One invalid HTML structure in the main storefront layout.
- One client-side XSS risk in the live search dropdown.
- One broken debug script in the repository root.
- Hardcoded Razorpay fallback credentials in config.
- A global view composer that adds database work on every rendered page.

## Findings

### High: Live search injects unescaped HTML into the page
- Location: [public/js/script.js](public/js/script.js#L48) and [public/js/script.js](public/js/script.js#L94)
- Problem: Product names and category labels are inserted into template strings and then assigned with `innerHTML`. If a product or category name contains HTML, it can execute in the browser.
- Impact: Stored XSS in the storefront search dropdown.
- Recommendation: Build the dropdown with DOM nodes and `textContent`, or escape all dynamic values before inserting them into HTML.

### Medium: Storefront layout has stray closing tags
- Location: [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php#L240)
- Problem: The layout contains an unmatched closing `</header>` immediately after the navigation block, with a stray `</div>` before it.
- Impact: Invalid HTML structure can cause layout inconsistencies across many storefront pages.
- Recommendation: Remove the extra closing tags and keep the header/nav markup balanced.

### Medium: Debug script calls a non-existent RouteCollection method
- Location: [debug_checkout.php](debug_checkout.php#L77) and [debug_checkout.php](debug_checkout.php#L78)
- Problem: The script calls `where()` on `RouteCollectionInterface`, which does not exist.
- Impact: Running the script throws an error, so it is not usable as a checkout diagnostic tool.
- Recommendation: Replace the route filtering logic with a supported collection method or remove the script from the project root if it is no longer needed.

### Medium: Razorpay test credentials are hardcoded as config fallbacks
- Location: [config/services.php](config/services.php#L22) and [config/services.php](config/services.php#L23)
- Problem: The Razorpay key ID and secret are stored as fallback defaults in source control.
- Impact: Production can silently use the wrong credentials if environment variables are missing, and the secret is exposed in the codebase.
- Recommendation: Keep credentials only in environment variables and remove the fallback values from the config file.

### Low: Global view composer adds database queries to every request
- Location: [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php#L24), [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php#L28), [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php#L29)
- Problem: The `View::composer('*')` hook runs on every rendered view and performs cart and wishlist queries for authenticated users.
- Impact: Extra database work on every page render, including pages that do not need these counts.
- Recommendation: Cache these counts, move them to a narrower set of views, or compute them once in a shared middleware/view model.

## Notes

- The checkout/payment flow itself is wired correctly and the test suite is passing.
- The reported issues have been fixed in code and rechecked with static analysis and tests.
- If you want, I can turn this report into a prioritized rollout checklist next.
