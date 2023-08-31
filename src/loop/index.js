/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import {registerBlockType, registerBlockVariation} from '@wordpress/blocks';


const MY_VARIATION_NAME = 'events-plugin/events-loop';

registerBlockVariation('core/query', {
		name: MY_VARIATION_NAME,
		title: 'Events Loop',
		description: 'Displays a list of events',
		isActive: ({namespace, query}) => {
			return (
				namespace === MY_VARIATION_NAME
				&& query.postType === 'event'
			);
		},
		attributes: {
			namespace: MY_VARIATION_NAME,
			query: {
				perPage: 6,
				pages: 0,
				offset: 0,
				postType: 'event',
				order: 'desc',
				orderBy: 'date',
				author: '',
				search: '',
				exclude: [],
				sticky: '',
				inherit: false,
			},
		},
		allowedControls: ['order'],
		scope: ['inserter'],

	innerBlocks: [
		[ 'events-plugin/date-filter' ],
		[ 'events-plugin/location-filter' ],
		[
			'core/post-template',
			{},
			[ [ 'core/post-title' ], [ 'core/post-excerpt' ] ],
		],
		[ 'core/query-pagination' ],
	],
	}
);

//
// /**
//  * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
//  * All files containing `style` keyword are bundled together. The code used
//  * gets applied both to the front of your site and to the editor.
//  *
//  * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
//  */
// import './style.scss';
//
// /**
//  * Internal dependencies
//  */
// import Edit from './edit';
// import save from './save';
// import metadata from './block.json';
//
// /**
//  * Every block starts by registering a new block type definition.
//  *
//  * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
//  */
// registerBlockType( metadata.name, {
// 	/**
// 	 * @see ./edit.js
// 	 */
// 	edit: Edit,
//
// 	/**
// 	 * @see ./save.js
// 	 */
// 	save,
// } );
