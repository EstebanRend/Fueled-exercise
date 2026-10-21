/**
 * Editor sidebar panel for testimonial attribution.
 *
 * `meridian_testimonial_role` and `meridian_testimonial_company` are registered
 * post meta (see Testimonial) exposed to the REST API via `custom-fields`
 * support — that exposure is what lets these controls read and write the values
 * through the editor's entity store.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { TextControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';

const TestimonialDetailsPanel = () => {
	const [meta, setMeta] = useEntityProp('postType', 'testimonial', 'meta');

	return (
		<PluginDocumentSettingPanel
			name="meridian-testimonial-details"
			title={__('Attribution', 'meridian-theme')}
		>
			<TextControl
				label={__('Role', 'meridian-theme')}
				value={meta?.meridian_testimonial_role ?? ''}
				onChange={(value) => setMeta({ ...meta, meridian_testimonial_role: value })}
			/>
			<TextControl
				label={__('Company', 'meridian-theme')}
				value={meta?.meridian_testimonial_company ?? ''}
				onChange={(value) => setMeta({ ...meta, meridian_testimonial_company: value })}
			/>
		</PluginDocumentSettingPanel>
	);
};

const TestimonialMetaPlugin = () => {
	const postType = useSelect((select) => select('core/editor').getCurrentPostType(), []);

	return postType === 'testimonial' ? <TestimonialDetailsPanel /> : null;
};

registerPlugin('meridian-testimonial-meta', { render: TestimonialMetaPlugin });
