import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ComboboxControl, Placeholder } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import { StaffCardPreview, toStaffCardProps, type StaffRecord } from '../shared/staff-card-preview';

export const BlockEdit = (props: any) => {
	const { attributes, setAttributes } = props;
	const postId: number = attributes.postId ?? 0;
	const blockProps = useBlockProps();

	const staff = useSelect(
		(select) =>
			(select('core') as any).getEntityRecords('postType', 'staff_member', {
				per_page: -1,
				orderby: 'title',
				order: 'asc',
				_embed: true,
			}) as StaffRecord[] | null,
		[],
	);

	const options = (staff ?? []).map((member) => ({
		value: String(member.id),
		label: member.title?.rendered || __('(no name)', 'meridian-theme'),
	}));

	const selected = (staff ?? []).find((member) => member.id === postId);

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody title={__('Staff Member', 'meridian-theme')}>
					<ComboboxControl
						label={__('Choose a staff member', 'meridian-theme')}
						value={postId ? String(postId) : ''}
						options={options}
						onChange={(value) => setAttributes({ postId: value ? Number(value) : 0 })}
					/>
				</PanelBody>
			</InspectorControls>
			{selected ? (
				<StaffCardPreview {...toStaffCardProps(selected)} />
			) : (
				<Placeholder
					icon="id-alt"
					label={__('Staff Card', 'meridian-theme')}
					instructions={__('Choose a staff member to display.', 'meridian-theme')}
				/>
			)}
		</div>
	);
};
