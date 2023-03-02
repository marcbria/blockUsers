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
        function display($args, $request) {
                parent::display($args, $request);
                switch (array_shift($args)) {
                        case 'index':
			case '':
			default:
                                $templateMgr = TemplateManager::getManager($request);
                                //$templateMgr->display($this->getTemplateResource('index.tpl'));
                                $templateMgr->display($this->getTemplateResource('uploadFile.tpl'));
                                break;
                }
        }

	/**
	 * @copydoc ImportExportPlugin::executeCLI()
	 */
	public function executeCLI($scriptName, &$args) {

		// Use the path to determine which action should be taken.
		$action = array_shift($args);

		switch ($action) {

			case 'disable':
			case 'enable':

				$filename = array_shift($args);
		
				// Check the file parameter
				if ($filename) {

					// Funcion name chanAged on 3.3.0 branch:
					$userDao = DAORegistry::getDAO('UserDAO');
					if (method_exists($userDao, 'getByEmail')) {
						echo "ERROR: File [./$filename] not found\n";
						echo "Check if file exist and is readable.\n";
						return;
					}

					echo "--------------------------------------------------------------------- \n";
					echo " Filename with users to $action: $filename \n";
					echo "--------------------------------------------------------------------- \n\n";

					// Read the file and get the list of emails
					$emailList = file($filename);
					foreach ($emailList as $email) {
						// Remove any leading/trailing whitespaces
						$email = trim($email);

						$user = '';

						// Get the user with the specified email
						if (function_exists('getByEmail')) {
						    $user = $userDao->getByEmail($email);
						} else {
						    $user = $userDao->getUserByEmail($email);
						}

						if ($user) {
							echo "$action". "d: $email [ " . $user->getUsername() . " ] \n";

							if ($action == "disable") {
								$user->setDisabled(true);
							}
							else {
								$user->setDisabled(false);
							}

							$date = date('Y/m/d h:i:s', time());
							$reasonTxt=$user->getDisabledReason() . "\n";

							$reasonTxt.= ucfirst($action);
							$reasonTxt.= __('plugins.importexport.blockUsers.reason');
							$reasonTxt.= "$date <br/>\n";

							$reasonTxt.= __('plugins.importexport.blockUsers.contact') . "<br/><br/>\n";

							$user->setDisabledReason($reasonTxt);
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

			case 'sql':
				echo "Runs the sql query specified in $filename to get the user IDs to be disabled\n";
				echo "Not implemented yet...";
				break;
	
			// Plugin usage
			case 'usage':
			default:

				$this->usage($scriptName);
				break;
		}
	}


  	/**
	 * @copydoc ImportExportPlugin::usage()
	 */
	public function usage($scriptName) {
		echo "Usage: " . $scriptName . " " . $this->getName() . " [action] [filename]\n";
		echo "	> Actions: disable | enable | usage \n";
	}

}
