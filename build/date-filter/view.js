/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./src/date-filter/view.js ***!
  \*********************************/
document.addEventListener('DOMContentLoaded', () => {
  document.body.querySelectorAll('.wp-block-events-plugin-date-filter').forEach(blockElement => {
    const queryContainer = blockElement.closest('.wp-block-query');
    if (!(queryContainer instanceof HTMLElement)) {
      return;
    }
    init(blockElement, queryContainer);
  });
});

/**
 *
 * @param {HTMLElement} blockElement
 * @param {HTMLElement} queryContainer
 */
function init(blockElement, queryContainer) {
  blockElement.querySelectorAll('input').forEach(el => {
    el.addEventListener('change', () => {
      updateURL();
    });
  });
  function updateURL() {
    /** @type {Map<string, string[]>} */
    const map = new Map();
    blockElement.querySelectorAll('input:checked').forEach( /** @param {HTMLInputElement} checkbox */checkbox => {
      /** @type {string} */
      const value = checkbox.value;
      /** @type {'year' | 'month'} */
      const type = checkbox.dataset.filterType;
      switch (type) {
        case "year":
          if (!map.has(value)) {
            map.set(value, []);
          }
          break;
        case "month":
          const year = checkbox.dataset.filterYear;
          map.set(year, [...(map.get(year) || []), value]);
          break;
      }
    });
    const url = new URL(location.href);
    const data = Object.fromEntries(map.entries());
    if (Object.keys(data).length) {
      url.searchParams.set('date_query', encodeURIComponent(JSON.stringify(data)));
    } else {
      url.searchParams.delete('date_query');
    }
    location.href = url;
  }
  console.log({
    blockElement,
    queryContainer
  });
}
/******/ })()
;
//# sourceMappingURL=view.js.map