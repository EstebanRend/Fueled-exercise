import { __ } from '@wordpress/i18n';

/**
 * Shape of a staff_member REST record, requested with `_embed` so the featured
 * image and department term travel with it in a single response.
 */
export interface StaffRecord {
	id: number;
	title: { rendered: string };
	meta?: { meridian_job_title?: string };
	_embedded?: {
		'wp:featuredmedia'?: Array<{ source_url?: string }>;
		'wp:term'?: Array<Array<{ taxonomy: string; name: string }>>;
	};
}

interface StaffCardPreviewProps {
	name: string;
	jobTitle?: string;
	department?: string;
	imageUrl?: string;
}

/*
 * Editor preview of a staff member.
 *
 * Deliberately mirrors the class names emitted by the PHP presenter
 * (MeridianTheme\People\StaffCard) so the shared component styles apply to both
 * the editor and the front end. The bio is intentionally omitted here; it
 * renders on the front end from the post excerpt.
 */
export const StaffCardPreview = ({
	name,
	jobTitle = '',
	department = '',
	imageUrl = '',
}: StaffCardPreviewProps) => (
	<article className="meridian-staff-card">
		<div className="meridian-staff-card__media">
			{imageUrl ? (
				<img className="meridian-staff-card__photo" src={imageUrl} alt="" loading="lazy" />
			) : (
				<span
					className="meridian-staff-card__photo meridian-staff-card__photo--placeholder"
					aria-hidden="true"
				/>
			)}
		</div>
		<div className="meridian-staff-card__body">
			<h3 className="meridian-staff-card__name">
				{name || __('(no name)', 'meridian-theme')}
			</h3>
			{jobTitle ? <p className="meridian-staff-card__title">{jobTitle}</p> : null}
			{department ? <p className="meridian-staff-card__department">{department}</p> : null}
		</div>
	</article>
);

/**
 * Map an embedded staff_member REST record to preview props.
 *
 * @param record The staff_member record, fetched with `_embed`.
 * @returns Preview props derived from the record.
 */
export const toStaffCardProps = (record: StaffRecord): StaffCardPreviewProps => {
	const media = record._embedded?.['wp:featuredmedia']?.[0]?.source_url;

	const termGroups = record._embedded?.['wp:term'] ?? [];
	const department = termGroups.flat().find((term) => term.taxonomy === 'staff_department')?.name;

	return {
		name: record.title?.rendered ?? '',
		jobTitle: record.meta?.meridian_job_title,
		department,
		imageUrl: media,
	};
};
