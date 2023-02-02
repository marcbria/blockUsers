{**
 * templates/export.tpl
 *
 * Copyright (c) 2023 Marc Bria (Universitat Autònoma de Barcelona)
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @brief UI to export publications
 *}
{extends file="layouts/backend.tpl"}

{block name="page"}
	<h1 class="app__pageHeading">
		{$pageTitle}
	</h1>

	<div class="app__contentPanel">
		<table class="pkpTable">
			<thead>
				<tr>
					<th>{translate key="plugins.importexport.blockUsers.id"}</th>
					<th>{translate key="plugins.importexport.blockUsers.title"}</th>
				</tr>
			</thead>
			<tbody>
				{foreach $publications as $publication}
					<tr>
						<td>{$publication->getId()}</td>
						<td>{$publication->getLocalizedTitle()}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>

		<form method="POST" action="{plugin_url path="exportAll"}">
			<button class="pkp_button" type="submit">{translate key="plugins.importexport.blockUsers.exportAll"}</button>
		</form>
	</div>
{/block}
