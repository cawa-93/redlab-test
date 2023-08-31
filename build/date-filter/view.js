/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/shared/view-handle-filter.js":
/*!******************************************!*\
  !*** ./src/shared/view-handle-filter.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   createFilter: function() { return /* binding */ createFilter; }
/* harmony export */ });
function fallbackReloadFeed() {
  location.reload();
}

/**
 *
 * @param {HTMLElement} queryContainer
 */
function createFilter(queryContainer) {
  const originalFeedClasses = queryContainer.querySelector('.wp-block-post-template')?.classList;
  return async function reloadFeed() {
    queryContainer.ariaBusy = 'true';
    const timeoutId = setTimeout(() => {
      queryContainer.style.opacity = '0.5';
      queryContainer.style.pointerEvents = 'none';
    }, 350);
    try {
      const page = await fetch(location.href).then(r => r.text());
      /** @type {HTMLTemplateElement} */
      const tempTemplate = document.createElement('template');
      tempTemplate.innerHTML = page;

      /**
       * @param {HTMLElement | DocumentFragment} container
       * @return {HTMLElement}
       **/
      const getContent = container => container.querySelector('.wp-block-post-template') || container.querySelector('.wp-block-query-no-results');
      const placement = getContent(queryContainer);
      const newContent = getContent(tempTemplate.content);
      if (!placement) {
        throw new Error('Unable to find place to replace with new content');
      }
      if (!newContent) {
        throw new Error('Unable to find new contend to replace placement');
      }
      if (newContent.classList.contains('wp-block-post-template')) {
        // If there is no original feed on the page, we have to reload the entire page to load the feed CSS
        if (!originalFeedClasses) {
          return fallbackReloadFeed();
        }
        newContent.classList.add(...originalFeedClasses);
      }
      placement.replaceWith(newContent);
    } catch (e) {
      console.error(e);
      fallbackReloadFeed();
    } finally {
      clearTimeout(timeoutId);
      queryContainer.ariaBusy = 'false';
      queryContainer.style.opacity = '1';
      queryContainer.style.pointerEvents = 'auto';
    }
  };
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!*********************************!*\
  !*** ./src/date-filter/view.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _shared_view_handle_filter__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/view-handle-filter */ "./src/shared/view-handle-filter.js");

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
  const reloadFeed = (0,_shared_view_handle_filter__WEBPACK_IMPORTED_MODULE_0__.createFilter)(queryContainer);
  blockElement.querySelectorAll('input').forEach(el => {
    el.addEventListener('change', async () => {
      updateURL();
      await reloadFeed();
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
    history.replaceState(data, '', url);
  }
}
}();
/******/ })()
;
//# sourceMappingURL=view.js.map