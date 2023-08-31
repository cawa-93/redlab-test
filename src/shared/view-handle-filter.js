function fallbackReloadFeed() {
	location.reload()
}


/**
 *
 * @param {HTMLElement} queryContainer
 */
export function createFilter(queryContainer) {

	const originalFeedClasses = queryContainer.querySelector('.wp-block-post-template')?.classList

	return async function reloadFeed() {

		queryContainer.ariaBusy = 'true'


		const timeoutId = setTimeout(() => {
			queryContainer.style.opacity = '0.5'
			queryContainer.style.pointerEvents = 'none'
		}, 350)

		try {

			const page = await fetch(location.href).then(r => r.text())
			/** @type {HTMLTemplateElement} */
			const tempTemplate = document.createElement('template')
			tempTemplate.innerHTML = page


			/**
			 * @param {HTMLElement | DocumentFragment} container
			 * @return {HTMLElement}
			 **/
			const getContent = (container) => container.querySelector('.wp-block-post-template') || container.querySelector('.wp-block-query-no-results')

			const placement = getContent(queryContainer)
			const newContent = getContent(tempTemplate.content)

			if (!placement) {
				throw new Error('Unable to find place to replace with new content')
			}

			if (!newContent) {
				throw new Error('Unable to find new contend to replace placement')
			}

			if (newContent.classList.contains('wp-block-post-template')) {
				// If there is no original feed on the page, we have to reload the entire page to load the feed CSS
				if (!originalFeedClasses) {
					return fallbackReloadFeed();
				}
				newContent.classList.add(...originalFeedClasses)
			}

			placement.replaceWith(newContent)


		} catch (e) {
			console.error(e)
			fallbackReloadFeed();
		} finally {
			clearTimeout(timeoutId);
			queryContainer.ariaBusy = 'false'
			queryContainer.style.opacity = '1'
			queryContainer.style.pointerEvents = 'auto'
		}
	}
}
