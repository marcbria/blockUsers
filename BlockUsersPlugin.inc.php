<?php
/**
 * @file plugins/generic/blockUsers/BlockUsersPlugin.inc.php
 *
 * Copyright (c) 2023 Marc Bria Ramírez (Universitat Autònoma de Barcelona)
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class BlockUsersPlugin
 * @ingroup plugins_generic_blockUsers
 *
 * @brief Block Users plugin class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class BlockUsersPlugin extends GenericPlugin {
	public function register($category, $path, $mainContextId = NULL) {

		// Register the plugin even when it is not enabled
		$success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
			// Do something when the plugin is enabled
		}

		return $success;
	}

	/**
	 * Provide a name for this plugin
	 *
	 * The name will appear in the Plugin Gallery where editors can
	 * install, enable and disable plugins.
	 */
	public function getDisplayName() {
		return 'Block Users';
	}

	/**
	 * Provide a description for this plugin
	 *
	 * The description will appear in the Plugin Gallery where editors can
	 * install, enable and disable plugins.
	 */
	public function getDescription() {
		return 'This plugin disables the users whose mail is listed in the uploaded document.';
	}
}