# Manual Testing Checklist

## Rendering

- [ ] Table appears on a variable product with mesh variations.
- [ ] Table does **not** appear on products without mesh variations.
- [ ] Optional columns appear only when corresponding data exists.
- [ ] Prices match the variation dropdown.
- [ ] Table rows are rendered in the same order as the WooCommerce variation dropdown.

## Asset Loading

- [ ] CSS file loads successfully.
- [ ] JavaScript file loads successfully.
- [ ] No JavaScript errors appear in the browser console.

## Table Interaction

- [ ] Clicking a table row selects the corresponding WooCommerce variation.
- [ ] Selected row is visually highlighted.
- [ ] Hovering over the selected row preserves the selected styling.
- [ ] Changing the WooCommerce dropdown updates the highlighted table row.
- [ ] Keyboard **Enter** selects the focused row.
- [ ] Keyboard **Space** selects the focused row.
- [ ] Focus outline is visible when navigating with the keyboard.

## WooCommerce Integration

- [ ] Product price updates after selecting a row.
- [ ] Variation image updates (if applicable).
- [ ] SKU updates (if displayed by the theme).
- [ ] Stock status updates correctly.
- [ ] Add to Cart adds the selected variation.
- [ ] Reset/Clear Variations clears the table selection.
- [ ] Unavailable or out-of-stock variations behave correctly.

## Responsive Layout

- [ ] Table displays correctly on desktop.
- [ ] Horizontal scrolling works on narrow screens.
- [ ] Sticky table header remains visible while scrolling.
- [ ] No layout overflow or clipping occurs.

## Accessibility

- [ ] Rows are reachable using the keyboard (Tab).
- [ ] Focus indicator is clearly visible.
- [ ] Enter activates the focused row.
- [ ] Space activates the focused row.
- [ ] Screen reader attributes update correctly (`aria-selected`).

## Cross-Browser

- [ ] Chrome
- [ ] Firefox
- [ ] Edge
- [ ] Safari (if available)

## Regression

- [ ] Existing WooCommerce variation selection still works normally.
- [ ] Existing product pages without the mesh table are unaffected.
- [ ] No PHP warnings or notices.
- [ ] No JavaScript console errors.
- [ ] PHPUnit test suite passes before release.
