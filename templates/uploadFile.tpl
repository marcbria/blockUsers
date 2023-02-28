{**
 * templates/export.tpl
 *
 * Copyright (c) 2023 Marc Bria (Universitat Autònoma de Barcelona)
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @brief UI to blockUsers
 *}

{strip}
{include file="common/header.tpl" pageTitle="plugins.importexport.blockUsers.displayName"}
{/strip}

{block name="page"}
	<h1 class="app__pageHeading">
		{translate key="plugins.importexport.blockUsers.installedTitle"}
	</h1>

	{translate key="plugins.importexport.blockUsers.installedBody"}

		<!-- form method="POST" action="{plugin_url path="uploadFile"}">
			<button class="pkp_button" type="submit">{translate key="plugins.importexport.blockUsers.uploadFile"}</button>
		</form -->
	</div>
{/block}
