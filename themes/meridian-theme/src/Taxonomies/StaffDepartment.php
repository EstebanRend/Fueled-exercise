<?php
/**
 * Staff Department taxonomy.
 *
 * @package MeridianTheme
 */

namespace MeridianTheme\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

/**
 * Registers the `staff_department` taxonomy.
 *
 * Department is modeled as a taxonomy — a shared, controlled vocabulary — rather
 * than as a field on each staff member. See ADR-004 in the requirements decision
 * log for the rationale.
 *
 * @package MeridianTheme
 */
class StaffDepartment extends AbstractTaxonomy {

	/**
	 * Can this module be registered?
	 *
	 * @return bool
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Get the taxonomy name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'staff_department';
	}

	/**
	 * Get the singular taxonomy label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return __( 'Department', 'meridian-theme' );
	}

	/**
	 * Get the plural taxonomy label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return __( 'Departments', 'meridian-theme' );
	}

	/**
	 * Departments are a flat, controlled vocabulary shown as a checklist.
	 *
	 * @return bool
	 */
	public function is_hierarchical() {
		return true;
	}
}
