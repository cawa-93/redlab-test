import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

export function edit() {
	const props = useBlockProps;
	return (
		<div { ...props }>
			<ServerSideRender
				block="events-plugin/date-filter"
				attributes={ props.attributes }
			/>
		</div>
	);
}
