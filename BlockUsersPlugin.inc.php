<?php
/**
 * @file BlockUsersPlugin.inc.php
 *
 * Copyright (c) 2023 Marc Bria (Universitat Autònoma de Barcelona)
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @class BlockUsersPlugin
 * @brief An example plugin demonstrating how to write an import/export plugin.
 */

import('lib.pkp.classes.plugins.ImportExportPlugin');

class BlockUsersPlugin extends ImportExportPlugin {
	/**
	 * @copydoc ImportExportPlugin::register()
	 */
	public function register($category, $path, $mainContextId = NULL) {
		$success = parent::register($category, $path);
		$this->addLocaleData();
		return $success;
	}

	/**
	 * @copydoc ImportExportPlugin::getName()
	 */
	public function getName() {
		return 'BlockUsersPlugin';
	}

	/**
	 * @copydoc ImportExportPlugin::getDisplayName()
	 */
	public function getDisplayName() {
		return __('plugins.importexport.blockUsers.name');
	}

	/**
	 * @copydoc ImportExportPlugin::getDescription()
	 */
	public function getDescription() {
		return __('plugins.importexport.blockUsers.description');
	}

	
	/**
	 * @copydoc ImportExportPlugin::register()
	 */
/*	public function display($args, $request) {
		parent::display($args, $request);

		// Get the journal or press id
		$contextId = Application::get()->getRequest()->getContext()->getId();

		// Use the path to determine which action should be taken.
		$path = array_shift($args);
		switch ($path) {
			// Stream a CSV file for download
			case 'uploadFile':
				header('content-type: text/comma-separated-values');
				header('content-disposition: attachment; filename=articles-' . date('Ymd') . '.csv');
				$publications = $this->getAll($contextId);
				$this->export($publications, 'php://output');
				break;

			// When no path is requested, display a list of publications
			// to export and a button to run the `uploadFile` path.
			default:
				$templateMgr = TemplateManager::getManager($request);
				$templateMgr->assign([
					'pageTitle' => __('plugins.importexport.blockUsers.name'),
					'publications' => $this->getAll($contextId),
				]);
				$templateMgr->display($this->getTemplateResource('uploadFile.tpl'));
		}
	}*/

	/**
	 * @copydoc ImportExportPlugin::executeCLI()
	 */
	/*public function executeCLI($scriptName, &$args) {
		$csvFile = array_shift($args);
		$contextId = array_shift($args);

		if (!$csvFile || !$contextId) {
			$this->usage('');
		}

		$result = $this->getAll($contextId);
		$this->export($result, $csvFile);
	}*/

	/**
	 * @copydoc ImportExportPlugin::executeCLI()
	 */
	public function executeCLI($scriptName, &$args) {
		$filename = array_shift($args);

		echo "Filename: $filename";

//		$data = file_get_contents($filename);

//		return $data;
	}


	/**
	 * @copydoc ImportExportPlugin::usage()
	 */
	public function usage($scriptName) {
		echo __('plugins.importexport.blockUsers.cliUsage', array(
			'scriptName' => $scriptName,
			'pluginName' => $this->getName()
		)) . "\n";
	}

  	/**
	 * @copydoc ImportExportPlugin::usage()
	 */
	/*public function usage($scriptName) {
		echo "Usage: " . $scriptName . " " . $this->getName() . " [filename]\n";
	}*/



	/**
	 * A helper method to stream all publications to a CSV file
	 *
	 * @param DAOResultIterator $publications Iterator with publication data
	 * @param string $filename CSV filename
	 */
	/*public function export($publicationIterator, $filename) {
		$fp = fopen($filename, 'wt');
		fputcsv($fp, ['ID', 'Title']);
		foreach ($publicationIterator as $publication) {
			fputcsv($fp, [$publication->getId(), $publication->getLocalizedTitle()]);
		}
		fclose($fp);
	}*/
}
