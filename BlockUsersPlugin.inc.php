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
	public function executeCLI($scriptName, &$args) {

		// Use the path to determine which action should be taken.
		$action = array_shift($args);

		switch ($action) {

			case 'disable':

				$filename = array_shift($args);
		
				// Check the file parameter
				if ($filename) {

					// Check if the file exists
					if (!file_exists($filename)) {
						echo "ERROR: File [./$filename] not found\n";
						echo "Check if file exist and is readable.\n";
						return;
					}

					echo "> Filename with users to disable: $filename \n";

					// Read the file and get the list of emails
					$emailList = file($filename);
					foreach ($emailList as $email) {
						// Remove any leading/trailing whitespaces
						$email = trim($email);
						// Get the user with the specified email
						$userDao = DAORegistry::getDAO('UserDAO');

						$user = '';
						// Funcion name chanAged on 3.3.0 branch:
						if (function_exists('getByEmail')) {
						    $user = $userDao->getByEmail($email);
						} else {
						    $user = $userDao->getUserByEmail($email);
						}

						if ($user) {
							echo "Disabled: $email [ " . $user->getUsername() . " ] \n";

							$user->setDisabled(true);
							$userDao->updateObject($user);
						}
						else {
							echo "Ignored: $email [ Not found ]\n";
						}
					}
				}
				else {
					echo "File not found\n";
				}
			break;

			// Plugin usage
			case 'usage':
			default:

				echo "OJS version: $version\n";
				$this->usage($scriptName);
				break;
		}
	}


  	/**
	 * @copydoc ImportExportPlugin::usage()
	 */
	public function usage($scriptName) {
		echo "Usage: " . $scriptName . " " . $this->getName() . " disable [filename]\n";
	}

}
