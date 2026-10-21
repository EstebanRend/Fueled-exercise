/**
 * Editor sidebar panel for the staff member job title.
 *
 * `meridian_job_title` is registered post meta (see StaffMember) exposed to the
 * REST API via `custom-fields` support — that exposure is what lets this control
 * read and write the value through the editor's entity store.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { TextControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';

const StaffDetailsPanel = () => {
	const [meta, setMeta] = useEntityProp('postType', 'staff_member', 'meta');

	return (
		<PluginDocumentSettingPanel
			name="meridian-staff-details"
			title={__('Staff details', 'meridian-theme')}
		>
			<TextControl
				label={__('Job title', 'meridian-theme')}
				help={__('Shown beneath the name on the staff card.', 'meridian-theme')}
				value={meta?.meridian_job_title ?? ''}
				onChange={(value) => setMeta({ ...meta, meridian_job_title: value })}
			/>
		</PluginDocumentSettingPanel>
	);
};

const StaffMetaPlugin = () => {
	const postType = useSelect((select) => select('core/editor').getCurrentPostType(), []);

	return postType === 'staff_member' ? <StaffDetailsPanel /> : null;
};

registerPlugin('meridian-staff-meta', { render: StaffMetaPlugin });
