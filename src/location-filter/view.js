document.addEventListener('DOMContentLoaded', () => {
	document.body.querySelectorAll('.wp-block-events-plugin-location-filter').forEach(blockElement => {
		const queryContainer = blockElement.closest('.wp-block-query')

		if (!(queryContainer instanceof HTMLElement)) {
			return
		}

		init(blockElement, queryContainer)
	})

})


/**
 *
 * @param {HTMLSelectElement} blockElement
 * @param {HTMLElement} queryContainer
 */
function init(blockElement, queryContainer) {
	blockElement.addEventListener('change', () => {
		updateURL();
	})

	function updateURL() {
		const url = new URL(location.href);
		const data = blockElement.value
		if (data.trim()) {
			url.searchParams.set('location', encodeURIComponent(data))
		} else {
			url.searchParams.delete('location')
		}

		location.href = url.toString()
	}
}
